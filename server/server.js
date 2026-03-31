/**
 * LUXURY CONCIERGE — Server Backend
 * Node.js + Express
 * Auth (JWT) · Stripe Payments · MLM 5 Niveaux · Admin
 */

require('dotenv').config();
const express = require('express');
const cors = require('cors');
const crypto = require('crypto');
const path = require('path');

// Optional deps
let jwt, stripe, bcrypt;
try { jwt = require('jsonwebtoken'); } catch { console.warn('[WARN] jsonwebtoken not found — auth disabled'); }
try { stripe = require('stripe')(process.env.STRIPE_SECRET_KEY || 'sk_test_...'); } catch { console.warn('[WARN] stripe not found — payments disabled'); }
try { bcrypt = require('bcryptjs'); } catch { console.warn('[WARN] bcryptjs not found — using simple hash'); }

const app = express();
app.use(cors());
app.use(express.json());
app.use(express.static('.'));

const PORT = process.env.PORT || 3000;
const JWT_SECRET = process.env.JWT_SECRET || 'luxury-concierge-secret-key-2026';
const PLATFORM_FEE_PCT = parseFloat(process.env.PLATFORM_FEE_PCT || '0.15');

// ═══════════════════════════════════════════════════
// IN-MEMORY STORES (replace with DB in production)
// ═══════════════════════════════════════════════════
const users = new Map();          // email → UserRecord
const affiliates = new Map();     // code → AffiliateRecord
const transactions = [];          // ConversionRecord[]
const serviceRequests = [];       // ServiceRequest[]
const payoutRequests = [];        // PayoutRequest[]

// MLM Commission Rates (5 levels)
const MLM_RATES = { 1: 0.12, 2: 0.07, 3: 0.04, 4: 0.02, 5: 0.01 };
const MIN_PAYOUT = parseFloat(process.env.AFFILIATE_MIN_PAYOUT || '50');

// ═══════════════════════════════════════════════════
// HELPERS
// ═══════════════════════════════════════════════════
function generateCode(prefix = 'LC') {
  return `${prefix}-${crypto.randomBytes(4).toString('hex').toUpperCase()}`;
}

function hashPassword(pw) {
  if (bcrypt) return bcrypt.hashSync(pw, 10);
  return crypto.createHash('sha256').update(pw + JWT_SECRET).digest('hex');
}

function checkPassword(pw, hash) {
  if (bcrypt) return bcrypt.compareSync(pw, hash);
  return crypto.createHash('sha256').update(pw + JWT_SECRET).digest('hex') === hash;
}

function signToken(payload) {
  if (jwt) return jwt.sign(payload, JWT_SECRET, { expiresIn: '30d' });
  return Buffer.from(JSON.stringify(payload)).toString('base64');
}

function verifyToken(token) {
  try {
    if (jwt) return jwt.verify(token, JWT_SECRET);
    return JSON.parse(Buffer.from(token, 'base64').toString());
  } catch { return null; }
}

function authMiddleware(req, res, next) {
  const auth = req.headers.authorization;
  if (!auth || !auth.startsWith('Bearer ')) return res.status(401).json({ error: 'Non autorisé' });
  const decoded = verifyToken(auth.slice(7));
  if (!decoded) return res.status(401).json({ error: 'Token invalide' });
  req.user = decoded;
  next();
}

// Find affiliate chain up to N levels
function getUplineChain(affiliateCode, maxLevel = 5) {
  const chain = [];
  let current = affiliates.get(affiliateCode);
  while (current && chain.length < maxLevel) {
    if (!current.sponsorCode) break;
    const sponsor = affiliates.get(current.sponsorCode);
    if (!sponsor) break;
    chain.push(sponsor);
    current = sponsor;
  }
  return chain;
}

// Count network by level
function getNetworkStats(code) {
  const byLevel = {};
  for (let i = 1; i <= 5; i++) byLevel[i] = 0;
  function traverse(parentCode, level) {
    if (level > 5) return;
    for (const [, aff] of affiliates) {
      if (aff.sponsorCode === parentCode) {
        byLevel[level] = (byLevel[level] || 0) + 1;
        traverse(aff.code, level + 1);
      }
    }
  }
  traverse(code, 1);
  return byLevel;
}

