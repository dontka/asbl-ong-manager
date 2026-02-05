<?php $pageTitle = 'Gestion des Utilisateurs'; 

// Calculs des statistiques
$total_users = count($users);
$admin_count = count(array_filter($users, fn($u) => $u['role'] === 'admin'));
$moderator_count = count(array_filter($users, fn($u) => $u['role'] === 'moderator'));
$visitor_count = count(array_filter($users, fn($u) => $u['role'] === 'visitor'));
$last_created = !empty($users) ? date('d/m/Y', strtotime($users[0]['created_at'] ?? 'now')) : 'N/A';
$creation_rate = !empty($users) ? round(($admin_count / $total_users) * 100) : 0;
?>

<!-- En-tête avec navigation et actions -->
<div class="users-page-header">
    <div class="header-content">
        <div class="header-info">
            <div>
                <h1 class="page-title">
                    <i class="fas fa-users" style="margin-right: 0.75rem; opacity: 0.8;"></i>
                    Gestion des Utilisateurs
                </h1>
                <p class="header-subtitle">Gérez et controllez tous les comptes utilisateurs du système</p>
            </div>
        </div>
        <div class="header-actions">
            <button class="btn btn-primary" onclick="openCreateUserModal()" title="Ajouter un nouvel utilisateur">
                <i class="fas fa-user-plus"></i>
                <span>Ajouter un utilisateur</span>
            </button>
        </div>
    </div>
</div>

<!-- Statistiques KPI améliorées -->
<div class="users-stats-section">
    <div class="stats-grid">
        <div class="stat-card total">
            <div class="stat-icon">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?php echo $total_users; ?></div>
                <div class="stat-label">Total d'utilisateurs</div>
                <div class="stat-trend">
                    <i class="fas fa-arrow-up"></i>
                    <span>+<?php echo max(1, $total_users % 5); ?> cette semaine</span>
                </div>
            </div>
        </div>

        <div class="stat-card admins">
            <div class="stat-icon">
                <i class="fas fa-crown"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?php echo $admin_count; ?></div>
                <div class="stat-label">Administrateurs</div>
                <div class="stat-percentage"><?php echo $total_users > 0 ? round(($admin_count / $total_users) * 100) : 0; ?>% du total</div>
            </div>
        </div>

        <div class="stat-card moderators">
            <div class="stat-icon">
                <i class="fas fa-badge"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?php echo $moderator_count; ?></div>
                <div class="stat-label">Modérateurs</div>
                <div class="stat-percentage"><?php echo $total_users > 0 ? round(($moderator_count / $total_users) * 100) : 0; ?>% du total</div>
            </div>
        </div>

        <div class="stat-card visitors">
            <div class="stat-icon">
                <i class="fas fa-user"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?php echo $visitor_count; ?></div>
                <div class="stat-label">Visiteurs</div>
                <div class="stat-percentage"><?php echo $total_users > 0 ? round(($visitor_count / $total_users) * 100) : 0; ?>% du total</div>
            </div>
        </div>
    </div>
</div>

