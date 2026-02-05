<?php

declare(strict_types=1);

/**
 * ============================================================================
 * ROUTEUR PRINCIPAL - ASBL-ONG-MANAGER
 * ============================================================================
 * 
 * Architecture d'acheminement centralisée pour toutes les requêtes HTTP
 * 
 * Structure complète:
 * 1. DÉCLARATION DE TYPE         - Strict types pour meilleure sécurité
 * 2. UTILITAIRES DE ROUTAGE      - getRoute(), isAuthenticated(), etc.
 * 3. ROUTAGE PRINCIPAL (SWITCH)  - Acheminage selon première partie de l'URI
 * 4. HANDLERS D'AUTHENTIFICATION - Login, Logout
 * 5. HANDLERS DU DASHBOARD       - Accueil principal
 * 6. HANDLERS MODULES CRUD       - Users, Members, Projects, Events, Donations
 * 7. HANDLERS MODULES INFOS      - Search, Documentation
 * 8. HANDLER HR SPÉCIALISÉ       - Routing complexe pour le module HR
 * 
 * Conception modulaire permettant l'ajout simple de nouvelles routes.
 * Support complet du pattern CRUD avec la fonction dispatchAction().
 * 
 * @author Système ASBL-ONG-MANAGER
 * @version 4.0
 * @see dispatchAction() - Dispatche les actions CRUD
 */

// ============================================================================
// 1. UTILITAIRES DE ROUTAGE
// ============================================================================

/**
 * Extrait la route actuelle de l'URI
 * 
 * Analyse l'URI demandée et extrait le premier segment comme route.
 * Exemple: /users/show?id=1 → 'users'
 *
 * @return string La route actuelle (p.ex. 'users', 'members', 'dashboard')
 */
function getRoute(): string
{
    $requestUri = $_SERVER['REQUEST_URI'];
    $scriptName = $_SERVER['SCRIPT_NAME'];

    // Supprime le nom du script (index.php) de l'URI
    $path = str_replace(dirname($scriptName), '', $requestUri);

    // Supprime la chaîne de requête (query string)
    $path = parse_url($path, PHP_URL_PATH);

    // Supprime les slashes au début et à la fin
    $path = trim($path, '/');

    // Récupère le premier segment comme route
    $segments = explode('/', $path);
    $route = $segments[0] ?? '';

    return $route;
}

/**
 * Vérifie si l'utilisateur est authentifié
 *
 * @return bool True si l'utilisateur a une session valide
 */
function isAuthenticated(): bool
{
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    return isset($_SESSION['user_id']);
}

/**
 * Affiche un message d'erreur de manière sécurisée
 *
 * @param string $message Le message d'erreur à afficher
 * @return void
 */
function displayError(string $message): void
{
    $pageTitle = 'Erreur';
    include 'views/header.php';
    echo '<div class="alert alert-danger">' . htmlspecialchars($message) . '</div>';
    include 'views/footer.php';
}

/**
 * Dispatche l'action au contrôleur approprié
 * 
 * Support complet des opérations CRUD :
 * - GET  /module              → index()   (liste)
 * - GET  /module?action=create → create()  (formulaire)
 * - GET  /module?action=show   → show()    (détail)
 * - GET  /module?action=edit   → edit()    (formulaire édition)
 * - POST /module?action=store  → store()   (sauvegarde)
 * - POST /module?action=update → update()  (mise à jour)
 * - POST /module?action=delete → delete()  (suppression)
 *
 * @param object $controller L'instance du contrôleur
 * @param string $defaultAction L'action par défaut (par défaut: 'index')
 * @return void
 */
