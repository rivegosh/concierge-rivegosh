exports.handler = async (event) => {
  const headers = { 'Access-Control-Allow-Origin': '*', 'Content-Type': 'application/json' };
  if (event.httpMethod === 'OPTIONS') return { statusCode:200, headers:{ ...headers,'Access-Control-Allow-Methods':'POST,OPTIONS','Access-Control-Allow-Headers':'*' }, body:'' };

  const stripe = require('stripe')(process.env.STRIPE_SECRET_KEY);
  if (!process.env.STRIPE_SECRET_KEY) return { statusCode:500, headers, body: JSON.stringify({ error: 'Stripe non configuré — ajoutez STRIPE_SECRET_KEY dans les variables d\'environnement Netlify' }) };

  const { amount, currency = 'eur', serviceType, referralCode } = JSON.parse(event.body || '{}');
  if (!amount) return { statusCode:400, headers, body: JSON.stringify({ error: 'Montant requis' }) };

  try {
    const pi = await stripe.paymentIntents.create({
      amount: Math.round(amount * 100), currency,
      metadata: { serviceType: serviceType || 'concierge', referralCode: referralCode || '' }
    });
    return { statusCode:200, headers, body: JSON.stringify({ clientSecret: pi.client_secret, paymentIntentId: pi.id }) };
  } catch (e) {
    return { statusCode:500, headers, body: JSON.stringify({ error: e.message }) };
  }
};