// ═══════════════════════════════════════════════════
// SEED DATA
// ═══════════════════════════════════════════════════
function seedData() {
  // Root affiliate
  const root = {
    code: 'LC-DEMO1234', name: 'Alexandre Dupont', email: 'demo@luxuryconcierge.com',
    role: 'vvip', sponsorCode: null, volume: 228000, commissions: 2847,
    networkSize: 47, createdAt: new Date('2025-01-15'), status: 'Actif'
  };
  affiliates.set(root.code, root);
  users.set(root.email, { ...root, passwordHash: hashPassword('demo1234') });

  const n1 = [
    { code: 'LC-S0PH1E', name: 'Sophie Moreau', email: 'sophie@lc.com', role: 'affiliate', volume: 9500, commissions: 1140 },
    { code: 'LC-R0MA1N', name: 'Romain Dubois', email: 'romain@lc.com', role: 'partner', volume: 7200, commissions: 864 },
    { code: 'LC-P1ERR3', name: 'Pierre Vidal', email: 'pierre@lc.com', role: 'affiliate', volume: 6600, commissions: 792 },
    { code: 'LC-EMM4MA', name: 'Emma Martin', email: 'emma@lc.com', role: 'affiliate', volume: 2900, commissions: 348 },
  ];
  for (const a of n1) {
    const rec = { ...a, sponsorCode: root.code, networkSize: 0, createdAt: new Date('2025-03-01'), status: 'Actif' };
    affiliates.set(a.code, rec);
    users.set(a.email, { ...rec, passwordHash: hashPassword('demo1234') });
  }

  const n2 = [
    { code: 'LC-CL41RF', name: 'Claire Fontaine', email: 'claire@lc.com', sponsorCode: 'LC-S0PH1E', role: 'affiliate', volume: 4800, commissions: 336 },
    { code: 'LC-JUL1NK', name: 'Julien Klein', email: 'julien@lc.com', sponsorCode: 'LC-R0MA1N', role: 'partner', volume: 3200, commissions: 224 },
    { code: 'LC-MAR1EL', name: 'Marie Leclerc', email: 'marie@lc.com', sponsorCode: 'LC-R0MA1N', role: 'affiliate', volume: 1800, commissions: 126 },
  ];
  for (const a of n2) {
    const rec = { ...a, networkSize: 0, createdAt: new Date('2025-06-01'), status: 'Actif' };
    affiliates.set(a.code, rec);
    users.set(a.email, { ...rec, passwordHash: hashPassword('demo1234') });
  }

  const n3 = [
    { code: 'LC-TH0M4S', name: 'Thomas Vincent', email: 'thomas@lc.com', sponsorCode: 'LC-CL41RF', role: 'vvip', volume: 2100, commissions: 84 },
    { code: 'LC-LUC4SB', name: 'Lucas Bernard', email: 'lucas@lc.com', sponsorCode: 'LC-JUL1NK', role: 'affiliate', volume: 600, commissions: 24 },
  ];
  for (const a of n3) {
    const rec = { ...a, networkSize: 0, createdAt: new Date('2025-09-01'), status: 'Actif' };
    affiliates.set(a.code, rec);
    users.set(a.email, { ...rec, passwordHash: hashPassword('demo1234') });
  }

  const n4 = [
    { code: 'LC-AN4ROS', name: 'Ana Rosa', email: 'ana@lc.com', sponsorCode: 'LC-TH0M4S', role: 'affiliate', volume: 900, commissions: 18 },
  ];
  for (const a of n4) {
    const rec = { ...a, networkSize: 0, createdAt: new Date('2025-11-01'), status: 'Actif' };
    affiliates.set(a.code, rec);
    users.set(a.email, { ...rec, passwordHash: hashPassword('demo1234') });
  }

  // Seed some transactions
  const txns = [
    { memberCode: 'LC-S0PH1E', amount: 950, service: 'Voyage privé', referralCode: 'LC-S0PH1E' },
    { memberCode: 'LC-R0MA1N', amount: 12000, service: 'Suite Four Seasons', referralCode: 'LC-R0MA1N' },
    { memberCode: 'LC-CL41RF', amount: 600, service: 'Conciergerie', referralCode: 'LC-CL41RF' },
    { memberCode: 'LC-TH0M4S', amount: 2100, service: 'Yacht', referralCode: 'LC-TH0M4S' },
  ];
  for (const t of txns) {
    transactions.push({ ...t, date: new Date(), validated: true, id: generateCode('TXN') });
  }

  console.log(`[SEED] ${affiliates.size} affiliés · ${users.size} utilisateurs · ${transactions.length} transactions`);
}