function dispatchAction($controller, string $defaultAction = 'index'): void
{
    // Récupère l'action demandée (GET > POST > défaut)
    $action = $_GET['action'] ?? $_POST['action'] ?? $defaultAction;
    $method = $_SERVER['REQUEST_METHOD'];

    // Nettoie le nom de l'action (sécurité)
    $action = preg_replace('/[^a-zA-Z0-9_]/', '', $action);

    // Traitement des requêtes POST (écriture)
    if ($method === 'POST') {
        if ($action === 'store' && method_exists($controller, 'store')) {
            $controller->store();
        } elseif ($action === 'update' && method_exists($controller, 'update')) {
            $controller->update();
        } elseif ($action === 'delete' && method_exists($controller, 'delete')) {
            $controller->delete();
        } else {
            if (method_exists($controller, 'store')) {
                $controller->store();
            } else {
                $controller->index();
            }
        }
    } 
    // Traitement des requêtes GET (lecture)
    else {
        if ($action === 'index' && method_exists($controller, 'index')) {
            $controller->index();
        } elseif ($action === 'create' && method_exists($controller, 'create')) {
            $controller->create();
        } elseif ($action === 'show' && method_exists($controller, 'show')) {
            $controller->show();
        } elseif ($action === 'edit' && method_exists($controller, 'edit')) {
            $controller->edit();
        } else {
            if (method_exists($controller, $defaultAction)) {
                $controller->$defaultAction();
            } else {
                $controller->index();
            }
        }
    }
}

// ============================================================================
// 2. ROUTAGE PRINCIPAL
// ============================================================================

try {
    // Initialisation de la base de données
    $db = Database::getInstance();
    $pdo = $db->getConnection();
    $db->selectDatabase(DB_NAME);

    // Extraction de la route actuelle
    $route = getRoute();

    // Acheminage vers le handler approprié
    switch ($route) {
        /**
         * =========== AUTHENTIFICATION ===========
         */
        case 'login':
            ($_SERVER['REQUEST_METHOD'] === 'POST') 
                ? handleLoginAuthenticate() 
                : handleLogin();
            break;

        case 'logout':
            handleLogout();
            break;

        /**
         * =========== ACCUEIL ===========
         */
        case 'dashboard':
            handleDashboard();
            break;

        /**
         * =========== MODULES CRUD PRINCIPAUX ===========
         */
        case 'users':
            handleUsers();
            break;

        case 'members':
            handleMembers();
            break;

        case 'projects':
            handleProjects();
            break;

        case 'events':
            handleEvents();
            break;

        case 'donations':
            handleDonations();
            break;

        /**
         * =========== MODULES INFORMATIONNELS ===========
         */
        case 'documentation':
            handleDocumentation();
            break;

        case 'search':
            handleSearch();
            break;

        /**
         * =========== MODULES SPÉCIALISÉS ===========
         */
        case 'hr':
            handleHR();
            break;

        /**
         * =========== ROUTE PAR DÉFAUT ===========
         */
        default:
            isAuthenticated() ? handleDashboard() : handleLogin();
            break;
    }
} catch (Exception $e) {
    displayError($e->getMessage());
}

// ============================================================================
// 3. HANDLERS D'AUTHENTIFICATION
// ============================================================================

/**
 * Affiche le formulaire de connexion
 */
function handleLogin(): void
{
    require_once __DIR__ . '/../controllers/UserController.php';
    $controller = new UserController();
    $controller->login();
}

/**
 * Traite l'authentification (validation des identifiants)
 */
function handleLoginAuthenticate(): void
{
    require_once __DIR__ . '/../controllers/UserController.php';
    $controller = new UserController();
    $controller->authenticate();
}

/**
 * Traite la déconnexion
 */
function handleLogout(): void
{
    require_once __DIR__ . '/../controllers/UserController.php';
    $controller = new UserController();
    $controller->logout();
}

// ============================================================================
// 4. HANDLER DU DASHBOARD
// ============================================================================

/**
 * Traite les requêtes vers le dashboard principal de l'application
 */
function handleDashboard(): void
{
    require_once __DIR__ . '/../controllers/DashboardController.php';
    $controller = new DashboardController();
    $controller->index();
}

// ============================================================================
// 5. HANDLERS DES MODULES CRUD PRINCIPAUX
// ============================================================================
// Chaque handler instancie le contrôleur et utilise dispatchAction()
// pour router les actions: index, create, show, edit, store, update, delete

/**
 * Traite les requêtes vers le module Utilisateurs
 * Actions supportées: index, create, show, edit, store, update, delete
 */
function handleUsers(): void
{
    require_once __DIR__ . '/../controllers/UserController.php';
    $controller = new UserController();
    dispatchAction($controller);
}

/**
 * Traite les requêtes vers le module Membres
 * Actions supportées: index, create, show, edit, store, update, delete
 */
