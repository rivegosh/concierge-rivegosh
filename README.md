# Luxury Concierge — Guide d'installation

**Plateforme B2B & B2C de conciergerie de prestige avec MLM 5 niveaux**

---

## Structure du projet

```
luxury-concierge-install/
├── pages/                    ← Frontend HTML (5 pages)
│   ├── index.html            ← Landing page principale
│   ├── dashboard.html        ← Espace membre / tableau de bord
│   ├── affiliation.html      ← Gestion MLM & réseau
│   ├── partenaires.html      ← Annuaire partenaires prestige
│   └── admin.html            ← Panneau d'administration
├── netlify/
│   └── functions/            ← API Serverless (Netlify)
│       ├── auth-login.js
│       ├── auth-register.js
│       ├── affiliate-register.js
│       ├── affiliate-admin.js
│       ├── affiliate-stats.js
│       ├── affiliate-track.js
│       └── stripe-payment.js
├── server/                   ← Serveur Node.js (hébergement classique)
│   ├── server.js
│   ├── package.json
│   └── .env.example
├── deploy/                   ← Scripts de déploiement
│   ├── deploy.sh
│   ├── ecosystem.config.js   ← PM2 config
│   └── nginx.conf
└── netlify.toml              ← Configuration Netlify
```

---

## Option 1 — Déploiement Netlify (recommandé, gratuit)

### Étape 1 : Préparer le dépôt

```bash
# Cloner ou créer un repo GitHub
git init luxury-concierge
cd luxury-concierge
cp -r /chemin/vers/luxury-concierge-install/* .
git add .
git commit -m "Initial Luxury Concierge deploy"
git remote add origin https://github.com/VOTRE_USER/luxury-concierge.git
git push -u origin main
```

### Étape 2 : Connecter à Netlify

1. Aller sur [netlify.com](https://netlify.com) → **Add new site** → **Import from Git**
2. Sélectionner votre dépôt GitHub
3. Paramètres de build :
   - **Build command** : *(laisser vide)*
   - **Publish directory** : `pages`
   - **Functions directory** : `netlify/functions`
4. Cliquer **Deploy site**

### Étape 3 : Variables d'environnement Netlify

Dans **Site settings → Environment variables**, ajouter :

| Variable | Valeur | Description |
|---|---|---|
| `STRIPE_SECRET_KEY` | `sk_live_...` | Clé secrète Stripe (production) |
| `STRIPE_PUBLISHABLE_KEY` | `pk_live_...` | Clé publique Stripe |
| `STRIPE_WEBHOOK_SECRET` | `whsec_...` | Secret webhook Stripe |

> **Test** : Utiliser `sk_test_...` / `pk_test_...` pour les tests Stripe

### Étape 4 : Configurer le webhook Stripe

1. Stripe Dashboard → **Developers → Webhooks** → **Add endpoint**
2. URL : `https://VOTRE-SITE.netlify.app/.netlify/functions/stripe-payment`
3. Événements : `payment_intent.succeeded`, `payment_intent.payment_failed`

---

## Option 2 — Serveur Node.js (VPS / dédié)

### Prérequis

- Node.js 18+
- npm 9+
- PM2 (process manager) : `npm install -g pm2`
- Nginx (proxy inverse)

### Installation

```bash
cd server/
npm install
cp .env.example .env
# Éditer .env avec vos valeurs
nano .env
```

### Variables d'environnement (server/.env)

```env
PORT=3000
NODE_ENV=production

# JWT
JWT_SECRET=VOTRE_SECRET_JWT_TRES_LONG_ET_SECURISE

# Stripe
STRIPE_SECRET_KEY=sk_live_VOTRE_CLE_STRIPE
STRIPE_PUBLISHABLE_KEY=pk_live_VOTRE_CLE_PUBLIQUE
STRIPE_WEBHOOK_SECRET=whsec_VOTRE_SECRET_WEBHOOK

# Plateforme
PLATFORM_FEE_PCT=0.15
PLATFORM_NAME=Luxury Concierge

# Base de données (optionnel — en mémoire par défaut)
# DATABASE_URL=postgresql://user:password@localhost:5432/luxuryconcierge
```

### Démarrage avec PM2

```bash
# Depuis le dossier server/
pm2 start ecosystem.config.js --env production
pm2 save
pm2 startup
```

### Configuration Nginx

```bash
sudo cp ../deploy/nginx.conf /etc/nginx/sites-available/luxury-concierge
sudo ln -s /etc/nginx/sites-available/luxury-concierge /etc/nginx/sites-enabled/
sudo nginx -t
sudo systemctl reload nginx
```

---

## Option 3 — Test local (sans installation)

Les pages HTML fonctionnent entièrement en **mode démo** sans serveur :

```bash
cd pages/
python3 -m http.server 8080
# Ouvrir : http://localhost:8080
```

**Compte démo** :
- Email : `demo@luxuryconcierge.com`
- Mot de passe : `demo1234`

---

## Fonctionnalités

| Fonctionnalité | Description |
|---|---|
| **Auth** | Inscription/connexion JWT, rôles (Client VVIP / Partenaire B2B / Admin) |
| **MLM 5 niveaux** | N1=12%, N2=7%, N3=4%, N4=2%, N5=1% sur chaque transaction |
| **Paiements Stripe** | PaymentIntents, 3D Secure 2.0, PCI-DSS Level 1 |
| **Affiliation** | QR codes personnalisés, tracking 90 jours, tableau réseau |
| **Partenaires** | 12 partenaires prestige, filtres par catégorie, candidatures |
| **Admin** | KPIs, validation virements, gestion membres, export CSV |
| **Multilangue** | FR / EN / 中文 / ES / AR |
| **Demo mode** | Données pré-chargées, fonctionne sans backend |

---

## Architecture MLM

```
Vente de 10 000€
├── N1 (Affilié direct)     → 1 200€ (12%)
├── N2 (Parrain N1)         →   700€  (7%)
├── N3 (Parrain N2)         →   400€  (4%)
├── N4 (Parrain N3)         →   200€  (2%)
└── N5 (Parrain N4)         →   100€  (1%)
                              ───────
Total commissions           → 2 600€ (26%)
Plateforme (frais)          → 1 500€ (15%)
```

---

## Support & Personnalisation

Pour toute question sur le déploiement ou la personnalisation de la plateforme, consulter la documentation Netlify : [docs.netlify.com](https://docs.netlify.com)

---

*Luxury Concierge — Plateforme de conciergerie de prestige*
