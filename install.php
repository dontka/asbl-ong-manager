<?php
// install.php - Assistant d'installation web CRUD ASBL-ONG Manager

session_start();

// Charge les variables du .env pour pré-remplir le formulaire
function loadEnv($path)
{
    if (!file_exists($path)) return [];
    $env = [];
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    foreach ($lines as $line) {
        if (strpos(trim($line), '#') === 0) continue;
        if (strpos($line, '=') === false) continue;
        list($name, $value) = array_map('trim', explode('=', $line, 2));
        $env[$name] = $value;
    }
    return $env;
}
$envConfig = loadEnv(__DIR__ . '/.env');

// Vérifie si le site est déjà installé
$lockFile = __DIR__ . '/installed.lock';
if (file_exists($lockFile)) {
    ?>
    <!DOCTYPE html>
    <html lang="fr">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>ASBL-ONG Manager - Déjà installé</title>
        <link rel="stylesheet" href="assets/css/style.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    </head>
    <body>
        
<div class="complete-dashboard" style="max-width: auto;">
            <div class="header">
                <div class="navbar">
                    <div class="navbar-brand">
                        <a href="index.php">
                            <i class="fas fa-building"></i> ASBL-ONG Manager
                        </a>
                    </div>
                </div>
            </div>
            <div class="main-content">

                <div style="max-width: auto; margin: auto; text-align: center;">
                    <div class="alert alert-success" style="margin-bottom: 30px;">
                        <div style="display: flex; align-items: center; gap: 15px; justify-content: center;">
                            <i class="fas fa-check-circle" style="font-size: 2.5rem;"></i>
                            <div>
                                <h3 style="margin: 0 0 10px 0;">Installation terminée !</h3>
                                <p style="margin: 0; opacity: 0.9;">Le système est prêt à être utilisé.</p>
                            </div>
                        </div>
                    </div>

                    <div class="card" style="box-shadow: var(--shadow-md);">
                        <div class="card-body" style="padding: 40px;">
                            <i class="fas fa-rocket" style="font-size: 3rem; color: var(--primary); margin-bottom: 20px; display: block;"></i>
                            <h2>Bienvenue</h2>
                            <p style="color: var(--gray-600); margin-bottom: 30px;">Votre plateforme ASBL-ONG Manager est maintenant opérationnelle.</p>
                            
                            <div style="background: var(--gray-50); padding: 20px; border-radius: var(--border-radius); margin-bottom: 30px; text-align: left;">
                                <h4 style="margin-top: 0;">Informations d'accès</h4>
                                <ul style="list-style: none; padding: 0;">
                                    <li style="padding: 8px 0; border-bottom: 1px solid var(--gray-200);"><strong>Email:</strong> admin@asbl-ong.org</li>
                                    <li style="padding: 8px 0;"><strong>Rôle:</strong> Administrateur système</li>
                                </ul>
                            </div>

                            <a href="index.php" class="btn btn-primary" style="width: 100%; margin-bottom: 15px;">
                                <i class="fas fa-sign-in-alt"></i> Accéder à l'application
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="footer" style="margin-top: 60px;">
                <div class="footer-content">
                    <div class="footer-left">
                        <div class="footer-brand">ASBL-ONG Manager</div>
                        <div class="footer-description">Gestion complète pour organisations à but non lucratif</div>
                    </div>
                </div>
                <div class="footer-bottom">
                    <p>&copy; 2026 ASBL-ONG Manager. Installation complétée avec succès.</p>
                </div>
            </div>
        </div>
    </body>
    </html>
    <?php
    exit;
}

// step: 1 = form, 2 = check/connect, 3 = confirm action when DB exists
$step = isset($_POST['step']) ? intval($_POST['step']) : 1;
$error = '';
$success = false;

// Restore inputs from session if present
if (isset($_SESSION['install_input']) && !empty($_SESSION['install_input'])) {
    $saved = $_SESSION['install_input'];
} else {
    $saved = [];
}