function handleMembers(): void
{
    require_once __DIR__ . '/../controllers/MemberController.php';
    $controller = new MemberController();
    dispatchAction($controller);
}

/**
 * Traite les requêtes vers le module Projets
 * Actions supportées: index, create, show, edit, store, update, delete
 */
function handleProjects(): void
{
    require_once __DIR__ . '/../controllers/ProjectController.php';
    $controller = new ProjectController();
    dispatchAction($controller);
}

/**
 * Traite les requêtes vers le module Événements
 * Actions supportées: index, create, show, edit, store, update, delete
 */
function handleEvents(): void
{
    require_once __DIR__ . '/../controllers/EventController.php';
    $controller = new EventController();
    dispatchAction($controller);
}

/**
 * Traite les requêtes vers le module Donations
 * Actions supportées: index, create, show, edit, store, update, delete
 */
function handleDonations(): void
{
    require_once __DIR__ . '/../controllers/DonationController.php';
    $controller = new DonationController();
    dispatchAction($controller);
}

// ============================================================================
// 6. HANDLERS DES MODULES INFORMATIONNELS
// ============================================================================

/**
 * Traite les requêtes vers la Recherche globale
 * Utilise le paramètre 'q' pour la requête de recherche
 */
function handleSearch(): void
{
    require_once __DIR__ . '/../controllers/SearchController.php';
    $controller = new SearchController();
    dispatchAction($controller);
}

/**
 * Traite les requêtes vers la Documentation
 * Actions supportées: index et autres selon disponibilité
 */
function handleDocumentation(): void
{
    require_once __DIR__ . '/../controllers/DocumentationController.php';
    $controller = new DocumentationController();
    dispatchAction($controller);
}

// ============================================================================
// 7. HANDLER DU MODULE RESOURCES HUMAINES (SPÉCIALISÉ)
// ============================================================================

/**
 * Traite les requêtes vers le module Resources Humaines
 * 
 * Module complexe avec routing personnalisé pour les sous-modules:
 * - Dashboard: /hr/dashboard
 * - Employés: /hr, /hr/{id}, /hr/{id}/edit
 * - Contrats: /hr/contracts, /hr/contract/{id}, /hr/contract/{id}/edit
 * - Absences: /hr/absences, /hr/absences/{id}, /hr/absences/{id}/approve|reject
 * - Paie: /hr/payroll, /hr/payroll/{id}/edit, /hr/payroll/{id}/pdf
 * - Formations: /hr/trainings
 * - Compétences: /hr/skills, /hr/skills/{id}/edit
 * - Évaluations: /hr/evaluations
 * 
 * Accès: Utilisateurs authentifiés avec rôle valide
 * Rôles autorisés: admin, moderator, hr_manager, supervisor, hr, manager, user, visitor
 */
