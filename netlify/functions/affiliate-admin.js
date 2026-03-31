if (!global._lcAffiliates) global._lcAffiliates = new Map();
const affiliates = global._lcAffiliates;

function getDemoAccounts() {
  return [
    { code:'LC-DEMO1234', name:'Alexandre Dupont', email:'demo@luxuryconcierge.com', role:'vvip', sponsorCode:null, volume:228000, commissions:2847, status:'Actif' },
    { code:'LC-S0PH1E', name:'Sophie Moreau', email:'sophie@lc.com', role:'affiliate', sponsorCode:'LC-DEMO1234', volume:9500, commissions:1140, status:'Actif' },
    { code:'LC-R0MA1N', name:'Romain Dubois', email:'romain@lc.com', role:'partner', sponsorCode:'LC-DEMO1234', volume:7200, commissions:864, status:'Actif' },
    { code:'LC-P1ERR3', name:'Pierre Vidal', email:'pierre@lc.com', role:'affiliate', sponsorCode:'LC-DEMO1234', volume:6600, commissions:792, status:'Actif' },
    { code:'LC-CL41RF', name:'Claire Fontaine', email:'claire@lc.com', role:'affiliate', sponsorCode:'LC-S0PH1E', volume:4800, commissions:336, status:'Actif' },
    { code:'LC-JUL1NK', name:'Julien Klein', email:'julien@lc.com', role:'partner', sponsorCode:'LC-R0MA1N', volume:3200, commissions:224, status:'Actif' },
    { code:'LC-EMM4MA', name:'Emma Martin', email:'emma@lc.com', role:'affiliate', sponsorCode:'LC-DEMO1234', volume:2900, commissions:348, status:'Actif' },
    { code:'LC-TH0M4S', name:'Thomas Vincent', email:'thomas@lc.com', role:'vvip', sponsorCode:'LC-CL41RF', volume:2100, commissions:84, status:'Actif' },
    { code:'LC-MAR1EL', name:'Marie Leclerc', email:'marie@lc.com', role:'affiliate', sponsorCode:'LC-R0MA1N', volume:1800, commissions:126, status:'Inactif' },
    { code:'LC-AN4ROS', name:'Ana Rosa', email:'ana@lc.com', role:'affiliate', sponsorCode:'LC-TH0M4S', volume:900, commissions:18, status:'Actif' },
    { code:'LC-LUC4SB', name:'Lucas Bernard', email:'lucas@lc.com', role:'affiliate', sponsorCode:'LC-JUL1NK', volume:600, commissions:6, status:'Actif' },
  ];
}

exports.handler = async (event) => {
  const headers = { 'Access-Control-Allow-Origin': '*', 'Content-Type': 'application/json' };
  if (event.httpMethod === 'OPTIONS') return { statusCode:200, headers:{ ...headers,'Access-Control-Allow-Methods':'GET,OPTIONS','Access-Control-Allow-Headers':'*' }, body:'' };

  const list = affiliates.size > 0
    ? Array.from(affiliates.values())
    : getDemoAccounts();

  return { statusCode:200, headers, body: JSON.stringify({ affiliates: list, total: list.length }) };
};
