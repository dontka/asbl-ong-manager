<?php

// --- Chargement des variables d'environnement (.env) ---
function loadEnv($path)
{
    if (!file_exists($path)) return;
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') === false) continue;
        list($name, $value) = array_map('trim', explode('=', $line, 2));
        if (!array_key_exists($name, $_ENV)) {
            $_ENV[$name] = $value;
            putenv("$name=$value");
        }
    }
}
loadEnv(__DIR__ . '/.env');

// --- Chemins principaux (structure avancée) ---
define('ROOT_PATH', __DIR__ . '/');
define('CONFIG_PATH', ROOT_PATH . 'config/');
define('MODELS_PATH', ROOT_PATH . 'models/');
define('CONTROLLERS_PATH', ROOT_PATH . 'controllers/');
define('VIEWS_PATH', ROOT_PATH . 'views/');
define('MODULES_PATH', ROOT_PATH . 'modules/');
define('PLUGINS_PATH', ROOT_PATH . 'plugins/');
define('API_PATH', ROOT_PATH . 'api/');
define('ASSETS_PATH', ROOT_PATH . 'assets/');
define('DATABASE_PATH', ROOT_PATH . 'database/');
define('INCLUDES_PATH', ROOT_PATH . 'includes/');
define('DOCS_PATH', ROOT_PATH . 'docs/');
define('TESTS_PATH', ROOT_PATH . 'tests/');

// --- Configuration de l'application (depuis .env) ---
define('APP_NAME', getenv('APP_NAME') ?: 'ASBL-ONG Manager');
define('APP_VERSION', getenv('APP_VERSION') ?: '1.0.0');
define('APP_DEBUG', getenv('APP_DEBUG') ?: 'true');
define('APP_ENV', getenv('APP_ENV') ?: 'local');
define('APP_LOCALE', getenv('APP_LOCALE') ?: 'fr');
define('APP_TIMEZONE', getenv('APP_TIMEZONE') ?: 'Europe/Paris');

// --- Configuration base de données (depuis .env) ---
define('DB_HOST', getenv('DB_HOST') ?: 'localhost');
define('DB_USER', getenv('DB_USER') ?: 'root');
define('DB_PASS', getenv('DB_PASS') ?: '');
define('DB_NAME', getenv('DB_NAME') ?: 'asbl_ong_manager');
define('DB_CHARSET', getenv('DB_CHARSET') ?: 'utf8mb4');

// --- Sécurité & Authentification (depuis .env) ---
define('AUTH_METHOD', getenv('AUTH_METHOD') ?: 'local');
define('AUTH_MFA', getenv('AUTH_MFA') ?: 'false');
define('SESSION_LIFETIME', getenv('SESSION_LIFETIME') ?: 3600);
define('CSRF_ENABLED', getenv('CSRF_ENABLED') ?: 'true');
define('ENCRYPTION_KEY', getenv('ENCRYPTION_KEY') ?: 'change_me_in_production');

// --- Multi-entités / langues / devises (depuis .env) ---
define('MULTI_ENTITY', getenv('MULTI_ENTITY') ?: 'true');
define('DEFAULT_ENTITY', getenv('DEFAULT_ENTITY') ?: 'main');
define('MULTI_LANG', getenv('MULTI_LANG') ?: 'true');
define('DEFAULT_LANG', getenv('DEFAULT_LANG') ?: 'fr');
define('MULTI_CURRENCY', getenv('MULTI_CURRENCY') ?: 'true');
define('DEFAULT_CURRENCY', getenv('DEFAULT_CURRENCY') ?: 'EUR');

// --- API & Intégrations (depuis .env) ---
define('API_ENABLED', getenv('API_ENABLED') ?: 'true');
define('API_KEY', getenv('API_KEY') ?: 'change_me_in_production');
define('API_RATE_LIMIT', getenv('API_RATE_LIMIT') ?: 1000);

// --- Email & Notifications (depuis .env) ---
define('MAIL_DRIVER', getenv('MAIL_DRIVER') ?: 'smtp');
define('MAIL_HOST', getenv('MAIL_HOST') ?: 'localhost');
define('MAIL_PORT', getenv('MAIL_PORT') ?: 1025);
define('MAIL_FROM', getenv('MAIL_FROM') ?: 'noreply@asbl-ong.org');
define('NOTIFICATIONS_ENABLED', getenv('NOTIFICATIONS_ENABLED') ?: 'true');

// --- Stockage & Fichiers (depuis .env) ---
define('STORAGE_DRIVER', getenv('STORAGE_DRIVER') ?: 'local');
define('STORAGE_PATH', getenv('STORAGE_PATH') ?: 'storage/');
define('MAX_UPLOAD_SIZE', getenv('MAX_UPLOAD_SIZE') ?: 10485760);

// --- Journalisation & Cache (depuis .env) ---
define('LOG_LEVEL', getenv('LOG_LEVEL') ?: 'debug');
define('CACHE_DRIVER', getenv('CACHE_DRIVER') ?: 'file');
define('QUEUE_DRIVER', getenv('QUEUE_DRIVER') ?: 'sync');

// --- BASE_URL : priorité à APP_URL du .env, sinon détection dynamique ---
$envBaseUrl = getenv('APP_URL');
if (!empty($envBaseUrl)) {
    define('BASE_URL', rtrim($envBaseUrl, '/'));
} else {
    $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https' : 'http';
    $host = $_SERVER['HTTP_HOST'] ?? 'localhost';
    $basePath = rtrim(str_replace('\\', '/', dirname($_SERVER['SCRIPT_NAME'])), '/');
    if ($basePath === '' || $basePath === '.') {
        $basePath = '';
    }
    define('BASE_URL', $protocol . '://' . $host . ($basePath !== '' && $basePath !== '/' ? $basePath : ''));
}

// --- Chargement des configurations avancées (modules, rôles, sécurité, plugins) ---
// Ces fichiers doivent exister dans /config/ et retourner un tableau PHP
function loadConfig($file)
{
    $path = CONFIG_PATH . $file;
    if (file_exists($path)) {
        return include $path;
    }
    return [];
}

$ROLES = loadConfig('roles.php');
$MODULES = loadConfig('modules.php');
$SECURITY = loadConfig('security.php');
$PLUGINS = loadConfig('plugins.php');

// --- Chargement dynamique des plugins actifs ---
function loadActivePlugins($plugins)
{
    foreach ($plugins as $plugin) {
        $pluginMain = PLUGINS_PATH . $plugin . '/Plugin.php';
        if (file_exists($pluginMain)) {
            require_once $pluginMain;
        }
    }
}
if (!empty($PLUGINS['active'])) {
    loadActivePlugins($PLUGINS['active']);
}

// --- Sécurité globale (headers, CSRF, etc.) ---
require_once INCLUDES_PATH . 'security_headers.php';
require_once INCLUDES_PATH . 'csrf.php';
require_once INCLUDES_PATH . 'sanitize.php';

// --- Gestion des erreurs et debug ---
ini_set('display_errors', APP_DEBUG === 'true' ? '1' : '0');
error_reporting(APP_DEBUG === 'true' ? E_ALL : 0);

// --- Fonctions utilitaires globales (logger, cache, etc.) ---
if (file_exists(INCLUDES_PATH . 'logger.php')) {
    require_once INCLUDES_PATH . 'logger.php';
}
if (file_exists(INCLUDES_PATH . 'cache.php')) {
    require_once INCLUDES_PATH . 'cache.php';
}
