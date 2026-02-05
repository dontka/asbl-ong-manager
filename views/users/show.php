<?php $pageTitle = 'Profil Utilisateur'; ?>

<div class="profile-page-header">
    <div class="header-wrapper">
        <div class="user-header-content">
            <div class="user-avatar-large">
                <?php echo strtoupper(substr($user['username'], 0, 1)); ?>
            </div>
            <div class="user-header-info">
                <h1 class="profile-title"><?php echo htmlspecialchars($user['username']); ?></h1>
                <div class="profile-meta">
                    <div class="profile-role">
                        <?php
                        $roleLabel = match ($user['role']) {
                            'admin' => 'Administrateur',
                            'moderator' => 'Modérateur',
                            'visitor' => 'Visiteur',
                            default => ucfirst($user['role'])
                        };
                        $roleIcon = match ($user['role']) {
                            'admin' => 'crown',
                            'moderator' => 'certificate',
                            'visitor' => 'user-circle',
                            default => 'user'
                        };
                        ?>
                        <i class="fas fa-<?php echo $roleIcon; ?>"></i>
                        <span><?php echo $roleLabel; ?></span>
                    </div>
                    <div class="profile-since">
                        <i class="fas fa-calendar-alt"></i>
                        <span>Depuis <?php echo date('d/m/Y', strtotime($user['created_at'])); ?></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="header-actions">
            <a href="<?php echo BASE_URL; ?>/users?action=edit&id=<?php echo $user['id']; ?>" class="btn btn-primary" title="Modifier ce profil">
                <i class="fas fa-edit"></i>
                <span>Modifier</span>
            </a>
            <a href="<?php echo BASE_URL; ?>/users" class="btn btn-secondary" title="Retour à la liste">
                <i class="fas fa-arrow-left"></i>
                <span>Retour</span>
            </a>
        </div>
    </div>
</div>