function render_form($step, $error = '', $saved = [], $envConfig = [])
{
    // Valeurs par défaut du .env ou fallback
    $defaultHost = $envConfig['DB_HOST'] ?? 'localhost';
    $defaultUser = $envConfig['DB_USER'] ?? 'root';
    $defaultPass = $envConfig['DB_PASS'] ?? '';
    $defaultName = $envConfig['DB_NAME'] ?? 'asbl_ong_manager';
    $defaultEmail = $envConfig['MAIL_FROM'] ?? 'admin@asbl-ong.org';
    
    // Step 1: connection form
    if ($step === 1) {
        ?>
        <div class="wizard-container" style="display: center;">
            <div class="wizard-header">
                <h2><i class="fas fa-hammer"></i> Installation - Étape 1</h2>
                <p>Configuration de la base de données</p>
            </div>

            <?php if ($error): ?>
                <div class="alert alert-danger" style="margin-bottom: 30px;">
                    <div style="display: flex; gap: 15px;">
                        <i class="fas fa-exclamation-circle" style="flex-shrink: 0; margin-top: 2px;"></i>
                        <div>
                            <strong>Erreur détectée</strong>
                            <p style="margin: 5px 0 0 0;"><?php echo htmlspecialchars($error); ?></p>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

            <div class="wizard-card">
                <form method="post" class="wizard-form">
                    <input type="hidden" name="step" value="2">

                    <fieldset style="border: none; padding: 0; margin: 0;">
                        <legend style="display: block; margin-bottom: 30px; font-size: 1.1rem; font-weight: 600; color: var(--gray-900);">
                            <i class="fas fa-database"></i> Informations MySQL
                        </legend>

                        <div class="form-group">
                            <label class="form-label">Hôte MySQL</label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-server"></i>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    name="db_host" 
                                    value="<?php echo htmlspecialchars($saved['db_host'] ?? $defaultHost); ?>" 
                                    placeholder="localhost ou 127.0.0.1"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Utilisateur MySQL</label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-user"></i>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    name="db_user" 
                                    value="<?php echo htmlspecialchars($saved['db_user'] ?? $defaultUser); ?>" 
                                    placeholder="root"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Mot de passe MySQL</label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-lock"></i>
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    name="db_pass" 
                                    placeholder="Laisser vide si aucun mot de passe">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Nom de la base de données</label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-database"></i>
                                <input 
                                    type="text" 
                                    class="form-control" 
                                    name="db_name" 
                                    value="<?php echo htmlspecialchars($saved['db_name'] ?? $defaultName); ?>" 
                                    placeholder="asbl_ong_manager"
                                    required>
                            </div>
                        </div>
                    </fieldset>

                    <hr style="margin: 40px 0; border: none; border-top: 1px solid var(--gray-200);">

                    <fieldset style="border: none; padding: 0; margin: 0;">
                        <legend style="display: block; margin-bottom: 30px; font-size: 1.1rem; font-weight: 600; color: var(--gray-900);">
                            <i class="fas fa-shield-alt"></i> Compte Administrateur
                        </legend>

                        <div class="form-group">
                            <label class="form-label">Email administrateur</label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-envelope"></i>
                                <input 
                                    type="email" 
                                    class="form-control" 
                                    name="admin_email" 
                                    value="<?php echo htmlspecialchars($saved['admin_email'] ?? $defaultEmail); ?>" 
                                    placeholder="admin@asbl-ong.org"
                                    required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Mot de passe administrateur</label>
                            <div class="form-input-wrapper">
                                <i class="fas fa-key"></i>
                                <input 
                                    type="password" 
                                    class="form-control" 
                                    name="admin_password" 
                                    placeholder="Minimum 8 caractères"
                                    required>
                            </div>
                        </div>
                    </fieldset>

                    <div class="form-actions">
                        <button class="btn btn-primary" type="submit" style="width: 100%;">
                            <i class="fas fa-arrow-right"></i> Suivant : Vérification
                        </button>
                    </div>
                </form>
            </div>

            <div class="wizard-tips">
                <h4><i class="fas fa-lightbulb"></i> Conseils</h4>
                <ul>
                    <li>Les valeurs proviennent du fichier <strong>.env</strong> (modifiez-le pour changer les défauts)</li>
                    <li>Laragon/XAMPP utilise généralement <strong>localhost</strong> comme hôte</li>
                    <li>Le mot de passe MySQL est souvent vide en développement</li>
                    <li>Assurez-vous que MySQL est en cours d'exécution avant de continuer</li>
                </ul>
            </div>
        </div>
        <?php
    }

    // Step 3: confirmation when DB exists with tables
    if ($step === 3) {
        ?>
        <div class="wizard-container">
            <div class="wizard-header">
                <h2><i class="fas fa-exclamation-triangle"></i> Base de données existante</h2>
                <p>Action requise</p>
            </div>

            <div class="alert alert-warning">
                <div style="display: flex; gap: 15px;">
                    <i class="fas fa-database" style="flex-shrink: 0; font-size: 1.5rem;"></i>
                    <div>
                        <strong>La base de données existe déjà</strong>
                        <p style="margin: 5px 0 0 0;">
                            La base contient des tables existantes. Vous pouvez annuler l'installation ou réinitialiser complètement la base (attention : toutes les données seront perdues).
                        </p>
                    </div>
                </div>
            </div>

            <div class="wizard-card">
                <form method="post">
                    <input type="hidden" name="step" value="3">

                    <div class="form-group" style="margin-bottom: 30px;">
                        <label class="form-label"><i class="fas fa-lock"></i> Confirmez le mot de passe administrateur</label>
                        <div class="form-input-wrapper">
                            <i class="fas fa-key"></i>
                            <input 
                                type="password" 
                                class="form-control" 
                                name="admin_password" 
                                placeholder="Mot de passe administrateur"
                                required>
                        </div>
                        <small style="color: var(--gray-500); margin-top: 8px; display: block;">
                            Pour confirmer la réinitialisation, veuillez entrer le mot de passe administrateur.
                        </small>
                    </div>

                    <div class="form-actions" style="display: flex; gap: 15px; flex-wrap: wrap;">
                        <button class="btn btn-danger" name="confirm_action" value="reset" type="submit" style="flex: 1; min-width: 200px;">
                            <i class="fas fa-trash"></i> Réinitialiser la base
                        </button>
                        <button class="btn btn-outline-secondary" name="confirm_action" value="abort" type="submit" style="flex: 1; min-width: 200px; background: transparent; color: var(--gray-600); border: 2px solid var(--gray-300);">
                            <i class="fas fa-times"></i> Annuler
                        </button>
                    </div>
                </form>
            </div>

            <div class="wizard-tips">
                <h4><i class="fas fa-info-circle"></i> Attention</h4>
                <ul>
                    <li><strong>Réinitialiser</strong> supprimera toutes les tables et données existantes</li>
                    <li>Les nouveaux fichiers de schéma et de test seront importés</li>
                    <li>Votre mot de passe administrateur sera appliqué au compte admin</li>
                </ul>
            </div>
        </div>
        <?php
    }
}

