const crypto = require('crypto');

if (!global._lcUsers) global._lcUsers = new Map();
if (!global._lcAffiliates) global._lcAffiliates = new Map();
const users = global._lcUsers;
const affiliates = global._lcAffiliates;

function hashPw(pw) {
  return crypto.createHash('sha256').update(pw + '-secret').digest('hex');
}
function simpleToken(payload) {
  return Buffer.from(JSON.stringify({ ...payload, exp: Date.now() + 30*24*60*60*1000 })).toString('base64url');
}

exports.handler = async (event) => {
  const headers = { 'Access-Control-Allow-Origin': '*', 'Content-Type': 'application/json' };
  if (event.httpMethod === 'OPTIONS') return { statusCode:200, headers:{ ...headers,'Access-Control-Allow-Methods':'POST,OPTIONS','Access-Control-Allow-Headers':'*' }, body:'' };
  if (event.httpMethod !== 'POST') return { statusCode:405, body:'Method Not Allowed' };

  const { name, email, password, role = 'affiliate', referralCode } = JSON.parse(event.body || '{}');
  if (!name || !email || !password) return { statusCode:400, headers, body: JSON.stringify({ error: 'Champs manquants' }) };
  if (users.has(email)) return { statusCode:400, headers, body: JSON.stringify({ error: 'Email déjà utilisé' }) };
  if (password.length < 8) return { statusCode:400, headers, body: JSON.stringify({ error: 'Mot de passe trop court (8 min)' }) };

  const code = 'LC-' + crypto.randomBytes(4).toString('hex').toUpperCase();
  const sponsorCode = referralCode && affiliates.has(referralCode) ? referralCode : null;
  const user = { name, email, passwordHash: hashPw(password), role, code, memberCode: code, sponsorCode, volume: 0, commissions: 0, status: 'Actif', createdAt: new Date() };
  users.set(email, user);
  affiliates.set(code, { ...user });

  const token = simpleToken({ email, code, role, name });
  return { statusCode:200, headers, body: JSON.stringify({ token, user: { name, email, role, memberCode: code }, code }) };
};