function handleHR(): void
{
    // Initialisation de la session
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Vérification d'authentification
    if (!isset($_SESSION['user_id'])) {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];
        header("Location: " . $protocol . $host . "/login");
        exit;
    }
    
    // Vérification des rôles autorisés
    $allowedRoles = ['admin', 'moderator', 'hr_manager', 'supervisor', 'hr', 'manager', 'user', 'visitor'];
    $userRole = $_SESSION['user']['role'] ?? null;
    
    if (!in_array($userRole, $allowedRoles) || empty($userRole)) {
        $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off') ? 'https://' : 'http://';
        $host = $_SERVER['HTTP_HOST'];
        header("Location: " . $protocol . $host . "/dashboard");
        exit;
    }
    
    // Instanciation du contrôleur HR
    require_once __DIR__ . '/../controllers/HRController.php';
    $controller = new HRController();
    
    // Extraction de l'URI et de la méthode HTTP
    $requestUri = $_SERVER['REQUEST_URI'];
    $path = parse_url($requestUri, PHP_URL_PATH);
    $method = $_SERVER['REQUEST_METHOD'];
    
    // Table de routage HR
    if (preg_match('#^/hr/dashboard$#', $path)) {
        $controller->dashboard();
    } elseif (preg_match('#^/hr/payroll/(\d+)/pdf$#', $path, $matches)) {
        $controller->payrollPDF($matches[1]);
    } elseif (preg_match('#^/hr/payroll/(\d+)/delete$#', $path, $matches)) {
        $controller->deletePayroll($matches[1]);
    } elseif (preg_match('#^/hr/payroll/(\d+)/edit$#', $path, $matches)) {
        $controller->editPayroll($matches[1]);
    } elseif (preg_match('#^/hr/payroll/create$#', $path)) {
        $controller->editPayroll();
    } elseif (preg_match('#^/hr/payroll$#', $path)) {
        $controller->payroll();
    } elseif (preg_match('#^/hr/absence/(\d+)/edit$#', $path, $matches)) {
        $controller->editAbsence($matches[1]);
    } elseif (preg_match('#^/hr/absence/(\d+)/approve$#', $path, $matches)) {
        $controller->approveAbsence($matches[1]);
    } elseif (preg_match('#^/hr/absence/(\d+)/reject$#', $path, $matches)) {
        $controller->rejectAbsence($matches[1]);
    } elseif (preg_match('#^/hr/absences/(\d+)/approve$#', $path, $matches) && $method === 'POST') {
        $controller->approveAbsence($matches[1]);
    } elseif (preg_match('#^/hr/absences/(\d+)/reject$#', $path, $matches) && $method === 'POST') {
        $controller->rejectAbsence($matches[1]);
    } elseif (preg_match('#^/hr/absences/(\d+)$#', $path, $matches)) {
        $controller->showAbsence($matches[1]);
    } elseif (preg_match('#^/hr/absences$#', $path)) {
        $controller->absences();
    } elseif (preg_match('#^/hr/evaluations/(\d+)/create$#', $path, $matches)) {
        $controller->createEvaluation($matches[1]);
    } elseif (preg_match('#^/hr/evaluations/?$#', $path) && $method === 'POST') {
        $controller->storeEvaluation();
    } elseif (preg_match('#^/hr/evaluations/?$#', $path)) {
        $controller->evaluations();
    } elseif (preg_match('#^/hr/contract/(\d+)/delete$#', $path, $matches)) {
        $controller->deleteContract($matches[1]);
    } elseif (preg_match('#^/hr/contract/(\d+)/edit$#', $path, $matches)) {
        $controller->editContract($matches[1]);
    } elseif (preg_match('#^/hr/contract/(\d+)$#', $path, $matches) && $method === 'PUT') {
        $controller->updateContract($matches[1]);
    } elseif (preg_match('#^/hr/contract/(\d+)$#', $path, $matches)) {
        $controller->showContract($matches[1]);
    } elseif (preg_match('#^/hr/create-contract$#', $path)) {
        $controller->createContract();
    } elseif (preg_match('#^/hr/store-contract$#', $path) && $method === 'POST') {
        $controller->storeContract();
    } elseif (preg_match('#^/hr/contracts$#', $path)) {
        $controller->contracts();
    } elseif (preg_match('#^/hr/trainings$#', $path)) {
        $controller->trainings();
    } elseif (preg_match('#^/hr/skills/(\d+)/delete$#', $path, $matches)) {
        $controller->deleteSkill($matches[1]);
    } elseif (preg_match('#^/hr/skills/(\d+)/edit$#', $path, $matches)) {
        $controller->editSkill($matches[1]);
    } elseif (preg_match('#^/hr/skills/create$#', $path)) {
        $controller->editSkill();
    } elseif (preg_match('#^/hr/skills$#', $path)) {
        $controller->skills();
    } elseif (preg_match('#^/hr/(\d+)/edit$#', $path, $matches)) {
        $controller->edit($matches[1]);
    } elseif (preg_match('#^/hr/(\d+)$#', $path, $matches) && $method === 'PUT') {
        $controller->update($matches[1]);
    } elseif (preg_match('#^/hr/(\d+)$#', $path, $matches)) {
        $controller->show($matches[1]);
    } elseif (preg_match('#^/hr/create$#', $path)) {
        $controller->create();
    } elseif (preg_match('#^/hr/store$#', $path) && $method === 'POST') {
        $controller->store();
    } elseif (preg_match('#^/hr/?$#', $path)) {
        $controller->dashboard();
    } else {
        $controller->index();
    }
}