// ═══════════════════════════════════════════════════
// AUTH ROUTES
// ═══════════════════════════════════════════════════
app.post('/auth/register', async (req, res) => {
  const { name, email, password, role = 'affiliate', referralCode } = req.body;
  if (!name || !email || !password) return res.status(400).json({ error: 'Champs manquants' });
  if (users.has(email)) return res.status(400).json({ error: 'Email déjà utilisé' });
  if (password.length < 8) return res.status(400).json({ error: 'Mot de passe trop court' });

  const code = generateCode('LC');
  const passwordHash = hashPassword(password);
  let sponsorCode = null;

  if (referralCode && affiliates.has(referralCode)) {
    sponsorCode = referralCode;
  }

  const user = { name, email, passwordHash, role, code, memberCode: code, sponsorCode, volume: 0, commissions: 0, networkSize: 0, status: 'Actif', createdAt: new Date() };
  users.set(email, user);
  affiliates.set(code, { ...user });

  const token = signToken({ email, code, role, name });
  const safeUser = { name, email, role, memberCode: code, code };
  res.json({ token, user: safeUser, code });
});

app.post('/auth/login', async (req, res) => {
  const { email, password } = req.body;
  if (!email || !password) return res.status(400).json({ error: 'Champs manquants' });
  const user = users.get(email);
  if (!user) return res.status(401).json({ error: 'Email introuvable' });
  if (!checkPassword(password, user.passwordHash)) return res.status(401).json({ error: 'Mot de passe incorrect' });

  const token = signToken({ email, code: user.code, role: user.role, name: user.name });
  const safeUser = { name: user.name, email, role: user.role, memberCode: user.code, code: user.code };
  res.json({ token, user: safeUser });
});

app.get('/auth/me', authMiddleware, (req, res) => {
  const user = users.get(req.user.email);
  if (!user) return res.status(404).json({ error: 'Introuvable' });
  const { passwordHash, ...safe } = user;
  res.json(safe);
});

// ═══════════════════════════════════════════════════
// MEMBER ROUTES
// ═══════════════════════════════════════════════════
app.get('/member/stats', authMiddleware, (req, res) => {
  const user = users.get(req.user.email);
  if (!user) return res.status(404).json({ error: 'Membre introuvable' });
  const byLevel = getNetworkStats(user.code);
  const networkSize = Object.values(byLevel).reduce((a, b) => a + b, 0);
  const networkVolume = user.volume || 0;
  const totalCommissions = user.commissions || 0;

  res.json({ totalCommissions, networkSize, networkVolume, byLevel });
});

app.get('/member/commissions', authMiddleware, (req, res) => {
  const user = users.get(req.user.email);
  if (!user) return res.status(404).json({ error: 'Introuvable' });

  // Find commissions where this user is in the upline chain
  const userComms = transactions.filter(t => {
    const aff = affiliates.get(t.referralCode);
    if (!aff) return false;
    const chain = getUplineChain(aff.code);
    return chain.some(u => u.code === user.code);
  }).map(t => {
    const aff = affiliates.get(t.referralCode);
    const chain = getUplineChain(aff.code);
    const level = chain.findIndex(u => u.code === user.code) + 1;
    const rate = MLM_RATES[level] || 0;
    return { from: aff.name, amount: Math.round(t.amount * rate), level, date: new Date(t.date).toLocaleDateString('fr-FR') };
  });

  const byLevel = {};
  for (let i = 1; i <= 5; i++) byLevel[i] = 0;
  for (const c of userComms) byLevel[c.level] = (byLevel[c.level] || 0) + c.amount;
  const total = Object.values(byLevel).reduce((a, b) => a + b, 0);

  res.json({ commissions: userComms, byLevel, total, pending: total * 0.15, month: total * 0.22 });
});

// ═══════════════════════════════════════════════════
// AFFILIATE ROUTES
// ═══════════════════════════════════════════════════
app.post('/affiliate/register', (req, res) => {
  const { name, email, role = 'affiliate', referralCode, isAdminCreate } = req.body;
  if (!name || !email) return res.status(400).json({ error: 'Nom et email requis' });

  const code = generateCode('LC');
  let sponsorCode = null;
  if (referralCode && affiliates.has(referralCode)) sponsorCode = referralCode;

  const record = { name, email, code, role, sponsorCode, volume: 0, commissions: 0, networkSize: 0, status: 'Actif', createdAt: new Date() };
  affiliates.set(code, record);
  if (!users.has(email)) {
    users.set(email, { ...record, passwordHash: hashPassword(Math.random().toString(36)) });
  }

  res.json({ code, ...record });
});

app.get('/affiliate/admin/all', (req, res) => {
  const list = Array.from(affiliates.values()).map(({ passwordHash, ...a }) => a);
  res.json({ affiliates: list, total: list.length });
});

