const crypto = require('crypto');
if (!global._lcAffiliates) global._lcAffiliates = new Map();
if (!global._lcTransactions) global._lcTransactions = [];
const affiliates = global._lcAffiliates;
const transactions = global._lcTransactions;

const MLM_RATES = { 1: 0.12, 2: 0.07, 3: 0.04, 4: 0.02, 5: 0.01 };

function getUpline(code, max = 5) {
  const chain = [];
  let cur = affiliates.get(code);
  while (cur && chain.length < max) {
    if (!cur.sponsorCode) break;
    const sponsor = affiliates.get(cur.sponsorCode);
    if (!sponsor) break;
    chain.push(sponsor);
    cur = sponsor;
  }
  return chain;
}

exports.handler = async (event) => {
  if (event.httpMethod !== 'POST') return { statusCode: 405, body: 'Method Not Allowed' };
  const { referralCode, amount, service } = JSON.parse(event.body || '{}');
  if (!referralCode || !amount) return { statusCode: 400, body: JSON.stringify({ error: 'referralCode et amount requis' }) };

  const txn = { id: 'TXN-' + crypto.randomBytes(4).toString('hex').toUpperCase(), referralCode, amount, service, date: new Date(), validated: false };
  transactions.push(txn);

  const commissions = [];
  const aff = affiliates.get(referralCode);
  if (aff) {
    const chain = [aff, ...getUpline(aff.code)];
    for (let i = 0; i < Math.min(chain.length, 5); i++) {
      const rate = MLM_RATES[i + 1] || 0;
      const commAmt = Math.round(amount * rate * 100) / 100;
      commissions.push({ beneficiary: chain[i].code, name: chain[i].name, level: i + 1, amount: commAmt, rate: `${rate * 100}%` });
      const rec = affiliates.get(chain[i].code);
      if (rec) { rec.commissions = (rec.commissions || 0) + commAmt; if (i === 0) rec.volume = (rec.volume || 0) + amount; }
    }
  }

  return {
    statusCode: 200,
    headers: { 'Access-Control-Allow-Origin': '*', 'Content-Type': 'application/json' },
    body: JSON.stringify({ txnId: txn.id, commissions, total: commissions.reduce((s, c) => s + c.amount, 0) })
  };
};
