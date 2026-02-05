# 🚀 ASBL-ONG-MANAGER - Système de Gestion Complet

[![PHP Version](https://img.shields.io/badge/PHP-8.3+-777BB4?style=for-the-badge&logo=php&logoColor=white)](https://php.net)
[![MySQL Version](https://img.shields.io/badge/MySQL-8.0+-4479A1?style=for-the-badge&logo=mysql&logoColor=white)](https://mysql.com)
[![License](https://img.shields.io/badge/License-MIT-98C511?style=for-the-badge)](LICENSE)
[![Version](https://img.shields.io/badge/Version-1.0-FF6B35?style=for-the-badge)](https://github.com/dontka/asbl-ong-manager)

> **Plateforme de gestion d'organisation tout-en-un, modulaire, intelligente, collaborative et conforme, couvrant tous les besoins métiers d'une ONG, association ou entreprise moderne.**

---

## 📋 Table des Matières

- [✨ Vue d'ensemble](#-vue-densemble)
- [🎯 Fonctionnalités](#-fonctionnalités)
- [🛠️ Technologies](#️-technologies)
- [📦 Installation](#-installation)
- [⚙️ Configuration](#️-configuration)
- [🚀 Utilisation](#-utilisation)
- [🏗️ Architecture](#️-architecture)
- [📊 Scripts et Outils](#-scripts-et-outils)
- [🔧 Développement](#-développement)
- [🌐 Déploiement](#-déploiement)
- [🐛 Dépannage & Troubleshooting](#-dépannage--troubleshooting)
- [🤝 Contribution](#-contribution)
- [📞 Support et Documentation](#-support-et-documentation)
- [📄 Licence](#-licence)

---

## ✨ Vue d'ensemble

**ASBL-ONG-Manager** est une plateforme web complète développée en **PHP 8.3+ pur** (sans framework lourd) pour la gestion efficace des organisations à but non lucratif, associations et entreprises sociales. 

Le système offre une interface intuitive et sécurisée pour gérer les membres, événements, projets, finances et dons avec un focus sur :
- 🔐 **Sécurité** : Authentification robuste, CSRF, XSS protection
- ⚡ **Performance** : Optimisé pour la rapidité et la scalabilité
- 📱 **Praticité** : Interface responsive et user-friendly
- 🔧 **Extensibilité** : Architecture modulaire et pluggable
- 📊 **Reporting** : Tableaux de bord et rapports avancés

### 🎯 Cas d'usage
- ✅ Associations caritatives - Gestion des bénévoles et dons
- ✅ Clubs sportifs - Organisation d'événements et suivi des membres
- ✅ Organisations environnementales - Gestion de projets et campagnes
- ✅ Groupes communautaires - Coordination d'activités et communication
- ✅ ONG internationales - Gestion complexe multi-entités

---

## 🎯 Fonctionnalités

### 👥 Gestion des Membres
- ✅ Inscription et gestion des profils membres
- ✅ Suivi des adhésions et statuts
- ✅ Historique des participations et contributions
- ✅ Documents et attestations personnelles
- ✅ Export des données (CSV, PDF)
- ✅ Segmentation et recherche avancée

### 📅 Gestion des Événements
- ✅ Création et organisation d'événements
- ✅ Gestion des inscriptions et confirmations
- ✅ Suivi des présences et listes participantes
- ✅ Notifications automatiques (SMS, Email)
- ✅ Calendrier intégré et synchronisation
- ✅ Rapports de participation

### 🎯 Gestion des Projets
- ✅ Planification et suivi d'avancement
- ✅ Gestion budgétaire par projet
- ✅ Assignation des responsables et équipes
- ✅ Jalons et livrables
- ✅ Rapports de progression automatisés
- ✅ Collaboration et commentaires d'équipe

### 💰 Gestion des Dons & Finances
- ✅ Suivi des contributions financières
- ✅ Génération de reçus fiscaux
- ✅ Gestion des budgets multi-projets
- ✅ Rapports financiers détaillés
- ✅ Intégration de paiements multiples
- ✅ Historique complet des transactions

### 🔐 Sécurité et Authentification
- ✅ Système de rôles granulaire (Admin, RH, Membre, etc.)
- ✅ Authentification sécurisée (bcrypt/password_hash)
- ✅ Protection CSRF sur tous les formulaires
- ✅ Protection XSS et injection SQL
- ✅ Logs d'audit complets et traçabilité
- ✅ Gestion fine des permissions par rôle

### 📊 Rapports et Analytics
- ✅ Tableaux de bord personnalisés par rôle
- ✅ Exports multiformats (CSV, PDF, Excel)
- ✅ Statistiques en temps réel
- ✅ Rapports automatisés programmables
- ✅ Graphiques et visualisations
- ✅ KPIs métier (retention, engagement, etc.)

---

## 🛠️ Technologies

### Backend
```
🐘 PHP 8.3+              Langage principal orienté objet
🗄️  MySQL 8.0+           Base de données relationnelle
🔒 PDO                   Accès sécurisé à la base de données
🛡️  OpenSSL              Chiffrement des données sensibles
🔐 bcrypt/password_hash  Hashage sécurisé des mots de passe
```

### Frontend
```
🌐 HTML5                 Structure sémantique
🎨 CSS3                  Styles modernes et responsive
⚡ JavaScript ES6+       Interactivité et dynamicité
🎯 Font Awesome 6        Icônes professionnelles
🔧 Bootstrap 5 (optionnel) Framework CSS
```

### Outils et Dépendances
```
🔧 Composer              Gestion des dépendances PHP
🐙 Git                   Contrôle de version
📦 npm/yarn              Gestion des assets (optionnel)
🧪 PHPUnit               Framework de test (optionnel)
```

### Environnements Supportés
- ✅ **Développement** : XAMPP, Laragon, WAMP, Docker
- ✅ **Production** : Apache/Nginx + MySQL sur Linux
- ✅ **Cloud** : AWS, DigitalOcean, Heroku, OVH, etc.

---

## 📦 Installation

### Prérequis Système

#### Minimaux
- **PHP** : 8.0 ou supérieur
- **MySQL** : 8.0 ou supérieur
- **Serveur Web** : Apache 2.4+ ou Nginx 1.18+
- **Espace disque** : 100+ MB

#### Extensions PHP requises
```bash
php -m | grep -E "(pdo|pdo_mysql|mbstring|session|json|openssl|filter|hash)"
```

Essentielles :
- `pdo` et `pdo_mysql` - Accès base de données
- `mbstring` - Support Unicode/UTF-8
- `session` - Gestion des sessions
- `json` - Encodage/décodage JSON
- `openssl` - Chiffrement SSL/TLS
- `filter` - Filtrage des données
- `hash` - Fonctions de hash (bcrypt)

### Installation Automatisée (Recommandée) ⚡

**Plus simple et plus rapide !** L'assistant `install.php` guide à travers toutes les étapes.

```bash
# 1. Cloner le repository
git clone https://github.com/dontka/asbl-ong-manager.git
cd asbl-ong-manager

# 2. Installer les dépendances (optionnel)
composer install

# 3. Démarrer le serveur local
php -S localhost:8000
# Ou utiliser Laragon/XAMPP (plus recommandé)

# 4. Accéder à l'assistant installation
Ouvrez: http://localhost:8000/install.php
Ou si Laragon: http://asbl-ong-manager.test/install.php

# ✅ L'assistant crée tout automatiquement :
#    - Base de données
#    - Tables et schéma
#    - Données de test
#    - Compte administrateur

# 5. Connexion après installation
#    URL: http://localhost:8000
#    Email: admin@asbl-ong.org
#    Password: (celui que vous avez défini dans l'assistant)
```

### Installation Manuelle - Étapes Détaillées 🔧

Si vous préférez la configuration manuelle :

```bash
# 1. Télécharger l'archive
# Depuis https://github.com/dontka/asbl-ong-manager/releases/latest

# 2. Extraire dans le répertoire web
unzip asbl-ong-manager-main.zip
mv asbl-ong-manager-main /var/www/asbl-ong-manager
cd /var/www/asbl-ong-manager

# 3. Copier et configurer le .env
cp "exemple env" .env
nano .env  # Éditer avec vos paramètres

# Paramètres clés à configurer :
# DB_HOST=localhost
# DB_USER=your_mysql_user
# DB_PASS=your_mysql_password
# DB_NAME=asbl_ong_manager
# APP_URL=http://localhost/asbl-ong-manager

# 4. Créer la base de données (si elle n'existe pas)
mysql -u root -p << EOF
CREATE DATABASE asbl_ong_manager CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
CREATE USER 'asbl_user'@'localhost' IDENTIFIED BY 'secure_password';
GRANT ALL PRIVILEGES ON asbl_ong_manager.* TO 'asbl_user'@'localhost';
FLUSH PRIVILEGES;
EOF

# 5. Importer le schéma et données de test
mysql -u asbl_user -p asbl_ong_manager < database/schema.sql
mysql -u asbl_user -p asbl_ong_manager < database/test_data.sql

# 6. Configurer les permissions (Linux/Mac)
chmod 755 .
chmod 755 uploads logs temp cache
chmod 644 config.php .env
chown -R www-data:www-data .

# 7. Créer le fichier verrou d'installation
touch installed.lock

# 8. Accéder à l'application
# http://localhost/asbl-ong-manager/
```
## ⚙️ Configuration

### Variables d'Environnement (`.env`) 🔐

Le fichier `.env` contient **toutes les variables de configuration sensibles**. Il est chargé automatiquement par `config.php` au démarrage.

#### Créer le fichier `.env`

```bash
# Copier depuis le modèle
cp "exemple env" .env
```

#### Contenu type du `.env`

```bash
# ===== BASE DE DONNÉES =====
DB_HOST=localhost
DB_USER=root
DB_PASS=
DB_NAME=asbl_ong_manager
DB_CHARSET=utf8mb4

# ===== APPLICATION =====
APP_NAME=ASBL-ONG Manager
APP_VERSION=1.0.0
APP_DEBUG=true                           # false en production
APP_ENV=local                           # local|production|staging
APP_LOCALE=fr
APP_TIMEZONE=Europe/Paris
APP_URL=http://localhost/asbl-ong-manager

# ===== SÉCURITÉ & AUTHENTIFICATION =====
AUTH_METHOD=local
AUTH_MFA=false
AUTH_SSO=false
SESSION_LIFETIME=3600
CSRF_ENABLED=true
ENCRYPTION_KEY=change_me_in_production

# ===== MODULES MÉTIER (ACTIVATION) =====
MODULE_HR=true
MODULE_FINANCE=true
MODULE_PROJECT=true
MODULE_CRM=true
MODULE_DOCUMENT=true
MODULE_GOVERNANCE=true

# ===== EMAIL & NOTIFICATIONS =====
MAIL_DRIVER=smtp
MAIL_HOST=localhost
MAIL_PORT=1025
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM=noreply@asbl-ong.org
MAIL_ENCRYPTION=null
NOTIFICATIONS_ENABLED=true

# ===== STOCKAGE & FICHIERS =====
STORAGE_DRIVER=local
STORAGE_PATH=storage/
MAX_UPLOAD_SIZE=10485760                # 10MB

# ===== JOURNALISATION & CACHE =====
LOG_LEVEL=debug                         # debug|info|warning|error|critical
CACHE_DRIVER=file
QUEUE_DRIVER=sync
```

#### Charger depuis `.env` dans le code

```php
<?php
// config.php charge automatiquement le .env
define('DB_NAME', getenv('DB_NAME') ?: 'asbl_ong_manager');
define('APP_DEBUG', getenv('APP_DEBUG') ?: 'true');
// ... etc
?>
```

⚠️ **IMPORTANT** :
- Le `.env` est **ignoré automatiquement** par Git (voir `.gitignore`)
- Ne jamais commiter le `.env` en production
- Modifier `.env` pour adapter à votre environnement

### Configuration Avancée - `config.php` 🔧

Le fichier `config.php` **charge automatiquement depuis le `.env`** et définit les constantes globales :

```php
<?php
// config.php - Configuration centralisée (demarre facilement à partir de .env)

// 1. Chargement du .env
loadEnv(__DIR__ . '/.env');  // Ajoute les variables à $_ENV

// 2. Définition des chemins principaux
define('ROOT_PATH', __DIR__ . '/');
define('DATABASE_PATH', ROOT_PATH . 'database/');
define('MODELS_PATH', ROOT_PATH . 'models/');
define('CONTROLLERS_PATH', ROOT_PATH . 'controllers/');
define('VIEWS_PATH', ROOT_PATH . 'views/');
// ... etc

// 3. Chargement des configurations depuis .env
define('APP_NAME', getenv('APP_NAME') ?: 'ASBL-ONG Manager');
define('APP_DEBUG', getenv('APP_DEBUG') ?: 'true');
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_NAME', getenv('DB_NAME') ?: 'asbl_ong_manager');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
// ... autres

// 4. Chargement des fichiers de sécurité
require_once INCLUDES_PATH . 'security_headers.php';
require_once INCLUDES_PATH . 'csrf.php';
require_once INCLUDES_PATH . 'sanitize.php';
?>
```

**Flux de chargement** : `.env` → `config.php` → Toute l'application

### Permissions Fichiers (Linux/Mac)

```bash
# Structure des permissions
chmod 755 .                    # Répertoire racine
chmod 755 public/              # Fichiers publics
chmod 755 uploads/ logs/ cache/# Répertoires accessibles en écriture
chmod 644 *.php                # Fichiers PHP
chmod 640 config.php .env      # Fichiers sensibles

# Propriétaire
chown -R www-data:www-data /var/www/asbl-ong-manager
```

---

## 🚀 Utilisation Rapide

### Premiers Pas 🎯

1. **Assistant Installation** → Ouvrez `http://localhost/asbl-ong-manager/install.php`
2. **Remplir le formulaire** → Base de données, utilisateur MySQL, email admin
3. **Installation automatique** → Crée base, schéma, données de test
4. **Connexion** → `http://localhost/asbl-ong-manager/` avec vos identifiants
5. **Documentation** → Consultez les guides fournis (voir table des matières)

### Identifiants de Test 🧪

Après l'installation, plusieurs comptes de test sont disponibles :

```
📧 Administrator
  Email: admin@asbl-ong.org
  Password: (celui défini dans l'assistant install.php)
  Rôle: Admin - Accès complet

👥 HR Manager
  Email: hr@asbl-ong.org
  Password: (voir test_data.sql)
  Rôle: Responsable RH

💰 Accountant
  Email: accountant@asbl-ong.org
  Password: (voir test_data.sql)
  Rôle: Comptable

📊 Project Manager
  Email: pm@asbl-ong.org
  Password: (voir test_data.sql)
  Rôle: Chef de Projet
```

**⚠️ SÉCURITÉ EN PRODUCTION** :
```bash
# 1. Changer le mot de passe admin immédiatement
# 2. Supprimer les comptes de test
# 3. Activer HTTPS/SSL
# 4. Désactiver APP_DEBUG dans le .env
# 5. Changer ENCRYPTION_KEY dans le .env
```

### Raccourcis Clavier

| Raccourci | Action |
|-----------|--------|
| `Ctrl + S` | Sauvegarder formulaire |
| `Ctrl + F` | Ouvrir recherche |
| `Échap` | Annuler/Fermer dialogue |
| `Ctrl + N` | Nouveau formulaire |
| `Alt + H` | Aller à l'accueil |
| `Alt + L` | Se déconnecter |

---

## 🏗️ Architecture

### Pattern MVC (Modèle-Vue-Contrôleur)

**Pour la structure complète détaillée**, consultez [STRUCTURE_AVANCEE.md](STRUCTURE_AVANCEE.md)

```
asbl-ong-manager/
├── controllers/      # Contrôleurs (UserController, MemberController, etc.)
├── models/          # Classes modèles (User, Member, Event, etc.)
├── views/           # Templates par module
│   ├── auth/
│   ├── dashboard/
│   ├── members/
│   ├── events/
│   ├── projects/
│   └── ...
├── config/          # Configuration (roles.php, security.php, modules.php)
├── includes/        # Utilitaires (security_headers.php, sanitize.php, cache.php)
├── database/        # Schémas SQL et seeds
│   ├── schema.sql
│   ├── migrations/
│   └── seeds/
├── assets/          # CSS, JS, images
├── api/             # Endpoints REST (optionnel)
├── plugins/         # Plugins/extensions tiers
├── docs/            # Documentation technique
├── logs/            # Fichiers de logs
├── uploads/         # Fichiers uploadés
├── index.php        # Point d'entrée principal
├── install.php      # Script d'installation
├── config.php       # Configuration principale
└── autoloader.php   # Chargement automatique des classes
```

### Flux de Données

```
Utilisateur
    ↓
index.php (Point d'entrée)
    ↓
core/router.php (Analyse la requête)
    ↓
Contrôleur (logique de route)
    ↓
Modèle (logique métier)
    ↓
Base de Données
    ↓
Modèle (retour données)
    ↓
Vue (template HTML)
    ↓
Réponse HTML au navigateur
```

### Hiérarchie des Rôles

Voir [ROLES.md](ROLES.md) pour la documentation complète des rôles et permissions.

Rôles principaux :
1. **Administrateur** - Accès complet
2. **Responsable RH** - Gestion personnel
3. **Comptable/Trésorier** - Gestion finances
4. **Chef de Projet** - Gestion projets
5. **Chargé de Relation** - Gestion contacts/CRM
6. **Membre/Utilisateur** - Accès limité


## 🌐 Déploiement

### Environnements

#### Développement (local)
```bash
APP_ENV=development
DEBUG_MODE=true
LOG_LEVEL=debug
DISPLAY_ERRORS=true
```

#### Staging (pré-production)
```bash
APP_ENV=staging
DEBUG_MODE=false
LOG_LEVEL=info
DISPLAY_ERRORS=false
```

#### Production (public)
```bash
APP_ENV=production
DEBUG_MODE=false
LOG_LEVEL=warning
DISPLAY_ERRORS=false
```

### Configuration Apache

```apache
# .htaccess à la racine du projet
<IfModule mod_rewrite.c>
    RewriteEngine On
    RewriteBase /asbl-ong-manager/

    # Rediriger . et .. vers index.php
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteRule ^(.*)$ index.php [QSA,L]

    # Sécurité - Bloquer l'accès aux fichiers sensibles
    <FilesMatch "\.(env|sql|lock|json)$">
        Order Allow,Deny
        Deny from all
    </FilesMatch>

    # Sécurité - Désactiver list browsing
    Options -Indexes
</IfModule>

# Sécurité - Headers HTTP
<IfModule mod_headers.c>
    Header set X-Content-Type-Options "nosniff"
    Header set X-Frame-Options "SAMEORIGIN"
    Header set X-XSS-Protection "1; mode=block"
    Header set Referrer-Policy "strict-origin-when-cross-origin"
</IfModule>
```

### Configuration Nginx

```nginx
server {
    listen 80;
    listen [::]:80;
    server_name your-domain.com www.your-domain.com;
    root /var/www/asbl-ong-manager;
    index index.php;

    # Logs
    access_log /var/log/nginx/asbl-ong-manager-access.log;
    error_log /var/log/nginx/asbl-ong-manager-error.log;

    # Gzip compression
    gzip on;
    gzip_types text/plain text/css text/javascript application/json;

    # Rewriting
    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    # PHP
    location ~ \.php$ {
        include fastcgi_params;
        fastcgi_pass unix:/var/run/php/php8.3-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $document_root$fastcgi_script_name;
        fastcgi_param PATH_INFO $fastcgi_path_info;
    }

    # Sécurité - Bloquer les fichiers sensibles
    location ~ /(config|logs|database|tests|vendor)/ {
        deny all;
        return 404;
    }

    location ~ /\. {
        deny all;
    }

    # Cache des assets statiques
    location ~* \.(jpg|jpeg|png|gif|ico|css|js|svg|woff|woff2|ttf)$ {
        expires 1y;
        add_header Cache-Control "public, immutable";
    }

    # Redirection HTTP -> HTTPS (si certificat SSL actif)
    # return 301 https://$server_name$request_uri;
}

# HTTPS (décommenter après certificat SSL)
# server {
#     listen 443 ssl http2;
#     ... (configuration identique + SSL)
# }
```

### SSL/TLS - Let's Encrypt

```bash
# Installation Certbot
sudo apt-get install certbot python3-certbot-nginx

# Générer le certificat
sudo certbot --nginx -d your-domain.com -d www.your-domain.com

# Renouvellement automatique
sudo certbot renew --dry-run
```

### Performance et Optimisation

#### Caching
```php
// Activer OPcache PHP
php.ini
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000
```

#### CDN et Assets
```html
<!-- Utiliser un CDN pour les libraries -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
```

## 🐛 Dépannage & Troubleshooting

### Problèmes Courants

### Erreur : "Installé verouille" (installed.lock)

```bash
Le fichier installed.lock empêche de relancer installation.php

# Solution :
rm installed.lock

# Puis réaccédez à install.php pour réinitialiser
```

### Erreur : Connexion MySQL refusée

```bash
Vérifications :
1. MySQL est démarré ?
   sudo systemctl start mysql    # Linux
   # Ou via Laragon/XAMPP panel

2. Identifiants corrects dans .env ?
   DB_HOST, DB_USER, DB_PASS

3. Utilisateur MySQL existe ?
   mysql -u root -p
   SHOW GRANTS FOR 'asbl_user'@'localhost';
```

### Erreur : "Base de données n'existe pas ou tables manquent"

```bash
# Importer manuellement le schéma :
mysql -u root -p asbl_ong_manager < database/schema.sql

# Importer les données de test :
mysql -u root -p asbl_ong_manager < database/test_data.sql

# Vérifier :
mysql -u root -p
USE asbl_ong_manager;
SHOW TABLES;
```

### Performance : Activation d'OPcache

```bash
# Éditer php.ini
sudo nano /etc/php/8.3/apache2/php.ini

# Ajouter :
opcache.enable=1
opcache.memory_consumption=256
opcache.interned_strings_buffer=16
opcache.max_accelerated_files=10000

# Redémarrer Apache
sudo systemctl restart apache2
```

### App lente ou pages blanches

```bash
# 1. Vérifier les logs d'erreur PHP
tail -f /var/log/php-errors.log

# 2. Activer le debug mode temporairement
# Éditer .env :
APP_DEBUG=true
LOG_LEVEL=debug

# 3. Vérifier les permissions
chmod 755 uploads logs cache
chown -R www-data:www-data .

# 4. Effacer le cache
rm -rf temp/*
rm -rf cache/*
```


## 🤝 Contribution

### Processus de Contribution

1. **Fork** le projet sur GitHub
2. **Clone** votre fork :
   ```bash
   git clone https://github.com/your-username/asbl-ong-manager.git
   cd asbl-ong-manager
   ```

3. **Créez une branche** pour votre feature :
   ```bash
   git checkout -b feature/ma-nouvelle-fonctionnalite
   git checkout -b fix/correction-bug-xyz
   ```

4. **Commitez** vos changements :
   ```bash
   git commit -m "feat: Ajout de la nouvelle fonctionnalité"
   git commit -m "fix: Correction du bug XYZ"
   git commit -m "docs: Mise à jour de la documentation"
   ```

5. **Poussez** votre branche :
   ```bash
   git push origin feature/ma-nouvelle-fonctionnalite
   ```

6. **Créez une Pull Request** sur GitHub avec :
   - Description claire de vos changements
   - Référence aux issues associées
   - Tests effectués
   - Screenshots si pertinent


### Checklist de Contribution

Avant de soumettre une PR :

- [ ] Code suit les standards du projet
- [ ] Tests passent (si applicable)
- [ ] Documentation mise à jour
- [ ] Pas de `console.log()` ou `var_dump()` en production
- [ ] Sécurité vérifiée (pas d'injection SQL, XSS, etc.)
- [ ] Commit messages clairs et en français
- [ ] Pas de fusion de branche accidentelle
- [ ] Rebase sur `main` avant la PR

### Branches et Versioning

```
main (branche stable, production)
└── develop (branche de développement)
    ├── feature/nouvelle-fonctionnalite (nouvelles features)
    ├── fix/correction-bug (corrections)
    └── docs/mise-a-jour (documentation)
```

**Versioning** : SemVer (Major.Minor.Patch)
- `1.0.0` → `1.0.1` (patch - bug fix)
- `1.0.0` → `1.1.0` (minor - nouvelle feature compatible)
- `1.0.0` → `2.0.0` (major - breaking change)

---

## 📞 Support et Documentation

### 📚 Documentation Officielle

| Document | Description |
|----------|-------------|
| [LOGIN_GUIDE.md](LOGIN_GUIDE.md) | Guide de connexion et identifiants |
| [ROLES.md](ROLES.md) | Description des rôles et permissions |
| [STRUCTURE_AVANCEE.md](STRUCTURE_AVANCEE.md) | Architecture technique détaillée |
| [PLAN_FONCTIONNALITES_AVANCEES.md](PLAN_FONCTIONNALITES_AVANCEES.md) | Plan de développement et modules |
| [FAKER_INSTALLATION.md](FAKER_INSTALLATION.md) | Installation des données de test |

### 🤔 FAQ - Questions Fréquentes

**Q: Comment changer le mot de passe admin ?**
```php
$newPassword = password_hash('new_password', PASSWORD_BCRYPT);
$db->query("UPDATE users SET password = ? WHERE username = 'admin'", [$newPassword]);
```

**Q: Comment ajouter un nouvel utilisateur ?**
- Via l'interface : Admin > Gestion des utilisateurs > Créer
- Via base de données : Voir [LOGIN_GUIDE.md](LOGIN_GUIDE.md)

**Q: Comment exporter les données ?**
- Via l'interface : Chaque module a une option "Exporter"
- Formats supportés : CSV, PDF, Excel

**Q: Puis-je utiliser une autre base de données ?**
- Actuellement : MySQL/MariaDB uniquement
- Futur : Support PostgreSQL prévu

### 💬 Canaux de Support

#### 📧 Email
- **Support général** : schor@alwaysdata.net
- **Sécurité critique** : schor@alwaysdata.net

#### 🌐 En ligne
- **GitHub Issues** : [Signaler un bug](https://github.com/dontka/asbl-ong-manager/issues)
- **Discussions** : [Forum communautaire](https://github.com/dontka/asbl-ong-manager/discussions)

#### 📱 Contact Direct
- **Téléphone** : +243 973 768 153 (heures ouvrables, fuseau horaire Afrika/Kinshasa)
- **WhatsApp** : +243 973 768 153

#### 🚨 Problèmes Critiques
Pour les problèmes de sécurité ou incidents critiques :
1. **NE PAS** créer une issue publique
2. Contactez directement : schor@alwaysdata.net
3. Sujet : `[CRITICAL] ...`

### 🔍 Rechercher une Réponse

1. **Consultez la FAQ** sur cette page
2. **Recherchez dans les Discussions** GitHub
3. **Vérifiez les Issues fermées** pour des solutions similaires
4. **Relisez la documentation** (surtout STRUCTURE_AVANCEE.md)

---

## 📄 Licence

```text
MIT License

Copyright (c) 2026 CRUD ASBL-ONG Team

Permission is hereby granted, free of charge, to any person obtaining a copy
of this software and associated documentation files (the "Software"), to deal
in the Software without restriction, including without limitation the rights
to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
copies of the Software, and to permit persons to whom the Software is
furnished to do so, subject to the following conditions:

The above copyright notice and this permission notice shall be included in all
copies or substantial portions of the Software.

THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN THE
SOFTWARE.
```

### Conditions d'utilisation
- ✅ **Utilisation commerciale** : Autorisée
- ✅ **Modification** : Autorisée
- ✅ **Distribution** : Autorisée
- ✅ **Usage privé** : Autorisé
- ❌ **Responsabilité** : Les auteurs ne sont pas responsables
- ❌ **Garantie** : Fourni "tel quel" sans garantie

---

## 🙏 Remerciements

### Contributeurs
- **Équipe de développement** : Code et architecture
- **Testeurs** : Retours précieux et signalement de bugs
- **Communauté** : Suggestions et support mutuel

### Technologies et Inspirations
- **PHP** : Langage robuste et mature
- **MySQL** : Base de données fiable et performante
- **HTML/CSS/JavaScript** : Stack web standard
- **Symfony/Laravel** : Pour les patterns MVC
- **Bootstrap** : Inspiration UI/UX
- **Font Awesome** : Icônes professionnelles

### Ressources
- [Documentation PHP](https://php.net/manual/)
- [MySQL Docs](https://dev.mysql.com/doc/)
- [MDN Web Docs](https://developer.mozilla.org/)
- [Web Accessibility Guidelines](https://www.w3.org/WAI/)

---

<div align="center">

## 🌍 Contribuer à une Cause

Cette plateforme est développée pour soutenir les organisations à but non lucratif et les associations du monde entier. Votre contribution aide des milliers d'organisations à mieux fonctionner et à maximiser leur impact social.

**Développé avec ❤️ pour les associations et ONG du monde entier**

---

[![GitHub Repo stars](https://img.shields.io/github/stars/dontka/asbl-ong-manager?style=social&label=Star)](https://github.com/dontka/asbl-ong-manager)
[![GitHub followers](https://img.shields.io/github/followers/dontka?style=social&label=Follow)](https://github.com/dontka)

![Built with PHP](https://img.shields.io/badge/Built%20with-PHP%208.3-777BB4?style=for-the-badge)
![MySQL](https://img.shields.io/badge/Database-MySQL%208.0-4479A1?style=for-the-badge)
![MIT License](https://img.shields.io/badge/License-MIT-98C511?style=for-the-badge)

---

**⭐ Si ce projet vous aide, donnez-lui une étoile ! Cela nous motive à continuer le développement.**

</div>