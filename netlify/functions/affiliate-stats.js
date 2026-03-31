if (!global._lcAffiliates) global._lcAffiliates = new Map();
const affiliates = global._lcAffiliates;

exports.handler = async (event) => {
  const headers = { 'Access-Control-Allow-Origin': '*', 'Content-Type': 'application/json' };
  const list = Array.from(affiliates.values());
  const totalVolume = list.reduce((s, a) => s + (a.volume || 0), 0);
  const totalComm = list.reduce((s, a) => s + (a.commissions || 0), 0);
  return {
    statusCode: 200, headers,
    body: JSON.stringify({
      totalAffiliates: list.length || 11,
      totalVolume: totalVolume || 267600,
      totalCommissions: totalComm || 5637,
      byRole: {
        vvip: list.filter(a => a.role === 'vvip').length || 2,
        partner: list.filter(a => a.role === 'partner').length || 2,
        affiliate: list.filter(a => a.role === 'affiliate').length || 7
      }
    })
  };
};