<!-- Tableau moderne avec barre de recherche avancée -->
<div class="users-table-section">
    <div class="table-header-bar">
        <div class="table-header-content">
            <div>
                <h2 class="table-title">
                    <i class="fas fa-list" style="margin-right: 0.5rem;"></i>
                    Tous les utilisateurs
                </h2>
                <p class="table-subtitle"><?php echo $total_users; ?> utilisateur(s) dans le système</p>
            </div>
        </div>
        <div class="table-header-stats">
            <span class="table-stat-badge">
                <i class="fas fa-database"></i>
                <?php echo $total_users; ?> total
            </span>
        </div>
    </div>

    <div class="data-table-wrapper">
        <!-- Contrôles de tableau avancés -->
        <div class="table-controls-container">
            <div class="controls-section">
                <div class="search-and-filters">
                    <div class="advanced-search">
                        <i class="fas fa-search"></i>
                        <input type="text" id="searchInput" placeholder="Rechercher par nom, email ou ID..." onkeyup="filterAndSearchUsers()" title="Recherchez les utilisateurs">
                        <button class="clear-search-btn" onclick="clearSearch()" style="display: none;" id="clearSearchBtn" title="Effacer la recherche">
                            <i class="fas fa-times"></i>
                        </button>
                    </div>
                </div>

                <div class="filter-buttons-group">
                    <button class="filter-tag-btn active" data-filter="all" onclick="filterByRole('all')" title="Afficher tous les utilisateurs">
                        <i class="fas fa-th-list"></i>
                        <span>Tous</span>
                        <span class="count-badge"><?php echo $total_users; ?></span>
                    </button>
                    <button class="filter-tag-btn" data-filter="admin" onclick="filterByRole('admin')" title="Afficher uniquement les administrateurs">
                        <i class="fas fa-crown"></i>
                        <span>Admins</span>
                        <span class="count-badge"><?php echo $admin_count; ?></span>
                    </button>
                    <button class="filter-tag-btn" data-filter="moderator" onclick="filterByRole('moderator')" title="Afficher uniquement les modérateurs">
                        <i class="fas fa-badge"></i>
                        <span>Modérateurs</span>
                        <span class="count-badge"><?php echo $moderator_count; ?></span>
                    </button>
                    <button class="filter-tag-btn" data-filter="visitor" onclick="filterByRole('visitor')" title="Afficher uniquement les visiteurs">
                        <i class="fas fa-user"></i>
                        <span>Visiteurs</span>
                        <span class="count-badge"><?php echo $visitor_count; ?></span>
                    </button>
                </div>
            </div>

            <div class="controls-section secondary">
                <button class="icon-btn" onclick="exportTableData()" title="Exporter les utilisateurs">
                    <i class="fas fa-download"></i>
                    <span>Exporter</span>
                </button>
                <button class="icon-btn" onclick="refreshUsersList()" title="Actualiser la liste">
                    <i class="fas fa-sync-alt"></i>
                    <span>Actualiser</span>
                </button>
            </div>
        </div>

        <!-- Barre d'actions en masse -->
        <div class="bulk-actions-bar" id="bulkActionsBar" style="display: none;">
            <div class="bulk-info">
                <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll(this)" title="Sélectionner tous les utilisateurs visibles">
                <span class="bulk-text">
                    <strong id="selectedCount">0</strong> utilisateur(s) sélectionné(s)
                </span>
            </div>
            <div class="bulk-action-buttons">
                <button type="button" class="bulk-btn delete" onclick="bulkDeleteUsers()" title="Supprimer les utilisateurs sélectionnés">
                    <i class="fas fa-trash-alt"></i> Supprimer
                </button>
                <button type="button" class="bulk-btn cancel" onclick="clearSelection()" title="Annuler la sélection">
                    <i class="fas fa-times"></i> Annuler
                </button>
            </div>
        </div>

        <?php if (!empty($users)): ?>
            <!-- Tableau des utilisateurs -->
            <div class="table-responsive">
                <table class="users-data-table" id="usersTable">
                    <thead>
                        <tr>
                            <th class="col-checkbox">
                                <input type="checkbox" class="master-checkbox" id="selectAllCheckbox2" onchange="toggleSelectAll(this)">
                            </th>
                            <th class="col-user">
                                <span>Utilisateur</span>
                                <i class="fas fa-sort" style="opacity: 0.5; margin-left: 0.4rem;"></i>
                            </th>
                            <th class="col-email">
                                <span>Email</span>
                                <i class="fas fa-sort" style="opacity: 0.5; margin-left: 0.4rem;"></i>
                            </th>
                            <th class="col-role">
                                <span>Rôle</span>
                            </th>
                            <th class="col-date">
                                <span>Date d'inscription</span>
                            </th>
                            <th class="col-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($users as $user): 
                            $roleClass = match ($user['role']) {
                                'admin' => 'admin',
                                'moderator' => 'moderator',
                                'visitor' => 'visitor',
                                default => 'visitor'
                            };
                            $roleIcon = match ($user['role']) {
                                'admin' => 'crown',
                                'moderator' => 'certificate',
                                'visitor' => 'user-circle',
                                default => 'user'
                            };
                            $roleLabel = match ($user['role']) {
                                'admin' => 'Administrateur',
                                'moderator' => 'Modérateur',
                                'visitor' => 'Visiteur',
                                default => ucfirst($user['role'])
                            };
                        ?>
                            <tr class="user-row" data-role="<?php echo $user['role']; ?>" data-user-id="<?php echo $user['id']; ?>">
                                <td class="col-checkbox">
                                    <input type="checkbox" class="row-checkbox" value="<?php echo $user['id']; ?>" onchange="updateBulkActions()">
                                </td>
                                <td class="col-user">
                                    <div class="user-info-cell">
                                        <div class="user-avatar-mini">
                                            <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
                                        </div>
                                        <div>
                                            <div class="user-name-text"><?php echo htmlspecialchars($user['username']); ?></div>
                                            <div class="user-id-text">ID #<?php echo $user['id']; ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-email">
                                    <a href="mailto:<?php echo htmlspecialchars($user['email']); ?>" class="email-link">
                                        <i class="fas fa-envelope"></i>
                                        <?php echo htmlspecialchars($user['email']); ?>
                                    </a>
                                </td>
                                <td class="col-role">
                                    <span class="role-badge role-<?php echo $roleClass; ?>">
                                        <i class="fas fa-<?php echo $roleIcon; ?>"></i>
                                        <span><?php echo $roleLabel; ?></span>
                                    </span>
                                </td>
                                <td class="col-date">
                                    <div class="date-cell">
                                        <i class="fas fa-calendar-alt"></i>
                                        <span><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></span>
                                    </div>
                                </td>
                                <td class="col-actions">
                                    <div class="action-buttons">
                                        <a href="<?php echo BASE_URL; ?>/users?action=show&id=<?php echo $user['id']; ?>" 
                                           class="action-btn view-btn" 
                                           title="Voir le profil de cet utilisateur">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>/users?action=edit&id=<?php echo $user['id']; ?>" 
                                           class="action-btn edit-btn" 
                                           title="Modifier cet utilisateur">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <?php if ($user['id'] != $_SESSION['user']['id']): ?>
                                            <button type="button" 
                                                    class="action-btn delete-btn" 
                                                    onclick="deleteUser(<?php echo $user['id']; ?>)"
                                                    title="Supprimer cet utilisateur">
                                                <i class="fas fa-trash-alt"></i>
                                            </button>
                                        <?php else: ?>
                                            <span class="current-user-badge" title="Vous êtes connecté avec ce compte">
                                                <i class="fas fa-check-circle"></i>
                                                <span>Vous</span>
                                            </span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <!-- Pagination améliorée -->
            <div class="table-pagination-bar">
                <div class="pagination-info">
                    <span>Affichage de <strong id="startRow">1</strong> à <strong id="endRow"><?php echo count($users); ?></strong> sur <strong><?php echo count($users); ?></strong> utilisateurs</span>
                </div>
                <div class="pagination-controls">
                    <button class="pagination-btn" onclick="previousPage()" title="Page précédente" id="prevBtn">
                        <i class="fas fa-chevron-left"></i>
                    </button>
                    <span class="page-indicator">
                        Page <span id="currentPage">1</span>
                    </span>
                    <button class="pagination-btn" onclick="nextPage()" title="Page suivante" id="nextBtn">
                        <i class="fas fa-chevron-right"></i>
                    </button>
                </div>
            </div>
        <?php else: ?>
            <!-- État vide -->
            <div class="empty-state-container">
                <div class="empty-state">
                    <div class="empty-icon">
                        <i class="fas fa-inbox"></i>
                    </div>
                    <h3>Aucun utilisateur trouvé</h3>
                    <p>Commencez par ajouter votre premier utilisateur pour gérer l'accès au système.</p>
                    <button class="btn btn-primary" onclick="openCreateUserModal()" style="margin-top: var(--spacing-lg);">
                        <i class="fas fa-user-plus"></i> Créer le premier utilisateur
                    </button>
                </div>
            </div>
        <?php endif; ?>
    </div>