app.get('/affiliate/admin/stats', (req, res) => {
  const list = Array.from(affiliates.values());
  const totalVolume = list.reduce((s, a) => s + (a.volume || 0), 0);
  const totalComm = list.reduce((s, a) => s + (a.commissions || 0), 0);
  res.json({ totalAffiliates: list.length, totalVolume, totalCommissions: totalComm, byRole: { vvip: list.filter(a => a.role === 'vvip').length, partner: list.filter(a => a.role === 'partner').length, affiliate: list.filter(a => a.role === 'affiliate').length } });
});

app.get('/affiliate/:code', (req, res) => {
  const aff = affiliates.get(req.params.code);
  if (!aff) return res.status(404).json({ error: 'Affilié introuvable' });
  const { passwordHash, ...safe } = aff;
  res.json(safe);
});

app.get('/affiliate/:code/network', (req, res) => {
  const aff = affiliates.get(req.params.code);
  if (!aff) return res.status(404).json({ error: 'Affilié introuvable' });
  const byLevel = getNetworkStats(req.params.code);
  const members = [];
  function traverse(parentCode, level) {
    if (level > 5) return;
    for (const [, a] of affiliates) {
      if (a.sponsorCode === parentCode) {
        members.push({ name: a.name, code: a.code, level, volume: `€${(a.volume || 0).toLocaleString()}`, status: a.status });
        traverse(a.code, level + 1);
      }
    }
  }
  traverse(req.params.code, 1);
  res.json({ byLevel, members });
});

app.post('/affiliate/track-conversion', async (req, res) => {
  const { referralCode, amount, service, memberId } = req.body;
  if (!referralCode || !amount) return res.status(400).json({ error: 'Données manquantes' });

  const txn = { id: generateCode('TXN'), referralCode, amount, service, memberId, date: new Date(), validated: false };
  transactions.push(txn);

  // Distribute commissions up to 5 levels
  const commissions = [];
  const aff = affiliates.get(referralCode);
  if (aff) {
    const chain = [aff, ...getUplineChain(aff.code)];
    for (let i = 0; i < chain.length && i < 5; i++) {
      const level = i + 1;
      const rate = MLM_RATES[level] || 0;
      const commAmt = Math.round(amount * rate * 100) / 100;
      if (commAmt > 0) {
        commissions.push({ beneficiary: chain[i].code, level, amount: commAmt });
        // Update affiliate record
        const record = affiliates.get(chain[i].code);
        if (record) { record.commissions = (record.commissions || 0) + commAmt; record.volume = (record.volume || 0) + (i === 0 ? amount : 0); }
      }
    }
  }

  const platformFee = Math.round(amount * PLATFORM_FEE_PCT * 100) / 100;
  res.json({ txnId: txn.id, commissions, platformFee });
});

app.post('/affiliate/request-payout', authMiddleware, (req, res) => {
  const user = users.get(req.user.email);
  if (!user) return res.status(404).json({ error: 'Utilisateur introuvable' });
  const aff = affiliates.get(user.code);
  if (!aff) return res.status(404).json({ error: 'Affilié introuvable' });
  if ((aff.commissions || 0) < MIN_PAYOUT) return res.status(400).json({ error: `Minimum de virement : €${MIN_PAYOUT}` });

  const payout = { id: generateCode('PAY'), code: aff.code, name: aff.name, amount: aff.commissions, requestedAt: new Date(), status: 'pending' };
  payoutRequests.push(payout);
  aff.commissions = 0;

  res.json({ message: 'Demande de virement enregistrée', payoutId: payout.id, amount: payout.amount });
});

// ═══════════════════════════════════════════════════
// SERVICE REQUEST ROUTES
// ═══════════════════════════════════════════════════
app.post('/service/request', authMiddleware, (req, res) => {
  const { type, description, date, budget, priority = 'standard' } = req.body;
  if (!type || !description) return res.status(400).json({ error: 'Type et description requis' });

  const req_obj = { id: generateCode('SRQ'), userEmail: req.user.email, userName: req.user.name, type, description, date, budget, priority, status: 'pending', createdAt: new Date() };
  serviceRequests.push(req_obj);
  res.json({ id: req_obj.id, message: 'Demande envoyée avec succès' });
});

app.get('/service/requests', authMiddleware, (req, res) => {
  const myReqs = serviceRequests.filter(r => r.userEmail === req.user.email);
  res.json({ requests: myReqs });
});

app.get('/admin/requests', (req, res) => {
  res.json({ requests: serviceRequests });
});