<div class="profile-container">
    <div class="profile-main">
        <!-- Carte informations -->
        <div class="profile-card">
            <div class="card-header">
                <h2><i class="fas fa-user-circle"></i> Informations du compte</h2>
                <p>Détails de connexion et informations personnelles</p>
            </div>
            <div class="card-body">
                <div class="info-grid">
                    <div class="info-block">
                        <label class="info-label">
                            <i class="fas fa-hashtag"></i>
                            Identifiant utilisateur
                        </label>
                        <div class="info-value">ID #<?php echo $user['id']; ?></div>
                    </div>
                    <div class="info-block">
                        <label class="info-label">
                            <i class="fas fa-user"></i>
                            Nom d'utilisateur
                        </label>
                        <div class="info-value"><?php echo htmlspecialchars($user['username']); ?></div>
                    </div>
                    <div class="info-block">
                        <label class="info-label">
                            <i class="fas fa-envelope"></i>
                            Adresse email
                        </label>
                        <a href="mailto:<?php echo htmlspecialchars($user['email']); ?>" class="info-value email-link">
                            <?php echo htmlspecialchars($user['email']); ?>
                        </a>
                    </div>
                    <div class="info-block">
                        <label class="info-label">
                            <i class="fas fa-shield-alt"></i>
                            Rôle d'accès
                        </label>
                        <div class="info-value">
                            <span class="role-badge role-<?php echo $user['role']; ?>">
                                <i class="fas fa-<?php echo $roleIcon; ?>"></i>
                                <span><?php echo $roleLabel; ?></span>
                            </span>
                        </div>
                    </div>
                    <div class="info-block">
                        <label class="info-label">
                            <i class="fas fa-calendar-check"></i>
                            Date de création
                        </label>
                        <div class="info-value"><?php echo date('d/m/Y à H:i', strtotime($user['created_at'])); ?></div>
                    </div>
                    <div class="info-block">
                        <label class="info-label">
                            <i class="fas fa-sync-alt"></i>
                            Dernière modification
                        </label>
                        <div class="info-value"><?php echo date('d/m/Y à H:i', strtotime($user['updated_at'] ?? $user['created_at'])); ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Permissions -->
        <div class="profile-card">
            <div class="card-header">
                <h2><i class="fas fa-key"></i> Permissions</h2>
                <p>Les fonctionnalités accessibles par ce rôle</p>
            </div>
            <div class="card-body">
                <div class="permissions-list">
                    <?php
                    $permissions = match ($user['role']) {
                        'admin' => [
                            'Accès à tous les modules' => 'Gestion complète du système',
                            'Création/modification d\'utilisateurs' => 'Gestion des droits d\'accès',
                            'Consultation des rapports' => 'Accès à tous les rapports du système',
                            'Paramètres système' => 'Configuration du système',
                        ],
                        'moderator' => [
                            'Modération des contenus' => 'Approbation des modifications',
                            'Consultation des rapports' => 'Accès aux rapports restreints',
                            'Gestion de catégories' => 'Création et modification de catégories',
                        ],
                        'visitor' => [
                            'Consultation des contenus' => 'Accès en lecture seule',
                            'Commentaires limités' => 'Contribution restrictive',
                        ],
                        default => ['Permissions non définies' => 'Rôle inconnu']
                    };

                    foreach ($permissions as $permission => $description) {
                        echo '<div class="permission-item">';
                        echo '<div class="permission-check"><i class="fas fa-check-circle"></i></div>';
                        echo '<div class="permission-content">';
                        echo '<strong>' . htmlspecialchars($permission) . '</strong>';
                        echo '<p>' . htmlspecialchars($description) . '</p>';
                        echo '</div>';
                        echo '</div>';
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>

    <!-- Sidebar -->
    <aside class="profile-sidebar">
        <!-- Actions rapides -->
        <div class="sidebar-widget">
            <div class="widget-title">
                <i class="fas fa-bolt"></i>
                <span>Actions rapides</span>
            </div>
            <div class="widget-content">
                <a href="<?php echo BASE_URL; ?>/users?action=edit&id=<?php echo $user['id']; ?>" class="widget-action-btn">
                    <i class="fas fa-pen"></i>
                    <span>Modifier le profil</span>
                </a>
                <a href="mailto:<?php echo htmlspecialchars($user['email']); ?>" class="widget-action-btn">
                    <i class="fas fa-envelope"></i>
                    <span>Envoyer un email</span>
                </a>
                <?php if ($user['id'] != $_SESSION['user']['id']): ?>
                <button onclick="if(confirm('Supprimer cet utilisateur ?')) window.location='<?php echo BASE_URL; ?>/users?action=delete&id=<?php echo $user['id']; ?>'" class="widget-action-btn delete">
                    <i class="fas fa-trash-alt"></i>
                    <span>Supprimer</span>
                </button>
                <?php endif; ?>
            </div>
        </div>

        <!-- Résumé du compte -->
        <div class="sidebar-widget">
            <div class="widget-title">
                <i class="fas fa-info-circle"></i>
                <span>Résumé</span>
            </div>
            <div class="widget-content">
                <div class="summary-item">
                    <span class="summary-label">Statut</span>
                    <span class="summary-badge active"><i class="fas fa-circle"></i> Actif</span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Type de compte</span>
                    <span class="summary-value"><?php echo $roleLabel; ?></span>
                </div>
                <div class="summary-item">
                    <span class="summary-label">Affiliation</span>
                    <span class="summary-value">Système</span>
                </div>
            </div>
        </div>

        <!-- Avertissements -->
        <div class="sidebar-widget warning">
            <div class="widget-title">
                <i class="fas fa-exclamation-triangle"></i>
                <span>Attention</span>
            </div>
            <div class="widget-content">
                <p>Modification prudente recommandée. Les changements de rôle affectent immédiatement les permissions de l'utilisateur.</p>
            </div>
        </div>
    </aside>
</div>

<style>
    .profile-page-header {
        background: linear-gradient(135deg, var(--primary), var(--primary-light));
        color: var(--white);
        padding: var(--spacing-xl);
        margin-bottom: var(--spacing-lg);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-lg);
    }

    .profile-page-header .header-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: var(--spacing-lg);
        flex-wrap: wrap;
    }

    .user-header-content {
        display: flex;
        align-items: center;
        gap: var(--spacing-lg);
        flex: 1;
        min-width: 300px;
    }

    .user-avatar-large {
        width: 100px;
        height: 100px;
        border-radius: 50%;
        background: rgba(255, 255, 255, 0.2);
        border: 3px solid var(--white);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: var(--font-size-5xl);
        font-weight: 700;
        flex-shrink: 0;
    }

    .user-header-info {
        flex: 1;
    }

    .profile-title {
        font-size: var(--font-size-4xl);
        font-weight: 700;
        margin: 0 0 var(--spacing-sm) 0;
    }

    .profile-meta {
        display: flex;
        gap: var(--spacing-lg);
        flex-wrap: wrap;
    }

    .profile-role, .profile-since {
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
        background: rgba(255, 255, 255, 0.15);
        padding: var(--spacing-sm) var(--spacing-md);
        border-radius: var(--border-radius);
        font-weight: 500;
    }

    .header-actions {
        display: flex;
        gap: var(--spacing-md);
        flex-wrap: wrap;
    }

    .header-actions .btn {
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
    }

    .profile-container {
        display: grid;
        grid-template-columns: 1fr 380px;
        gap: var(--spacing-lg);
    }

    .profile-main {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-lg);
    }

    .profile-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .card-header {
        padding: var(--spacing-lg);
        border-bottom: 1px solid var(--gray-200);
        background: linear-gradient(135deg, var(--gray-50), var(--white));
    }

    .card-header h2 {
        font-size: var(--font-size-2xl);
        font-weight: 700;
        color: var(--gray-900);
        margin: 0 0 var(--spacing-xs) 0;
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
    }

    .card-header h2 i {
        color: var(--primary);
    }

    .card-header p {
        font-size: var(--font-size-sm);
        color: var(--gray-600);
        margin: 0;
    }

    .card-body {
        padding: var(--spacing-lg);
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
        gap: var(--spacing-lg);
    }

    .info-block {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-sm);
    }

    .info-label {
        font-weight: 600;
        color: var(--gray-700);
        font-size: var(--font-size-sm);
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
        margin: 0;
    }

    .info-label i {
        color: var(--primary);
    }

    .info-value {
        font-size: var(--font-size-md);
        color: var(--gray-900);
        font-weight: 500;
    }

    .email-link {
        color: var(--primary);
        text-decoration: none;
        transition: var(--transition);
    }

    .email-link:hover {
        text-decoration: underline;
    }

    .role-badge {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-xs);
        padding: var(--spacing-xs) var(--spacing-sm);
        border-radius: var(--border-radius-sm);
        font-size: var(--font-size-sm);
        font-weight: 600;
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

    .permissions-list {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-lg);
    }

    .permission-item {
        display: flex;
        gap: var(--spacing-md);
        padding: var(--spacing-md);
        background: rgba(123, 97, 255, 0.05);
        border-radius: var(--border-radius);
        border-left: 3px solid var(--primary);
    }

    .permission-check {
        color: var(--success);
        font-size: var(--font-size-lg);
        flex-shrink: 0;
        display: flex;
        align-items: flex-start;
    }

    .permission-content strong {
        color: var(--gray-900);
        font-size: var(--font-size-md);
        display: block;
        margin-bottom: var(--spacing-xs);
    }

    .permission-content p {
        color: var(--gray-600);
        font-size: var(--font-size-sm);
        margin: 0;
    }

    .profile-sidebar {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-lg);
    }

    .sidebar-widget {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--border-radius-lg);
        padding: var(--spacing-lg);
        box-shadow: var(--shadow-sm);
    }

    .sidebar-widget.warning {
        background: linear-gradient(135deg, rgba(255, 232, 31, 0.1), rgba(255, 152, 0, 0.05));
        border-color: rgba(255, 152, 0, 0.3);
    }

    .widget-title {
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
        font-weight: 700;
        color: var(--gray-900);
        margin: 0 0 var(--spacing-md) 0;
        font-size: var(--font-size-md);
    }

    .widget-title i {
        color: var(--primary);
    }

    .sidebar-widget.warning .widget-title i {
        color: #FFA500;
    }

    .widget-content {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-sm);
    }

    .widget-action-btn {
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
        padding: var(--spacing-sm) var(--spacing-md);
        background: var(--white);
        border: 1px solid var(--gray-300);
        border-radius: var(--border-radius);
        color: var(--gray-700);
        text-decoration: none;
        cursor: pointer;
        transition: var(--transition);
        font-size: var(--font-size-sm);
        font-weight: 500;
    }

    .widget-action-btn:hover {
        background: var(--primary);
        border-color: var(--primary);
        color: var(--white);
    }

    .widget-action-btn.delete {
        color: var(--error);
        border-color: var(--error);
    }

    .widget-action-btn.delete:hover {
        background: var(--error);
        border-color: var(--error);
        color: var(--white);
    }

    .summary-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--spacing-sm) 0;
        border-bottom: 1px solid var(--gray-200);
    }

    .summary-item:last-child {
        border-bottom: none;
    }

    .summary-label {
        font-weight: 600;
        color: var(--gray-700);
        font-size: var(--font-size-sm);
    }

    .summary-value, .summary-badge {
        font-size: var(--font-size-sm);
        color: var(--primary);
        font-weight: 500;
    }

    .summary-badge {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-xs);
        padding: var(--spacing-xs) var(--spacing-sm);
        background: rgba(0, 212, 170, 0.1);
        border-radius: var(--border-radius-sm);
        color: var(--success);
    }

    .summary-badge i {
        font-size: 0.5rem;
    }

    .sidebar-widget.warning .widget-content {
        font-size: var(--font-size-sm);
        color: var(--gray-600);
        line-height: 1.6;
    }

    .sidebar-widget.warning p {
        margin: 0;
    }

    @media (max-width: 768px) {
        .profile-container {
            grid-template-columns: 1fr;
        }

        .profile-page-header .header-wrapper {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-actions {
            width: 100%;
        }

        .header-actions .btn {
            flex: 1;
            justify-content: center;
        }

        .user-avatar-large {
            width: 80px;
            height: 80px;
            font-size: var(--font-size-4xl);
        }

        .info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>