function import_sql($pdo, $file, $admin_email, $admin_password)
{
    $sql = file_get_contents($file);

    // Split SQL into statements and execute one by one to avoid multi-statement syntax issues
    $statements = array_filter(array_map('trim', explode(";", $sql)));

    // Defer index/constraint statements until tables are created
    $deferred = [];
    foreach ($statements as $stmt) {
        if ($stmt === '') continue;

        // Remove leading block comments (/* ... */) and leading -- comments
        $clean = preg_replace('!^(/\*.*?\*/\s*)+!s', '', $stmt);
        // Remove any leading lines that are only -- comments
        $clean = preg_replace('/^(\s*--.*\r?\n)+/m', '', $clean);

        $clean = trim($clean);
        if ($clean === '') continue;

        $lower = strtolower(ltrim($clean));
        if (strpos($lower, 'create index') === 0 || strpos($lower, 'create unique index') === 0 || (strpos($lower, 'alter table') !== false && (strpos($lower, 'add index') !== false || strpos($lower, 'add constraint') !== false))) {
            $deferred[] = $clean;
            continue;
        }

        try {
            $pdo->exec($clean);
        } catch (Exception $e) {
            throw new Exception("SQL error executing statement: " . substr($clean, 0, 200) . "... — " . $e->getMessage());
        }
    }

    // Execute deferred statements (indexes/constraints) after tables are created
    foreach ($deferred as $stmt) {
        $stmt = trim($stmt);
        if ($stmt === '') continue;
        try {
            $pdo->exec($stmt);
        } catch (Exception $e) {
            throw new Exception("SQL error executing deferred statement: " . substr($stmt, 0, 200) . "... — " . $e->getMessage());
        }
    }

    // If we imported schema, create admin user
    if (strpos(basename($file), 'schema.sql') !== false) {
        try {
            $hash = password_hash($admin_password, PASSWORD_BCRYPT);
            // Use REPLACE INTO to create or update the admin user
            $admin = $pdo->prepare("REPLACE INTO users (username, password, email, role) VALUES ('admin', :pwd, :email, 'admin')");
            $admin->execute([':pwd' => $hash, ':email' => $admin_email]);
        } catch (Exception $e) {
            throw new Exception('Failed to create admin user: ' . $e->getMessage());
        }
    }
}

