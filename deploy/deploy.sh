#!/bin/bash
# ============================================================
# Luxury Concierge — Script de déploiement VPS
# ============================================================
set -e

APP_DIR="/var/www/luxury-concierge"
LOG_DIR="/var/log/luxury-concierge"
NGINX_CONF="/etc/nginx/sites-available/luxury-concierge"

echo "🚀 Déploiement Luxury Concierge..."

# 1. Créer les répertoires
echo "📁 Création des répertoires..."
sudo mkdir -p "$APP_DIR/pages"
sudo mkdir -p "$APP_DIR/server"
sudo mkdir -p "$LOG_DIR"
sudo chown -R $USER:$USER "$APP_DIR"
sudo chown -R $USER:$USER "$LOG_DIR"

# 2. Copier les fichiers
echo "📋 Copie des fichiers..."
cp -r ../pages/* "$APP_DIR/pages/"
cp -r ../server/* "$APP_DIR/server/"

# 3. Installer les dépendances Node.js
echo "📦 Installation des dépendances..."
cd "$APP_DIR/server"
npm install --production

# 4. Configurer les variables d'environnement
if [ ! -f "$APP_DIR/server/.env" ]; then
    echo "⚙️  Copie du fichier .env.example → .env"
    cp .env.example .env
    echo "⚠️  IMPORTANT: Éditer $APP_DIR/server/.env avec vos vraies valeurs !"
fi

# 5. Nginx
echo "🌐 Configuration Nginx..."
sudo cp "$SCRIPT_DIR/nginx.conf" "$NGINX_CONF"
sudo sed -i "s/votre-domaine.com/$DOMAIN/g" "$NGINX_CONF" 2>/dev/null || true
sudo ln -sf "$NGINX_CONF" /etc/nginx/sites-enabled/luxury-concierge
sudo nginx -t && sudo systemctl reload nginx

# 6. PM2
echo "⚡ Démarrage avec PM2..."
cd "$APP_DIR"
cp deploy/ecosystem.config.js .
pm2 start ecosystem.config.js --env production
pm2 save
pm2 startup | tail -1 | bash || true

echo ""
echo "✅ Déploiement terminé !"
echo ""
echo "📌 Prochaines étapes :"
echo "   1. Éditer $APP_DIR/server/.env avec vos clés Stripe et JWT"
echo "   2. Configurer SSL : sudo certbot --nginx -d votre-domaine.com"
echo "   3. Redémarrer : pm2 restart luxury-concierge"
echo ""
echo "🔗 L'application sera accessible sur : http://$(hostname -I | awk '{print $1}')"
