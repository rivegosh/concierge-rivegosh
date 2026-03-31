const crypto = require('crypto');

// Shared in-memory store (use DB in production)
if (!global._lcAffiliates) global._lcAffiliates = new Map();
if (!global._lcUsers) global._lcUsers = new Map();

const affiliates = global._lcAffiliates;
const users = global._lcUsers;

// Seed demo data once
if (affiliates.size === 0) {
  const seed = [
    { code:'LC-DEMO1234', name:'Alexandre Dupont', email:'demo@luxuryconcierge.com', role:'vvip', sponsorCode:null, volume:228000, commissions:2847 },
    { code:'LC-S0PH1E', name:'Sophie Moreau', email:'sophie@lc.com', role:'affiliate', sponsorCode:'LC-DEMO1234', volume:9500, commissions:1140 },
    { code:'LC-R0MA1N', name:'Romain Dubois', email:'romain@lc.com', role:'partner', sponsorCode:'LC-DEMO1234', volume:7200, commissions:864 },
    { code:'LC-CL41RF', name:'Claire Fontaine', email:'claire@lc.com', role:'affiliate', sponsorCode:'LC-S0PH1E', volume:4800, commissions:336 },
    { code:'LC-TH0M4S', name:'Thomas Vincent', email:'thomas@lc.com', role:'vvip', sponsorCode:'LC-CL41RF', volume:2100, commissions:84 },
    { code:'LC-AN4ROS', name:'Ana Rosa', email:'ana@lc.com', role:'affiliate', sponsorCode:'LC-TH0M4S', volume:900, commissions:18 },
  ];
  for (const s of seed) { affiliates.set(s.code, { ...s, status:'Actif', createdAt: new Date() }); }
}

exports.handler = async (event) => {
  if (event.httpMethod === 'OPTIONS') return { statusCode:200, headers:{ 'Access-Control-Allow-Origin':'*','Access-Control-Allow-Headers':'*','Access-Control-Allow-Methods':'POST,OPTIONS' }, body:'' };
  if (event.httpMethod !== 'POST') return { statusCode:405, body: JSON.stringify({ error: 'Méthode non autorisée' }) };

  let body;
  try { body = JSON.parse(event.body || '{}'); } catch { return { statusCode:400, body: JSON.stringify({ error: 'JSON invalide' }) }; }

  const { name, email, role = 'affiliate', referralCode, password } = body;
  if (!name || !email) return { statusCode:400, body: JSON.stringify({ error: 'Nom et email requis' }) };

  const code = 'LC-' + crypto.randomBytes(4).toString('hex').toUpperCase();
  const sponsorCode = referralCode && affiliates.has(referralCode) ? referralCode : null;
  const record = { name, email, code, role, sponsorCode, volume: 0, commissions: 0, status: 'Actif', createdAt: new Date() };
  affiliates.set(code, record);

  return {
    statusCode: 200,
    headers: { 'Access-Control-Allow-Origin': '*', 'Content-Type': 'application/json' },
    body: JSON.stringify({ code, name, email, role, sponsorCode, message: 'Compte créé avec succès' })
  };
};