// ═══════════════════════════════════════════════════
// STRIPE PAYMENT ROUTES
// ═══════════════════════════════════════════════════
app.post('/payments/create-intent', authMiddleware, async (req, res) => {
  if (!stripe) return res.status(500).json({ error: 'Stripe non configuré' });
  const { amount, currency = 'eur', serviceType, referralCode } = req.body;
  if (!amount) return res.status(400).json({ error: 'Montant requis' });

  try {
    const paymentIntent = await stripe.paymentIntents.create({
      amount: Math.round(amount * 100),
      currency,
      metadata: { serviceType: serviceType || 'concierge', referralCode: referralCode || '', userEmail: req.user.email }
    });
    res.json({ clientSecret: paymentIntent.client_secret, paymentIntentId: paymentIntent.id });
  } catch (e) {
    res.status(500).json({ error: e.message });
  }
});

app.post('/webhook/stripe', express.raw({ type: 'application/json' }), async (req, res) => {
  if (!stripe) return res.sendStatus(200);
  const sig = req.headers['stripe-signature'];
  let event;
  try {
    event = stripe.webhooks.constructEvent(req.body, sig, process.env.STRIPE_WEBHOOK_SECRET || '');
  } catch (e) {
    return res.status(400).json({ error: 'Webhook invalide' });
  }

  if (event.type === 'payment_intent.succeeded') {
    const pi = event.data.object;
    const { referralCode, userEmail, serviceType } = pi.metadata;
    if (referralCode) {
      const amount = pi.amount_received / 100;
      // Auto-track conversion
      const txn = { id: generateCode('TXN'), referralCode, amount, service: serviceType, memberId: userEmail, date: new Date(), validated: true };
      transactions.push(txn);
      // Distribute commissions
      const aff = affiliates.get(referralCode);
      if (aff) {
        const chain = [aff, ...getUplineChain(aff.code)];
        for (let i = 0; i < chain.length && i < 5; i++) {
          const rate = MLM_RATES[i + 1] || 0;
          const commAmt = Math.round(amount * rate * 100) / 100;
          const record = affiliates.get(chain[i].code);
          if (record && commAmt > 0) { record.commissions = (record.commissions || 0) + commAmt; }
        }
      }
    }
  }

  res.sendStatus(200);
});

// ═══════════════════════════════════════════════════
// ADMIN ROUTES
// ═══════════════════════════════════════════════════
app.get('/admin/stats', (req, res) => {
  const aff = Array.from(affiliates.values());
  const totalRevenue = aff.reduce((s, a) => s + (a.volume || 0), 0);
  const totalCommissions = aff.reduce((s, a) => s + (a.commissions || 0), 0);
  res.json({
    totalMembers: users.size,
    totalAffiliates: aff.length,
    totalRevenue,
    totalCommissions,
    totalTransactions: transactions.length,
    pendingPayouts: payoutRequests.filter(p => p.status === 'pending').length,
    pendingRequests: serviceRequests.filter(r => r.status === 'pending').length,
    byRole: { vvip: aff.filter(a => a.role === 'vvip').length, partner: aff.filter(a => a.role === 'partner').length, affiliate: aff.filter(a => a.role === 'affiliate').length }
  });
});

app.get('/admin/payouts', (req, res) => {
  res.json({ payouts: payoutRequests });
});

app.post('/admin/payouts/:id/approve', (req, res) => {
  const payout = payoutRequests.find(p => p.id === req.params.id);
  if (!payout) return res.status(404).json({ error: 'Virement introuvable' });
  payout.status = 'approved';
  payout.approvedAt = new Date();
  res.json({ message: 'Virement approuvé', payout });
});

// ═══════════════════════════════════════════════════
// STATIC FILES
// ═══════════════════════════════════════════════════
app.get('/', (req, res) => res.sendFile(path.join(__dirname, 'index.html')));
app.get('/dashboard', (req, res) => res.sendFile(path.join(__dirname, 'dashboard.html')));
app.get('/affiliation', (req, res) => res.sendFile(path.join(__dirname, 'affiliation.html')));
app.get('/partenaires', (req, res) => res.sendFile(path.join(__dirname, 'partenaires.html')));
app.get('/admin', (req, res) => res.sendFile(path.join(__dirname, 'admin.html')));
app.get('/ref/:code', (req, res) => {
  // Cookie tracking + redirect
  res.cookie('lc_ref', req.params.code, { maxAge: 90 * 24 * 60 * 60 * 1000, httpOnly: true });
  res.redirect(`/?ref=${req.params.code}`);
});

// ═══════════════════════════════════════════════════
// DÉMARRAGE
// ═══════════════════════════════════════════════════
app.listen(PORT, () => {
  console.log(`
  ╔══════════════════════════════════════╗
  ║   LUXURY CONCIERGE — Server v1.0    ║
  ║   http://localhost:${PORT}              ║
  ╚══════════════════════════════════════╝`);
  seedData();
});

module.exports = app;
