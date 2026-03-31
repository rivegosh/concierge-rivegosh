const crypto = require('crypto');

if (!global._lcUsers) global._lcUsers = new Map();
const users = global._lcUsers;

// Demo user always works
const DEMO = {
  email: 'demo@luxuryconcierge.com',
  passwordHash: crypto.createHash('sha256').update('demo1234-secret').digest('hex'),
  name: 'Alexandre Dupont', role: 'vvip', memberCode: 'LC-DEMO1234', code: 'LC-DEMO1234'
};

function simpleToken(payload) {
  return Buffer.from(JSON.stringify({ ...payload, exp: Date.now() + 30*24*60*60*1000 })).toString('base64url');
}

function hashPw(pw) {
  return crypto.createHash('sha256').update(pw + '-secret').digest('hex');
}

exports.handler = async (event) => {
  const headers = { 'Access-Control-Allow-Origin': '*', 'Content-Type': 'application/json' };
  if (event.httpMethod === 'OPTIONS') return { statusCode:200, headers:{ ...headers,'Access-Control-Allow-Methods':'POST,OPTIONS','Access-Control-Allow-Headers':'*' }, body:'' };
  if (event.httpMethod !== 'POST') return { statusCode:405, body:'Method Not Allowed' };

  const { email, password } = JSON.parse(event.body || '{}');
  if (!email || !password) return { statusCode:400, headers, body: JSON.stringify({ error: 'Email et mot de passe requis' }) };

  let user = users.get(email);
  if (!user && email === DEMO.email) user = DEMO;
  if (!user) return { statusCode:401, headers, body: JSON.stringify({ error: 'Email introuvable' }) };

  const hash = hashPw(password);
  if (hash !== user.passwordHash && !(email === DEMO.email && password === 'demo1234'))
    return { statusCode:401, headers, body: JSON.stringify({ error: 'Mot de passe incorrect' }) };

  const token = simpleToken({ email, code: user.code || user.memberCode, role: user.role, name: user.name });
  const safeUser = { name: user.name, email, role: user.role, memberCode: user.code || user.memberCode };
  return { statusCode:200, headers, body: JSON.stringify({ token, user: safeUser }) };
};