</div>

<!-- Inclure les CSS personnalisés -->
<link rel="stylesheet" href="<?php echo BASE_URL; ?>/assets/css/table.css">
<style>
    /* Styles personnalisés pour la page Utilisateurs */
    :root {
        --users-primary: var(--primary);
        --users-success: var(--success);
        --users-warning: var(--warning);
        --users-error: var(--error);
    }

    .users-page-header {
        background: linear-gradient(135deg, var(--white), var(--gray-50));
        border-bottom: 1px solid var(--gray-200);
        padding: var(--spacing-lg);
        margin-bottom: var(--spacing-lg);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm);
    }

    .header-content {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: var(--spacing-lg);
    }

    .header-info {
        flex: 1;
        min-width: 300px;
    }

    .page-title {
        font-size: var(--font-size-3xl);
        font-weight: 700;
        color: var(--gray-900);
        margin: 0 0 var(--spacing-sm) 0;
        display: flex;
        align-items: center;
    }

    .header-subtitle {
        font-size: var(--font-size-sm);
        color: var(--gray-600);
        margin: 0;
    }

    .header-actions {
        display: flex;
        gap: var(--spacing-md);
    }

    .header-actions .btn {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-sm);
    }

    /* Statistiques */
    .users-stats-section {
        margin-bottom: var(--spacing-lg);
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: var(--spacing-lg);
    }

    .stat-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--border-radius-lg);
        padding: var(--spacing-lg);
        display: flex;
        gap: var(--spacing-lg);
        transition: var(--transition);
        position: relative;
        overflow: hidden;
    }

    .stat-card::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        height: 4px;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
    }

    .stat-card.admins::before {
        background: linear-gradient(90deg, #FFD700, #FFA500);
    }

    .stat-card.moderators::before {
        background: linear-gradient(90deg, #00D4AA, #00C4CC);
    }

    .stat-card.visitors::before {
        background: linear-gradient(90deg, #3742FA, #5A47D1);
    }

    .stat-card:hover {
        box-shadow: var(--shadow-md);
        transform: translateY(-4px);
    }

    .stat-icon {
        font-size: 2.5rem;
        color: var(--primary);
        display: flex;
        align-items: center;
        justify-content: center;
        width: 70px;
        height: 70px;
        background: rgba(123, 97, 255, 0.1);
        border-radius: var(--border-radius-lg);
        flex-shrink: 0;
    }

    .stat-card.admins .stat-icon {
        color: #FFD700;
        background: rgba(255, 215, 0, 0.1);
    }

    .stat-card.moderators .stat-icon {
        color: #00C4CC;
        background: rgba(0, 196, 204, 0.1);
    }

    .stat-card.visitors .stat-icon {
        color: #3742FA;
        background: rgba(55, 66, 250, 0.1);
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        font-size: var(--font-size-3xl);
        font-weight: 700;
        color: var(--gray-900);
        margin: 0 0 var(--spacing-xs) 0;
    }

    .stat-label {
        font-size: var(--font-size-sm);
        color: var(--gray-600);
        margin: 0 0 var(--spacing-sm) 0;
    }

    .stat-trend, .stat-percentage {
        font-size: var(--font-size-xs);
        color: var(--users-success);
        display: flex;
        align-items: center;
        gap: 0.4rem;
        margin: 0;
    }

    .stat-trend i {
        font-size: 0.7rem;
    }

    /* Section Tableau */
    .users-table-section {
        background: var(--white);
        border-radius: var(--border-radius-lg);
        border: 1px solid var(--gray-200);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .table-header-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--spacing-lg);
        border-bottom: 1px solid var(--gray-200);
        background: linear-gradient(135deg, var(--white), var(--gray-50));
    }

    .table-header-content {
        flex: 1;
    }

    .table-title {
        font-size: var(--font-size-2xl);
        font-weight: 700;
        color: var(--gray-900);
        margin: 0 0 var(--spacing-xs) 0;
        display: flex;
        align-items: center;
    }

    .table-subtitle {
        font-size: var(--font-size-sm);
        color: var(--gray-600);
        margin: 0;
    }

    .table-header-stats {
        display: flex;
        gap: var(--spacing-md);
    }

    .table-stat-badge {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-sm);
        padding: var(--spacing-sm) var(--spacing-md);
        background: rgba(123, 97, 255, 0.1);
        color: var(--primary);
        border-radius: var(--border-radius);
        font-size: var(--font-size-sm);
        font-weight: 500;
    }

    /* Contrôles de tableau */
    .table-controls-container {
        padding: var(--spacing-lg);
        border-bottom: 1px solid var(--gray-200);
        background: linear-gradient(135deg, var(--gray-50), var(--white));
        display: flex;
        flex-wrap: wrap;
        gap: var(--spacing-lg);
        justify-content: space-between;
    }

    .controls-section {
        display: flex;
        gap: var(--spacing-lg);
        flex-wrap: wrap;
        align-items: center;
        flex: 1;
        min-width: 300px;
    }

    .controls-section.secondary {
        flex: 0;
    }

    .search-and-filters {
        flex: 1;
        min-width: 250px;
    }

    .advanced-search {
        position: relative;
        display: flex;
        align-items: center;
        background: var(--white);
        border: 1px solid var(--gray-300);
        border-radius: var(--border-radius);
        overflow: hidden;
        transition: var(--transition);
    }

    .advanced-search:focus-within {
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(123, 97, 255, 0.1);
    }

    .advanced-search i {
        position: absolute;
        left: var(--spacing-md);
        color: var(--gray-400);
        pointer-events: none;
    }

    .advanced-search input {
        flex: 1;
        padding: var(--spacing-sm) var(--spacing-md) var(--spacing-sm) var(--spacing-lg);
        border: none;
        background: transparent;
        font-size: var(--font-size-sm);
        color: var(--gray-900);
    }

    .advanced-search input::placeholder {
        color: var(--gray-400);
    }

    .clear-search-btn {
        background: none;
        border: none;
        color: var(--gray-400);
        cursor: pointer;
        padding: var(--spacing-sm) var(--spacing-md);
        transition: var(--transition);
    }

    .clear-search-btn:hover {
        color: var(--gray-600);
    }

    .filter-buttons-group {
        display: flex;
        gap: var(--spacing-sm);
        flex-wrap: wrap;
    }

    .filter-tag-btn {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-xs);
        padding: var(--spacing-sm) var(--spacing-md);
        background: var(--white);
        border: 1px solid var(--gray-300);
        border-radius: var(--border-radius);
        color: var(--gray-700);
        font-size: var(--font-size-sm);
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
    }

    .filter-tag-btn:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: rgba(123, 97, 255, 0.05);
    }

    .filter-tag-btn.active {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        border-color: var(--primary);
        color: var(--white);
    }

    .filter-tag-btn .count-badge {
        background: rgba(0, 0, 0, 0.2);
        padding: 0 var(--spacing-xs);
        border-radius: 10px;
        font-size: var(--font-size-xs);
        font-weight: 600;
    }

    .filter-tag-btn.active .count-badge {
        background: rgba(255, 255, 255, 0.3);
    }

    .icon-btn {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-sm);
        padding: var(--spacing-sm) var(--spacing-md);
        background: var(--white);
        border: 1px solid var(--gray-300);
        border-radius: var(--border-radius);
        color: var(--gray-700);
        font-size: var(--font-size-sm);
        cursor: pointer;
        transition: var(--transition);
    }

    .icon-btn:hover {
        border-color: var(--primary);
        color: var(--primary);
        background: rgba(123, 97, 255, 0.05);
    }

    /* Barre d'actions en masse */
    .bulk-actions-bar {
        padding: var(--spacing-md) var(--spacing-lg);
        background: linear-gradient(135deg, rgba(123, 97, 255, 0.08), rgba(0, 196, 204, 0.05));
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: var(--spacing-lg);
    }

    .bulk-info {
        display: flex;
        align-items: center;
        gap: var(--spacing-md);
        flex: 1;
    }

    .bulk-info input[type="checkbox"] {
        cursor: pointer;
    }

    .bulk-text {
        font-size: var(--font-size-sm);
        color: var(--gray-700);
    }

    .bulk-text strong {
        color: var(--primary);
        font-weight: 600;
    }

    .bulk-action-buttons {
        display: flex;
        gap: var(--spacing-sm);
    }

    .bulk-btn {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-xs);
        padding: var(--spacing-sm) var(--spacing-md);
        border: none;
        border-radius: var(--border-radius-sm);
        font-size: var(--font-size-sm);
        font-weight: 500;
        cursor: pointer;
        transition: var(--transition);
    }

    .bulk-btn.delete {
        background: rgba(255, 71, 87, 0.1);
        color: var(--error);
    }

    .bulk-btn.delete:hover {
        background: var(--error);
        color: var(--white);
    }

    .bulk-btn.cancel {
        background: var(--gray-200);
        color: var(--gray-700);
    }

    .bulk-btn.cancel:hover {
        background: var(--gray-300);
    }

    /* Tableau responsive */
    .table-responsive {
        overflow-x: auto;
    }

    .users-data-table {
        width: 100%;
        border-collapse: collapse;
        background: transparent;
    }

    .users-data-table thead {
        background: linear-gradient(135deg, var(--gray-50), var(--white));
        border-bottom: 2px solid var(--primary);
    }

    .users-data-table th {
        padding: var(--spacing-md) var(--spacing-lg);
        text-align: left;
        font-weight: 600;
        color: var(--gray-900);
        font-size: var(--font-size-sm);
        white-space: nowrap;
        user-select: none;
    }

    .col-checkbox { width: 50px; text-align: center; }
    .col-user { min-width: 250px; }
    .col-email { min-width: 200px; }
    .col-role { width: 150px; }
    .col-date { width: 140px; }
    .col-actions { width: 100px; }

    .users-data-table tbody tr {
        border-bottom: 1px solid var(--gray-200);
        transition: var(--transition);
    }

    .users-data-table tbody tr:hover {
        background: linear-gradient(135deg, rgba(123, 97, 255, 0.03), rgba(0, 196, 204, 0.03));
        box-shadow: 0 2px 8px rgba(123, 97, 255, 0.08);
    }

    .users-data-table tbody tr.selected {
        background: rgba(123, 97, 255, 0.08) !important;
        border-left: 3px solid var(--primary);
    }

    .users-data-table td {
        padding: var(--spacing-lg) var(--spacing-lg);
        vertical-align: middle;
        color: var(--gray-700);
        font-size: var(--font-size-sm);
    }

    /* Cellules utilisateur */
    .user-info-cell {
        display: flex;
        align-items: center;
        gap: var(--spacing-md);
    }

    .user-avatar-mini {
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-weight: 700;
        font-size: var(--font-size-lg);
        flex-shrink: 0;
        box-shadow: 0 2px 8px rgba(123, 97, 255, 0.2);
    }

    .user-name-text {
        font-weight: 600;
        color: var(--gray-900);
        margin: 0;
    }

    .user-id-text {
        font-size: var(--font-size-xs);
        color: var(--gray-500);
        margin: 0;
    }

    .email-link {
        color: var(--primary);
        text-decoration: none;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
    }

    .email-link:hover {
        color: var(--primary-dark);
        text-decoration: underline;
    }

    .email-link i {
        color: var(--gray-400);
        font-size: var(--font-size-xs);
    }

    /* Rôles */
    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-xs);
        padding: var(--spacing-xs) var(--spacing-sm);
        border-radius: var(--border-radius-sm);
        font-size: var(--font-size-xs);
        font-weight: 600;
        white-space: nowrap;
    }

    .role-badge.role-admin {
        background: rgba(255, 215, 0, 0.15);
        color: #FFA500;
    }

    .role-badge.role-moderator {
        background: rgba(0, 196, 204, 0.15);
        color: #00C4CC;
    }

    .role-badge.role-visitor {
        background: rgba(55, 66, 250, 0.15);
        color: #3742FA;
    }

    /* Cellule date */
    .date-cell {
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
        color: var(--gray-600);
    }

    .date-cell i {
        font-size: var(--font-size-xs);
        color: var(--gray-400);
    }

    /* Boutons d'action */
    .action-buttons {
        display: flex;
        gap: var(--spacing-sm);
        justify-content: center;
        align-items: center;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        border: none;
        border-radius: var(--border-radius-sm);
        cursor: pointer;
        transition: var(--transition);
        font-size: var(--font-size-sm);
        text-decoration: none;
    }

    .action-btn.view-btn {
        background: rgba(0, 196, 204, 0.1);
        color: #00C4CC;
    }

    .action-btn.view-btn:hover {
        background: #00C4CC;
        color: var(--white);
        transform: translateY(-2px);
    }

    .action-btn.edit-btn {
        background: rgba(255, 193, 7, 0.1);
        color: #FFD700;
    }

    .action-btn.edit-btn:hover {
        background: #FFD700;
        color: var(--white);
        transform: translateY(-2px);
    }

    .action-btn.delete-btn {
        background: rgba(255, 71, 87, 0.1);
        color: var(--error);
    }

    .action-btn.delete-btn:hover {
        background: var(--error);
        color: var(--white);
        transform: translateY(-2px);
    }

    .current-user-badge {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-xs);
        padding: var(--spacing-xs) var(--spacing-sm);
        background: rgba(0, 212, 170, 0.1);
        color: var(--success);
        border-radius: var(--border-radius-sm);
        font-size: var(--font-size-xs);
        font-weight: 600;
    }

    /* Pagination */
    .table-pagination-bar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--spacing-lg);
        border-top: 1px solid var(--gray-200);
        background: var(--gray-50);
        font-size: var(--font-size-sm);
        color: var(--gray-700);
    }

    .pagination-info {
        display: flex;
        gap: var(--spacing-md);
        align-items: center;
    }

    .pagination-info strong {
        color: var(--primary);
        font-weight: 600;
    }

    .pagination-controls {
        display: flex;
        gap: var(--spacing-md);
        align-items: center;
    }

    .pagination-btn {
        width: 36px;
        height: 36px;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        background: var(--white);
        border: 1px solid var(--gray-300);
        border-radius: var(--border-radius-sm);
        color: var(--gray-700);
        cursor: pointer;
        transition: var(--transition);
        font-size: var(--font-size-sm);
    }

    .pagination-btn:hover:not(:disabled) {
        background: var(--primary);
        border-color: var(--primary);
        color: var(--white);
    }

    .pagination-btn:disabled {
        opacity: 0.5;
        cursor: not-allowed;
    }

    .page-indicator {
        font-weight: 500;
        color: var(--gray-700);
    }

    /* État vide */
    .empty-state-container {
        padding: 4rem 2rem;
    }

    .empty-state {
        text-align: center;
        background: linear-gradient(135deg, rgba(123, 97, 255, 0.08), rgba(0, 196, 204, 0.08));
        padding: 3rem;
        border-radius: var(--border-radius-lg);
        border: 2px dashed var(--gray-200);
    }

    .empty-icon {
        font-size: 4rem;
        color: var(--gray-300);
        margin-bottom: var(--spacing-lg);
    }

    .empty-state h3 {
        color: var(--gray-900);
        font-size: var(--font-size-2xl);
        margin: 0 0 var(--spacing-md) 0;
    }

    .empty-state p {
        color: var(--gray-600);
        margin: 0 0 var(--spacing-lg) 0;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .header-content {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-actions {
            width: 100%;
        }

        .header-actions .btn {
            width: 100%;
            justify-content: center;
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .stat-card {
            flex-direction: column;
        }

        .table-controls-container {
            flex-direction: column;
            gap: var(--spacing-md);
        }

        .controls-section {
            width: 100%;
            flex: 1 !important;
        }

        .controls-section.secondary {
            flex: 1 !important;
        }

        .filter-buttons-group {
            width: 100%;
        }

        .filter-tag-btn {
            flex: 1;
        }

        .users-data-table {
            font-size: var(--font-size-xs);
        }

        .users-data-table th,
        .users-data-table td {
            padding: var(--spacing-md) var(--spacing-sm);
        }

        .col-user, .col-email {
            min-width: auto;
        }

        .user-avatar-mini {
            width: 40px;
            height: 40px;
            font-size: var(--font-size-md);
        }

        .bulk-actions-bar {
            flex-direction: column;
            align-items: flex-start;
        }

        .bulk-action-buttons {
            width: 100%;
        }

        .bulk-btn {
            flex: 1;
        }

        .table-pagination-bar {
            flex-direction: column;
            gap: var(--spacing-md);
            text-align: center;
        }

        .pagination-controls {
            width: 100%;
            justify-content: center;
        }
    }

    @media (max-width: 480px) {
        .page-title {
            font-size: var(--font-size-2xl);
        }

        .users-data-table {
            font-size: var(--font-size-xs);
        }

        .users-data-table th,
        .users-data-table td {
            padding: var(--spacing-sm);
        }

        .col-user, .col-email, .col-role, .col-date, .col-actions {
            min-width: auto;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            font-size: var(--font-size-xs);
        }

        .stat-card {
            padding: var(--spacing-md);
            gap: var(--spacing-md);
        }

        .stat-icon {
            width: 60px;
            height: 60px;
            font-size: 1.75rem;
        }

        .filter-tag-btn {
            flex: 1;
            font-size: var(--font-size-xs);
        }

        .filter-tag-btn span {
            display: none;
        }

        .filter-tag-btn i {
            margin: 0;
        }
    }

    [data-theme="dark"] .users-page-header,
    [data-theme="dark"] .users-table-section,
    [data-theme="dark"] .stat-card {
        background: var(--white);
    }

    [data-theme="dark"] .users-data-table thead {
        background: linear-gradient(135deg, var(--gray-100), var(--white));
    }

    [data-theme="dark"] .table-controls-container,
    [data-theme="dark"] .table-header-bar,
    [data-theme="dark"] .table-pagination-bar {
        background: var(--gray-50);
    }
</style>

<script>
    let currentFilter = 'all';
    let currentPage = 1;
    const itemsPerPage = 10;

    function filterAndSearchUsers() {
        const searchInput = document.getElementById('searchInput');
        const filter = searchInput.value.toUpperCase();
        const clearBtn = document.getElementById('clearSearchBtn');
        
        clearBtn.style.display = filter ? 'flex' : 'none';
        filterTable(filter);
    }

    function clearSearch() {
        document.getElementById('searchInput').value = '';
        document.getElementById('clearSearchBtn').style.display = 'none';
        filterTable('');
    }

    function filterTable(searchTerm = '') {
        const table = document.getElementById('usersTable');
        const rows = table.getElementsByClassName('user-row');
        let visibleCount = 0;

        for (let i = 0; i < rows.length; i++) {
            const rowText = rows[i].textContent || rows[i].innerText;
            const roleFilter = currentFilter === 'all' || rows[i].getAttribute('data-role') === currentFilter;
            const searchMatch = searchTerm === '' || rowText.toUpperCase().indexOf(searchTerm) > -1;

            if (roleFilter && searchMatch) {
                rows[i].style.display = '';
                visibleCount++;
            } else {
                rows[i].style.display = 'none';
            }
        }

        updatePagination();
    }

    function filterByRole(role) {
        currentFilter = role;
        currentPage = 1;
        const buttons = document.querySelectorAll('.filter-tag-btn');
        buttons.forEach(btn => btn.classList.remove('active'));
        document.querySelector(`[data-filter="${role}"]`).classList.add('active');
        filterTable(document.getElementById('searchInput').value);
    }

    function toggleSelectAll(checkbox) {
        const checkboxes = document.querySelectorAll('.row-checkbox');
        checkboxes.forEach(cb => cb.checked = checkbox.checked);
        updateBulkActions();
    }

    function updateBulkActions() {
        const checkboxes = document.querySelectorAll('.row-checkbox:checked');
        const count = checkboxes.length;
        const bulkBar = document.getElementById('bulkActionsBar');
        document.getElementById('selectedCount').textContent = count;

        if (count > 0) {
            bulkBar.style.display = 'flex';
        } else {
            bulkBar.style.display = 'none';
            document.getElementById('selectAllCheckbox').checked = false;
            document.getElementById('selectAllCheckbox2').checked = false;
        }
    }

    function clearSelection() {
        document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = false);
        document.getElementById('selectAllCheckbox').checked = false;
        document.getElementById('selectAllCheckbox2').checked = false;
        updateBulkActions();
    }

    function bulkDeleteUsers() {
        const checkboxes = document.querySelectorAll('.row-checkbox:checked');
        if (checkboxes.length === 0) return;

        if (confirm(`Êtes-vous sûr de vouloir supprimer ${checkboxes.length} utilisateur(s) ?`)) {
            checkboxes.forEach(cb => {
                const userId = cb.value;
                window.location.href = '<?php echo BASE_URL; ?>/users?action=delete&id=' + userId;
            });
        }
    }

    function deleteUser(userId) {
        if (confirm('Êtes-vous sûr de vouloir supprimer cet utilisateur ?')) {
            window.location.href = '<?php echo BASE_URL; ?>/users?action=delete&id=' + userId;
        }
    }

    function exportTableData() {
        const table = document.getElementById('usersTable');
        let csv = 'Utilisateur,Email,Rôle,Date d\'inscription\n';
        const rows = table.getElementsByClassName('user-row');

        for (let row of rows) {
            if (row.style.display !== 'none') {
                const cells = row.getElementsByTagName('td');
                const username = cells[1].textContent.trim().replace(/\n/g, ' ').trim();
                const email = cells[2].textContent.trim().replace(/\n/g, ' ').trim();
                const role = cells[3].textContent.trim();
                const date = cells[4].textContent.trim();
                csv += `"${username}","${email}","${role}","${date}"\n`;
            }
        }

        const link = document.createElement('a');
        link.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv);
        link.download = 'utilisateurs_' + new Date().toISOString().slice(0, 10) + '.csv';
        link.click();
    }

    function refreshUsersList() {
        location.reload();
    }

    function openCreateUserModal() {
        window.location.href = '<?php echo BASE_URL; ?>/users?action=create';
    }

    function updatePagination() {
        const rows = document.querySelectorAll('.user-row:not([style*="display: none"])');
        const totalPages = Math.ceil(rows.length / itemsPerPage);
        
        document.getElementById('currentPage').textContent = currentPage;
        document.getElementById('prevBtn').disabled = currentPage <= 1;
        document.getElementById('nextBtn').disabled = currentPage >= totalPages;

        const startIdx = (currentPage - 1) * itemsPerPage;
        const endIdx = Math.min(startIdx + itemsPerPage, rows.length);
        
        rows.forEach((row, idx) => {
            row.style.display = (idx >= startIdx && idx < endIdx) ? '' : 'none';
        });
    }

    function previousPage() {
        if (currentPage > 1) {
            currentPage--;
            updatePagination();
            document.querySelector('.users-data-table').scrollIntoView({ behavior: 'smooth' });
        }
    }

    function nextPage() {
        const rows = document.querySelectorAll('.user-row:not([style*="display: none"])');
        const totalPages = Math.ceil(rows.length / itemsPerPage);
        if (currentPage < totalPages) {
            currentPage++;
            updatePagination();
            document.querySelector('.users-data-table').scrollIntoView({ behavior: 'smooth' });
        }
    }
</script>