if ($step === 2) {
    $db_host = $_POST['db_host'];
    $db_user = $_POST['db_user'];
    $db_pass = $_POST['db_pass'];
    $db_name = $_POST['db_name'];
    $admin_email = $_POST['admin_email'];
    $admin_password = $_POST['admin_password'];

    // Save inputs to session to reuse if confirmation is needed
    $_SESSION['install_input'] = [
        'db_host' => $db_host,
        'db_user' => $db_user,
        'db_pass' => $db_pass,
        'db_name' => $db_name,
        'admin_email' => $admin_email,
        // Do NOT save admin password in session in plain text in real apps
    ];

    try {
        $pdo = new PDO("mysql:host=$db_host", $db_user, $db_pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);

        // Check if database already exists
        $stmt = $pdo->prepare("SELECT SCHEMA_NAME FROM INFORMATION_SCHEMA.SCHEMATA WHERE SCHEMA_NAME = :db");
        $stmt->execute([':db' => $db_name]);
        $dbExists = (bool)$stmt->fetchColumn();

        if ($dbExists) {
            // Check if DB contains any tables
            $stmt2 = $pdo->prepare("SELECT TABLE_NAME FROM INFORMATION_SCHEMA.TABLES WHERE TABLE_SCHEMA = :db LIMIT 1");
            $stmt2->execute([':db' => $db_name]);
            $hasTables = (bool)$stmt2->fetchColumn();

            if ($hasTables) {
                // Ask user to confirm action (abort or reset)
                $step = 3;
            } else {
                // DB exists but empty - import
                $pdo->exec("USE `$db_name`;");
                import_sql($pdo, __DIR__ . '/database/schema.sql', $admin_email, $admin_password);
                import_sql($pdo, __DIR__ . '/database/test_data.sql', $admin_email, $admin_password);
                file_put_contents($lockFile, 'INSTALLED: ' . date('c'));
                $success = true;
            }
        } else {
            // Create DB and import
            $pdo->exec("CREATE DATABASE IF NOT EXISTS `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
            $pdo->exec("USE `$db_name`;");
            import_sql($pdo, __DIR__ . '/database/schema.sql', $admin_email, $admin_password);
            import_sql($pdo, __DIR__ . '/database/test_data.sql', $admin_email, $admin_password);
            file_put_contents($lockFile, 'INSTALLED: ' . date('c'));
            $success = true;
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
        $step = 1;
    }
}

// Handle confirmation step: user chose to reset or abort
if ($step === 3 && $_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm_action'])) {
    $action = $_POST['confirm_action'];
    $input = $_SESSION['install_input'] ?? [];
    $db_host = $input['db_host'] ?? '';
    $db_user = $input['db_user'] ?? '';
    $db_pass = $input['db_pass'] ?? '';
    $db_name = $input['db_name'] ?? '';
    $admin_email = $input['admin_email'] ?? '';
    $admin_password = $_POST['admin_password'] ?? '';

    if ($action === 'abort') {
        $error = 'Installation annulée : la base existe déjà.';
        $step = 1;
    } elseif ($action === 'reset') {
        try {
            $pdo = new PDO("mysql:host=$db_host", $db_user, $db_pass, [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]);
            // Drop and recreate database
            $pdo->exec("DROP DATABASE IF EXISTS `$db_name`;");
            $pdo->exec("CREATE DATABASE `$db_name` CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;");
            $pdo->exec("USE `$db_name`;");
            import_sql($pdo, __DIR__ . '/database/schema.sql', $admin_email, $admin_password);
            import_sql($pdo, __DIR__ . '/database/test_data.sql', $admin_email, $admin_password);
            file_put_contents($lockFile, 'INSTALLED: ' . date('c'));
            $success = true;
        } catch (Exception $e) {
            $error = 'Échec lors de la réinitialisation : ' . $e->getMessage();
            $step = 1;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Installation ASBL-ONG Manager</title>
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* Styles additionnels pour le wizard installation */
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
        }

        body {
            background: linear-gradient(135deg, rgba(123, 97, 255, 0.05) 0%, rgba(0, 196, 204, 0.05) 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .complete-dashboard {
            display: flex;
            flex-direction: column;
            min-height: 100vh;
            width: 100%;
        }

        .complete-dashboard::before {
            background: none;
        }

        .main-content {
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .wizard-container {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            max-width: 900px;
            width: 100%;
            margin: 0 auto;
            padding: 40px 20px;
        }

        .wizard-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .wizard-header h2 {
            margin-bottom: 10px;
            color: var(--gray-900);
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 12px;
        }

        .wizard-header p {
            color: var(--gray-500);
            font-size: var(--font-size-sm);
            margin: 0;
        }

        .wizard-card {
            background: var(--white);
            border-radius: var(--border-radius-lg);
            padding: 40px;
            box-shadow: var(--shadow-lg);
            border: 1px solid var(--gray-100);
            margin-bottom: 30px;
        }

        .wizard-form {
            display: flex;
            flex-direction: column;
            gap: 0;
        }

        fieldset {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .form-group {
            display: flex;
            flex-direction: column;
            gap: 8px;
            margin-bottom: 0;
        }

        .form-label {
            font-weight: 600;
            color: var(--gray-800);
            font-size: var(--font-size-sm);
        }

        .form-input-wrapper {
            position: relative;
            display: flex;
            align-items: center;
            background: var(--gray-50);
            border: 2px solid var(--gray-200);
            border-radius: var(--border-radius);
            padding: 0 12px;
            transition: var(--transition);
        }

        .form-input-wrapper:focus-within {
            background: var(--white);
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(123, 97, 255, 0.1);
        }

        .form-input-wrapper i {
            color: var(--gray-400);
            margin-right: 10px;
            width: 16px;
            text-align: center;
        }

        .form-input-wrapper:focus-within i {
            color: var(--primary);
        }

        .form-control {
            flex: 1;
            border: none;
            background: transparent;
            color: var(--gray-800);
            padding: 12px 0;
            font-size: var(--font-size-sm);
            outline: none;
        }

        .form-control::placeholder {
            color: var(--gray-400);
        }

        .form-actions {
            display: flex;
            gap: 15px;
            margin-top: 30px;
        }

        .btn {
            padding: 12px 24px;
            font-weight: 600;
            border-radius: var(--border-radius);
            transition: var(--transition);
            box-shadow: var(--shadow-sm);
        }

        .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-md);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-light));
            color: var(--white);
            border: none;
            cursor: pointer;
        }

        .btn-primary:hover {
            border: none;
        }

        .btn-danger {
            background: linear-gradient(135deg, var(--accent), #E84393);
            color: var(--white);
            border: none;
            cursor: pointer;
        }

        .btn-outline-secondary {
            background: transparent;
            color: var(--gray-600);
            border: 2px solid var(--gray-300);
            cursor: pointer;
        }

        .btn-outline-secondary:hover {
            background: var(--gray-50);
            border-color: var(--gray-500);
        }

        .wizard-tips {
            background: linear-gradient(135deg, rgba(0, 212, 170, 0.05), rgba(123, 97, 255, 0.05));
            border: 2px solid rgba(0, 212, 170, 0.2);
            border-radius: var(--border-radius-lg);
            padding: 20px;
            margin-bottom: 30px;
        }

        .wizard-tips h4 {
            margin: 0 0 15px 0;
            color: var(--gray-800);
            font-size: var(--font-size-sm);
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .wizard-tips ul {
            list-style: none;
            padding: 0;
            margin: 0;
        }

        .wizard-tips li {
            padding: 8px 0;
            color: var(--gray-600);
            font-size: var(--font-size-sm);
            border-bottom: 1px solid rgba(0, 212, 170, 0.1);
        }

        .wizard-tips li:last-child {
            border-bottom: none;
        }

        .alert {
            border-radius: var(--border-radius-lg);
            padding: 20px;
            margin-bottom: 30px;
            border-left: 4px solid;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(0, 212, 170, 0.1), rgba(0, 212, 170, 0.05));
            border-left-color: var(--success);
            border: 1px solid rgba(0, 212, 170, 0.2);
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(255, 71, 87, 0.1), rgba(255, 71, 87, 0.05));
            border: 1px solid rgba(255, 71, 87, 0.2);
            border-left-color: var(--error);
        }

        .alert-warning {
            background: linear-gradient(135deg, rgba(255, 210, 63, 0.1), rgba(255, 210, 63, 0.05));
            border: 1px solid rgba(255, 210, 63, 0.2);
            border-left-color: var(--warning);
        }

        .alert-success, .alert-danger, .alert-warning {
            color: var(--gray-700);
        }

        .alert strong {
            color: var(--gray-900);
        }

        .alert p {
            margin: 0;
            color: var(--gray-600);
        }

        hr {
            border: none;
            border-top: 1px solid var(--gray-200);
            margin: 0;
        }

        small {
            font-size: var(--font-size-xs);
            color: var(--gray-500);
        }

        .footer {
            background: var(--white);
            border-top: 1px solid var(--gray-200);
            padding: 30px 20px;
            text-align: center;
            margin-top: 60px;
        }

        .footer-brand {
            font-weight: 700;
            color: var(--primary);
            margin-bottom: 5px;
        }

        .footer-description {
            color: var(--gray-500);
            font-size: var(--font-size-sm);
        }

        .footer-bottom {
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--gray-200);
        }

        .footer-bottom p {
            color: var(--gray-500);
            font-size: var(--font-size-xs);
            margin: 0;
        }

        @media (max-width: 768px) {
            .wizard-card {
                padding: 25px;
            }

            .wizard-header h2 {
                font-size: var(--font-size-2xl);
            }

            .form-actions {
                flex-direction: column;
            }

            .btn {
                width: 100%;
            }
        }
    </style>
</head>

<body>
    <div class="complete-dashboard">
        <div class="header">
            <div class="navbar">
                <div class="navbar-brand">
                    <a href="index.php" style="text-decoration: none;">
                        <i class="fas fa-building"></i> ASBL-ONG Manager
                    </a>
                </div>
                <span style="color: var(--gray-500); font-size: var(--font-size-sm);">Installation</span>
            </div>
        </div>

        <div class="main-content">
            <?php
            if ($success) {
                ?>
                <div class="wizard-container">
                    <div class="wizard-header">
                        <div style="display: flex; justify-content: center; margin-bottom: 20px;">
                            <div style="width: 80px; height: 80px; background: linear-gradient(135deg, var(--success), var(--secondary)); border-radius: 50%; display: flex; align-items: center; justify-content: center;">
                                <i class="fas fa-check" style="font-size: 2.5rem; color: var(--white);"></i>
                            </div>
                        </div>
                        <h2 style="justify-content: center;">Installation réussie !</h2>
                        <p>Votre plateforme est prête à être utilisée</p>
                    </div>

                    <div class="wizard-card">
                        <div style="text-align: center;">
                            <i class="fas fa-rocket" style="font-size: 2rem; color: var(--primary); margin-bottom: 20px; display: block;"></i>
                            <h3 style="margin: 0 0 15px 0; color: var(--gray-900);">Bienvenue !</h3>
                            <p style="color: var(--gray-600); margin-bottom: 30px;">
                                La base de données a été créée et configurée avec succès. Vous pouvez maintenant accéder à l'application.
                            </p>

                            <div style="background: var(--gray-50); padding: 20px; border-radius: var(--border-radius); margin-bottom: 30px; text-align: left; border: 1px solid var(--gray-200);">
                                <h4 style="margin: 0 0 15px 0; color: var(--gray-800);">
                                    <i class="fas fa-info-circle"></i> Informations d'accès
                                </h4>
                                <ul style="list-style: none; padding: 0; margin: 0;">
                                    <li style="padding: 10px 0; border-bottom: 1px solid var(--gray-200);">
                                        <span style="color: var(--gray-500); font-weight: 500;">Base de données :</span><br>
                                        <code style="background: var(--white); padding: 5px 10px; border-radius: 4px; font-size: 0.85rem;"><?php echo htmlspecialchars($_SESSION['install_input']['db_name'] ?? 'asbl_ong_manager'); ?></code>
                                    </li>
                                    <li style="padding: 10px 0;">
                                        <span style="color: var(--gray-500); font-weight: 500;">Email :</span><br>
                                        <code style="background: var(--white); padding: 5px 10px; border-radius: 4px; font-size: 0.85rem;"><?php echo htmlspecialchars($_SESSION['install_input']['admin_email'] ?? 'admin@asbl-ong.org'); ?></code>
                                    </li>
                                </ul>
                            </div>

                            <a href="index.php" class="btn btn-primary" style="width: 100%; justify-content: center; text-decoration: none; display: inline-flex; margin-bottom: 15px;">
                                <i class="fas fa-sign-in-alt"></i> Accéder à l'application
                            </a>
                        </div>
                    </div>

                    <div class="wizard-tips">
                        <h4><i class="fas fa-lightbulb"></i> Prochaines étapes</h4>
                        <ul>
                            <li>Connectez-vous avec le compte administrateur</li>
                            <li>Explorez les modules et fonctionnalités disponibles</li>
                            <li>Consultez la documentation pour approfondir vos connaissances</li>
                            <li>Pour modifier la configuration, éditez le fichier <strong>.env</strong></li>
                        </ul>
                    </div>
                </div>
                <?php
            } else {
                render_form($step, $error, $saved, $envConfig);
            }
            ?>
        </div>

        <div class="footer">
            <div class="footer-brand">ASBL-ONG Manager</div>
            <div class="footer-description">Assistant d'installation - Gestion complète pour organisations à but non lucratif</div>
            <div class="footer-bottom">
                <p>&copy; 2026 ASBL-ONG Manager. Tous droits réservés.</p>
            </div>
        </div>
    </div>

    <script src="assets/js/main.min.js"></script>
</body>

</html>