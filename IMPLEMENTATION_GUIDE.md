# Guide d'Implémentation - Refonte du Design

## 1. USERS - Index des utilisateurs

### ❌ Avant (Actuel)
```php
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Utilisateurs</h1>
    <a href="..." class="btn btn-primary">Ajouter un utilisateur</a>
</div>

<div class="card">
    <div class="card-body">
        <table class="table table-striped">
            <!-- Contenu du tableau -->
        </table>
    </div>
</div>
```

### ✅ Après (Recommandé)
```php
<!-- En-tête moderne -->
<div class="nav-container">
    <div class="nav-left">
        <h1>Utilisateurs</h1>
        <p class="nav-date">Gestion complète des utilisateurs du système</p>
    </div>
    <div class="nav-actions">
        <a href="<?php echo BASE_URL; ?>/users?action=create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un utilisateur
        </a>
    </div>
</div>

<!-- Statistiques KPI -->
<div class="kpi-grid">
    <div class="kpi-card members">
        <div class="kpi-header">
            <div class="kpi-content">
                <h2><?php echo count($users); ?></h2>
                <p>Total utilisateurs</p>
            </div>
            <div class="kpi-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
        <div class="kpi-details">
            <div class="detail-item">
                <span class="metric-value"><?php echo array_sum(array_column($users, 'role' === 'admin' ? 1 : 0)); ?></span> Admins
            </div>
        </div>
    </div>

    <div class="kpi-card members">
        <div class="kpi-header">
            <div class="kpi-content">
                <h2><?php echo date('Y-m-d'); ?></h2>
                <p>Dernière création</p>
            </div>
            <div class="kpi-icon">
                <i class="fas fa-calendar"></i>
            </div>
        </div>
    </div>
</div>

<!-- Tableau moderne -->
<div class="chart-card large">
    <div class="chart-header">
        <h3>Liste des utilisateurs</h3>
        <div class="chart-controls">
            <button class="chart-filter active">Tous</button>
            <button class="chart-filter">Admins</button>
            <button class="chart-filter">Modérateurs</button>
        </div>
    </div>
    <div class="chart-content">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Nom d'utilisateur</th>
                        <th>Email</th>
                        <th>Rôle</th>
                        <th>Date de création</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($user['username']); ?></td>
                            <td><?php echo htmlspecialchars($user['email']); ?></td>
                            <td>
                                <span class="badge bg-<?php
                                    echo match ($user['role']) {
                                        'admin' => 'danger',
                                        'moderator' => 'warning',
                                        'visitor' => 'info',
                                        default => 'secondary'
                                    };
                                ?>">
                                    <?php
                                    echo match ($user['role']) {
                                        'admin' => 'Administrateur',
                                        'moderator' => 'Modérateur',
                                        'visitor' => 'Visiteur',
                                        default => $user['role']
                                    };
                                    ?>
                                </span>
                            </td>
                            <td><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></td>
                            <td>
                                <a href="<?php echo BASE_URL; ?>/users?action=edit&id=<?php echo $user['id']; ?>" class="btn btn-sm btn-warning">
                                    <i class="fas fa-edit"></i> Modifier
                                </a>
                                <?php if ($user['id'] != $_SESSION['user']['id']): ?>
                                    <a href="<?php echo BASE_URL; ?>/users?action=delete&id=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger" data-confirm="Êtes-vous sûr ?">
                                        <i class="fas fa-trash"></i> Supprimer
                                    </a>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
```

---

## 2. MEMBERS - Index des membres

### ✅ Après (Recommandé)
```php
<!-- En-tête avec actions -->
<div class="nav-container">
    <div class="nav-left">
        <h1>Membres</h1>
        <p class="nav-date">Total: <?php echo count($members); ?> membres inscrits</p>
    </div>
    <div class="nav-actions">
        <a href="<?php echo BASE_URL; ?>/members?action=export" class="btn btn-success">
            <i class="fas fa-download"></i> Exporter CSV
        </a>
        <a href="<?php echo BASE_URL; ?>/members?action=create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un membre
        </a>
    </div>
</div>

<!-- KPI Cards Statistiques -->
<div class="kpi-grid">
    <div class="kpi-card members">
        <div class="kpi-header">
            <div class="kpi-content">
                <h2><?php echo count(array_filter($members, fn($m) => $m['status'] === 'active')); ?></h2>
                <p>Membres actifs</p>
            </div>
            <div class="kpi-icon">
                <i class="fas fa-user-check"></i>
            </div>
        </div>
    </div>

    <div class="kpi-card projects">
        <div class="kpi-header">
            <div class="kpi-content">
                <h2><?php echo count(array_filter($members, fn($m) => $m['status'] === 'inactive')); ?></h2>
                <p>Inactifs</p>
            </div>
            <div class="kpi-icon">
                <i class="fas fa-user-clock"></i>
            </div>
        </div>
    </div>

    <div class="kpi-card crm">
        <div class="kpi-header">
            <div class="kpi-content">
                <h2><?php echo count($members); ?></h2>
                <p>Total</p>
            </div>
            <div class="kpi-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>
</div>

<!-- Section Filtres -->
<div class="detailed-kpis-section">
    <div class="section-header">
        <h2>Filtrer les membres</h2>
    </div>
    <form method="GET" class="row g-3">
        <div class="col-md-4">
            <label for="search" class="form-label">Rechercher</label>
            <div class="search-input-wrapper">
                <i class="fas fa-search search-icon"></i>
                <input type="text" class="search-input" id="search" name="search" 
                       value="<?php echo htmlspecialchars($search); ?>" 
                       placeholder="Nom, prénom ou email">
            </div>
        </div>
        <div class="col-md-3">
            <label for="status" class="form-label">Statut</label>
            <select class="form-control" id="status" name="status">
                <option value="">Tous</option>
                <option value="active" <?php echo $status === 'active' ? 'selected' : ''; ?>>Actif</option>
                <option value="inactive" <?php echo $status === 'inactive' ? 'selected' : ''; ?>>Inactif</option>
            </select>
        </div>
        <div class="col-md-2">
            <label class="form-label">&nbsp;</label>
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-filter"></i> Filtrer
            </button>
        </div>
        <div class="col-md-3">
            <label class="form-label">&nbsp;</label>
            <a href="<?php echo BASE_URL; ?>/members" class="btn btn-outline-primary w-100">
                <i class="fas fa-redo"></i> Réinitialiser
            </a>
        </div>
    </form>
</div>

<!-- Tableau moderne -->
<div class="chart-card large">
    <div class="chart-header">
        <h3>Liste des membres</h3>
        <div class="chart-controls">
            <button class="chart-filter active">Tous (<?php echo count($members); ?>)</button>
            <button class="chart-filter">Actifs</button>
            <button class="chart-filter">Inactifs</button>
        </div>
    </div>
    <div class="chart-content">
        <?php if (!empty($members)): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Prénom</th>
                            <th>Email</th>
                            <th>Téléphone</th>
                            <th>Date d'adhésion</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($members as $member): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($member['last_name']); ?></td>
                                <td><?php echo htmlspecialchars($member['first_name']); ?></td>
                                <td><?php echo htmlspecialchars($member['email']); ?></td>
                                <td><?php echo htmlspecialchars($member['phone'] ?? ''); ?></td>
                                <td><?php echo date('d/m/Y', strtotime($member['join_date'])); ?></td>
                                <td>
                                    <span class="badge bg-<?php echo $member['status'] === 'active' ? 'success' : 'secondary'; ?>">
                                        <i class="fas fa-<?php echo $member['status'] === 'active' ? 'check-circle' : 'times-circle'; ?>"></i>
                                        <?php echo $member['status'] === 'active' ? 'Actif' : 'Inactif'; ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/members?action=show&id=<?php echo $member['id']; ?>" class="btn btn-sm btn-info" title="Voir détails">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/members?action=edit&id=<?php echo $member['id']; ?>" class="btn btn-sm btn-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/members?action=delete&id=<?php echo $member['id']; ?>" class="btn btn-sm btn-danger" data-confirm="Êtes-vous sûr ?" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <div style="font-size: 3rem; color: var(--gray-300); margin-bottom: 1rem;">
                    <i class="fas fa-inbox"></i>
                </div>
                <p class="text-muted">Aucun membre trouvé.</p>
                <a href="<?php echo BASE_URL; ?>/members?action=create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Ajouter le premier membre
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
```

---

## 3. MEMBERS - Show (Détail d'un membre)

### ✅ Nouveau (Recommandé)
```php
<?php $pageTitle = 'Détail du Membre'; ?>

<!-- En-tête -->
<div class="nav-container">
    <div class="nav-left">
        <h1><?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?></h1>
        <p class="nav-date">Inscrit depuis <?php echo date('d/m/Y', strtotime($member['join_date'])); ?></p>
    </div>
    <div class="nav-actions">
        <a href="<?php echo BASE_URL; ?>/members?action=edit&id=<?php echo $member['id']; ?>" class="btn btn-primary">
            <i class="fas fa-edit"></i> Modifier
        </a>
        <a href="<?php echo BASE_URL; ?>/members" class="btn btn-outline-primary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<!-- Main Content -->
<div class="main-content">
    <div class="content-container">
        <!-- Card Principale -->
        <div class="kpi-card">
            <div class="chart-header">
                <h3>Information du membre</h3>
                <div class="chart-controls">
                    <span class="badge bg-<?php echo $member['status'] === 'active' ? 'success' : 'secondary'; ?>">
                        <?php echo $member['status'] === 'active' ? 'Actif' : 'Inactif'; ?>
                    </span>
                </div>
            </div>
            <div class="chart-content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-item">
                            <strong>Email:</strong> <?php echo htmlspecialchars($member['email']); ?>
                        </div>
                        <div class="detail-item">
                            <strong>Téléphone:</strong> <?php echo htmlspecialchars($member['phone'] ?? 'N/A'); ?>
                        </div>
                        <div class="detail-item">
                            <strong>Adresse:</strong> <?php echo htmlspecialchars($member['address'] ?? 'N/A'); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-item">
                            <strong>Code postal:</strong> <?php echo htmlspecialchars($member['postal_code'] ?? 'N/A'); ?>
                        </div>
                        <div class="detail-item">
                            <strong>Ville:</strong> <?php echo htmlspecialchars($member['city'] ?? 'N/A'); ?>
                        </div>
                        <div class="detail-item">
                            <strong>Pays:</strong> <?php echo htmlspecialchars($member['country'] ?? 'N/A'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Rapides -->
        <div class="quick-access-grid">
            <a href="<?php echo BASE_URL; ?>/projects?member=<?php echo $member['id']; ?>" class="quick-link">
                <i class="fas fa-project-diagram"></i>
                <span>Projets</span>
            </a>
            <a href="<?php echo BASE_URL; ?>/events?member=<?php echo $member['id']; ?>" class="quick-link">
                <i class="fas fa-calendar"></i>
                <span>Événements</span>
            </a>
            <a href="<?php echo BASE_URL; ?>/donations?member=<?php echo $member['id']; ?>" class="quick-link">
                <i class="fas fa-donate"></i>
                <span>Dons</span>
            </a>
            <a href="<?php echo BASE_URL; ?>/members?action=edit&id=<?php echo $member['id']; ?>" class="quick-link">
                <i class="fas fa-edit"></i>
                <span>Modifier</span>
            </a>
        </div>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Widget Résumé -->
        <div class="sidebar-widget">
            <div class="widget-header">
                <h4><i class="fas fa-info-circle"></i> Résumé</h4>
            </div>
            <div class="widget-content">
                <div class="system-metrics">
                    <div class="metric">
                        <div class="metric-label">Statut</div>
                        <span class="badge bg-<?php echo $member['status'] === 'active' ? 'success' : 'secondary'; ?>">
                            <?php echo $member['status'] === 'active' ? 'Actif' : 'Inactif'; ?>
                        </span>
                    </div>
                    <div class="metric">
                        <div class="metric-label">ID Membre</div>
                        <div class="metric-value"><?php echo $member['id']; ?></div>
                    </div>
                    <div class="metric">
                        <div class="metric-label">Inscription</div>
                        <div class="metric-value text-muted"><?php echo date('d/m/Y', strtotime($member['join_date'])); ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Widget Activité -->
        <div class="sidebar-widget">
            <div class="widget-header">
                <h4><i class="fas fa-clock"></i> Activité Récente</h4>
            </div>
            <div class="widget-content">
                <div class="task-item">
                    <div class="status-indicator completed"></div>
                    <div class="task-content">
                        <div class="task-title">Profil créé</div>
                        <div class="task-meta"><?php echo date('d/m/Y', strtotime($member['created_at'])); ?></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
```

---

## 4. PROJECTS - Index

### ✅ Après (Recommandé)
```php
<?php $pageTitle = 'Gestion des Projets'; ?>

<!-- En-tête -->
<div class="nav-container">
    <div class="nav-left">
        <h1>Projets</h1>
        <p class="nav-date">Suivi et gestion de vos projets</p>
    </div>
    <div class="nav-actions">
        <a href="<?php echo BASE_URL; ?>/projects?action=create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un projet
        </a>
    </div>
</div>

<!-- KPI Statistiques -->
<div class="kpi-grid">
    <div class="kpi-card projects">
        <div class="kpi-header">
            <div class="kpi-content">
                <h2><?php echo count(array_filter($projects, fn($p) => $p['status'] === 'active')); ?></h2>
                <p>Projets actifs</p>
            </div>
            <div class="kpi-icon">
                <i class="fas fa-play-circle"></i>
            </div>
        </div>
    </div>

    <div class="kpi-card finance">
        <div class="kpi-header">
            <div class="kpi-content">
                <h2><?php echo number_format(array_sum(array_column($projects, 'budget')), 0, ',', ' '); ?> €</h2>
                <p>Budget total</p>
            </div>
            <div class="kpi-icon">
                <i class="fas fa-money-bill"></i>
            </div>
        </div>
    </div>

    <div class="kpi-card success">
        <div class="kpi-header">
            <div class="kpi-content">
                <h2><?php echo count(array_filter($projects, fn($p) => $p['status'] === 'completed')); ?></h2>
                <p>Terminés</p>
            </div>
            <div class="kpi-icon">
                <i class="fas fa-check-circle"></i>
            </div>
        </div>
    </div>

    <div class="kpi-card events">
        <div class="kpi-header">
            <div class="kpi-content">
                <h2><?php echo count($projects); ?></h2>
                <p>Total</p>
            </div>
            <div class="kpi-icon">
                <i class="fas fa-folder"></i>
            </div>
        </div>
    </div>
</div>

<!-- Filtres -->
<div class="detailed-kpis-section">
    <div class="section-header">
        <h2>Filtrer les projets</h2>
    </div>
    <form method="GET" class="row g-3">
        <div class="col-md-6">
            <label for="status" class="form-label">Statut</label>
            <select class="form-control" id="status" name="status">
                <option value="">Tous les statuts</option>
                <option value="planning" <?php echo $status === 'planning' ? 'selected' : ''; ?>>Planification</option>
                <option value="active" <?php echo $status === 'active' ? 'selected' : ''; ?>>Actif</option>
                <option value="completed" <?php echo $status === 'completed' ? 'selected' : ''; ?>>Terminé</option>
                <option value="on_hold" <?php echo $status === 'on_hold' ? 'selected' : ''; ?>>En attente</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">&nbsp;</label>
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-filter"></i> Filtrer
            </button>
        </div>
        <div class="col-md-3">
            <label class="form-label">&nbsp;</label>
            <a href="<?php echo BASE_URL; ?>/projects" class="btn btn-outline-primary w-100">
                <i class="fas fa-redo"></i> Réinitialiser
            </a>
        </div>
    </form>
</div>

<!-- Tableau Projets -->
<div class="chart-card large">
    <div class="chart-header">
        <h3>Tous les projets</h3>
        <div class="chart-controls">
            <button class="chart-filter active">Tous (<?php echo count($projects); ?>)</button>
            <button class="chart-filter">Actifs</button>
            <button class="chart-filter">Planifiés</button>
            <button class="chart-filter">Terminés</button>
        </div>
    </div>
    <div class="chart-content">
        <?php if (!empty($projects)): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Nom</th>
                            <th>Description</th>
                            <th>Début</th>
                            <th>Fin</th>
                            <th>Budget</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($projects as $project): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($project['name']); ?></strong>
                                </td>
                                <td><?php echo htmlspecialchars(substr($project['description'] ?? '', 0, 50)) . (strlen($project['description'] ?? '') > 50 ? '...' : ''); ?></td>
                                <td><?php echo $project['start_date'] ? date('d/m/Y', strtotime($project['start_date'])) : '-'; ?></td>
                                <td><?php echo $project['end_date'] ? date('d/m/Y', strtotime($project['end_date'])) : '-'; ?></td>
                                <td><?php echo $project['budget'] ? number_format($project['budget'], 2, ',', ' ') . ' €' : '-'; ?></td>
                                <td>
                                    <span class="badge bg-<?php
                                        echo match ($project['status']) {
                                            'planning' => 'secondary',
                                            'active' => 'success',
                                            'completed' => 'info',
                                            'on_hold' => 'warning',
                                            default => 'secondary'
                                        };
                                    ?>">
                                        <?php
                                        echo match ($project['status']) {
                                            'planning' => 'Planification',
                                            'active' => 'Actif',
                                            'completed' => 'Terminé',
                                            'on_hold' => 'En attente',
                                            default => $project['status']
                                        };
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/projects?action=show&id=<?php echo $project['id']; ?>" class="btn btn-sm btn-info" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/projects?action=edit&id=<?php echo $project['id']; ?>" class="btn btn-sm btn-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/projects?action=delete&id=<?php echo $project['id']; ?>" class="btn btn-sm btn-danger" data-confirm="Êtes-vous sûr ?" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <div style="font-size: 3rem; color: var(--gray-300); margin-bottom: 1rem;">
                    <i class="fas fa-folder-open"></i>
                </div>
                <p class="text-muted">Aucun projet trouvé.</p>
                <a href="<?php echo BASE_URL; ?>/projects?action=create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Créer le premier projet
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
```

---

## 5. EVENTS - Index

### ✅ Après (Recommandé)
```php
<?php $pageTitle = 'Gestion des Événements'; ?>

<!-- En-tête -->
<div class="nav-container">
    <div class="nav-left">
        <h1>Événements</h1>
        <p class="nav-date">Planification et suivi de vos événements</p>
    </div>
    <div class="nav-actions">
        <a href="<?php echo BASE_URL; ?>/events?action=create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un événement
        </a>
    </div>
</div>

<!-- KPI Statistiques -->
<div class="kpi-grid">
    <div class="kpi-card events">
        <div class="kpi-header">
            <div class="kpi-content">
                <h2><?php echo count(array_filter($events, fn($e) => $e['status'] === 'planned')); ?></h2>
                <p>À venir</p>
            </div>
            <div class="kpi-icon">
                <i class="fas fa-calendar-plus"></i>
            </div>
        </div>
    </div>

    <div class="kpi-card hr">
        <div class="kpi-header">
            <div class="kpi-content">
                <h2><?php echo count(array_filter($events, fn($e) => $e['status'] === 'ongoing')); ?></h2>
                <p>En cours</p>
            </div>
            <div class="kpi-icon">
                <i class="fas fa-play"></i>
            </div>
        </div>
    </div>

    <div class="kpi-card success">
        <div class="kpi-header">
            <div class="kpi-content">
                <h2><?php echo count(array_filter($events, fn($e) => $e['status'] === 'completed')); ?></h2>
                <p>Terminés</p>
            </div>
            <div class="kpi-icon">
                <i class="fas fa-check"></i>
            </div>
        </div>
    </div>

    <div class="kpi-card events">
        <div class="kpi-header">
            <div class="kpi-content">
                <h2><?php echo count($events); ?></h2>
                <p>Total</p>
            </div>
            <div class="kpi-icon">
                <i class="fas fa-calendar"></i>
            </div>
        </div>
    </div>
</div>

<!-- Filtres -->
<div class="detailed-kpis-section">
    <div class="section-header">
        <h2>Filtrer les événements</h2>
    </div>
    <form method="GET" class="row g-3">
        <div class="col-md-6">
            <label for="status" class="form-label">Statut</label>
            <select class="form-control" id="status" name="status">
                <option value="">Tous les statuts</option>
                <option value="planned" <?php echo $status === 'planned' ? 'selected' : ''; ?>>Planifié</option>
                <option value="ongoing" <?php echo $status === 'ongoing' ? 'selected' : ''; ?>>En cours</option>
                <option value="completed" <?php echo $status === 'completed' ? 'selected' : ''; ?>>Terminé</option>
                <option value="cancelled" <?php echo $status === 'cancelled' ? 'selected' : ''; ?>>Annulé</option>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">&nbsp;</label>
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-filter"></i> Filtrer
            </button>
        </div>
        <div class="col-md-3">
            <label class="form-label">&nbsp;</label>
            <a href="<?php echo BASE_URL; ?>/events" class="btn btn-outline-primary w-100">
                <i class="fas fa-redo"></i> Réinitialiser
            </a>
        </div>
    </form>
</div>

<!-- Tableau Événements -->
<div class="chart-card large">
    <div class="chart-header">
        <h3>Tous les événements</h3>
        <div class="chart-controls">
            <button class="chart-filter active">Tous (<?php echo count($events); ?>)</button>
            <button class="chart-filter">À venir</button>
            <button class="chart-filter">En cours</button>
            <button class="chart-filter">Terminés</button>
        </div>
    </div>
    <div class="chart-content">
        <?php if (!empty($events)): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Titre</th>
                            <th>Date</th>
                            <th>Lieu</th>
                            <th>Participants max</th>
                            <th>Statut</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events as $event): ?>
                            <tr>
                                <td><strong><?php echo htmlspecialchars($event['title']); ?></strong></td>
                                <td>
                                    <i class="fas fa-calendar"></i> <?php echo date('d/m/Y H:i', strtotime($event['event_date'])); ?>
                                </td>
                                <td>
                                    <i class="fas fa-map-marker-alt"></i> <?php echo htmlspecialchars($event['location'] ?? 'En ligne'); ?>
                                </td>
                                <td><?php echo $event['max_participants'] ?? '∞'; ?></td>
                                <td>
                                    <span class="badge bg-<?php
                                        echo match ($event['status']) {
                                            'planned' => 'secondary',
                                            'ongoing' => 'success',
                                            'completed' => 'info',
                                            'cancelled' => 'danger',
                                            default => 'secondary'
                                        };
                                    ?>">
                                        <?php
                                        echo match ($event['status']) {
                                            'planned' => 'Planifié',
                                            'ongoing' => 'En cours',
                                            'completed' => 'Terminé',
                                            'cancelled' => 'Annulé',
                                            default => $event['status']
                                        };
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/events?action=show&id=<?php echo $event['id']; ?>" class="btn btn-sm btn-info" title="Voir">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/events?action=edit&id=<?php echo $event['id']; ?>" class="btn btn-sm btn-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/events?action=delete&id=<?php echo $event['id']; ?>" class="btn btn-sm btn-danger" data-confirm="Êtes-vous sûr ?" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <div style="font-size: 3rem; color: var(--gray-300); margin-bottom: 1rem;">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <p class="text-muted">Aucun événement trouvé.</p>
                <a href="<?php echo BASE_URL; ?>/events?action=create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Créer un événement
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
```

---

## 6. DONATIONS - Index

### ✅ Après (Recommandé)
```php
<?php $pageTitle = 'Gestion des Dons'; ?>

<!-- En-tête -->
<div class="nav-container">
    <div class="nav-left">
        <h1>Dons</h1>
        <p class="nav-date">Suivi des donations reçues</p>
    </div>
    <div class="nav-actions">
        <a href="<?php echo BASE_URL; ?>/donations?action=export" class="btn btn-success me-2">
            <i class="fas fa-download"></i> Exporter CSV
        </a>
        <a href="<?php echo BASE_URL; ?>/donations?action=create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter un don
        </a>
    </div>
</div>

<!-- KPI Statistiques Financières -->
<div class="kpi-grid">
    <div class="kpi-card finance">
        <div class="kpi-header">
            <div class="kpi-content">
                <h2><?php echo number_format($total_amount, 2, ',', ' '); ?> €</h2>
                <p>Total des dons</p>
            </div>
            <div class="kpi-icon">
                <i class="fas fa-euro-sign"></i>
            </div>
        </div>
        <div class="kpi-details">
            <div class="detail-item">
                <span class="trend-value positive">
                    <!-- Vous pouvez ajouter la tendance ici -->
                    +12% ce mois
                </span>
            </div>
        </div>
    </div>

    <div class="kpi-card finance-advanced">
        <div class="kpi-header">
            <div class="kpi-content">
                <h2><?php echo $total_donations; ?></h2>
                <p>Nombre de dons</p>
            </div>
            <div class="kpi-icon">
                <i class="fas fa-donate"></i>
            </div>
        </div>
    </div>

    <div class="kpi-card crm">
        <div class="kpi-header">
            <div class="kpi-content">
                <h2><?php echo $total_donations > 0 ? number_format($total_amount / $total_donations, 2, ',', ' ') : '0,00'; ?> €</h2>
                <p>Moyenne par don</p>
            </div>
            <div class="kpi-icon">
                <i class="fas fa-chart-line"></i>
            </div>
        </div>
    </div>

    <div class="kpi-card documents">
        <div class="kpi-header">
            <div class="kpi-content">
                <h2><?php echo $unique_donors ?? 0; ?></h2>
                <p>Donateurs uniques</p>
            </div>
            <div class="kpi-icon">
                <i class="fas fa-users"></i>
            </div>
        </div>
    </div>
</div>

<!-- Filtres -->
<div class="detailed-kpis-section">
    <div class="section-header">
        <h2>Filtrer les dons</h2>
    </div>
    <form method="GET" class="row g-3">
        <div class="col-md-4">
            <label for="project_id" class="form-label">Projet</label>
            <select class="form-control" id="project_id" name="project_id">
                <option value="">Tous les projets</option>
                <?php if (!empty($projects)): ?>
                    <?php foreach ($projects as $project): ?>
                        <option value="<?php echo $project['id']; ?>" <?php echo $project_id == $project['id'] ? 'selected' : ''; ?>>
                            <?php echo htmlspecialchars($project['name']); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>
        <div class="col-md-3">
            <label class="form-label">&nbsp;</label>
            <button type="submit" class="btn btn-primary w-100">
                <i class="fas fa-filter"></i> Filtrer
            </button>
        </div>
        <div class="col-md-3">
            <label class="form-label">&nbsp;</label>
            <a href="<?php echo BASE_URL; ?>/donations" class="btn btn-outline-primary w-100">
                <i class="fas fa-redo"></i> Réinitialiser
            </a>
        </div>
        <div class="col-md-2">
            <label class="form-label">&nbsp;</label>
            <a href="<?php echo BASE_URL; ?>/donations?action=export" class="btn btn-success w-100">
                <i class="fas fa-download"></i> Export
            </a>
        </div>
    </form>
</div>

<!-- Tableau Dons -->
<div class="chart-card large">
    <div class="chart-header">
        <h3>Tous les dons</h3>
        <div class="chart-controls">
            <button class="chart-filter active">Tous (<?php echo count($donations); ?>)</button>
        </div>
    </div>
    <div class="chart-content">
        <?php if (!empty($donations)): ?>
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th>Donateur</th>
                            <th>Email</th>
                            <th>Montant</th>
                            <th>Date</th>
                            <th>Projet</th>
                            <th>Méthode</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($donations as $donation): ?>
                            <tr>
                                <td>
                                    <strong><?php echo htmlspecialchars($donation['donor_name']); ?></strong>
                                </td>
                                <td><?php echo htmlspecialchars($donation['donor_email'] ?? ''); ?></td>
                                <td>
                                    <span class="trend-value positive">
                                        <?php echo number_format($donation['amount'], 2, ',', ' '); ?> €
                                    </span>
                                </td>
                                <td><?php echo date('d/m/Y', strtotime($donation['donation_date'])); ?></td>
                                <td><?php echo htmlspecialchars($donation['project_name'] ?? 'Général'); ?></td>
                                <td>
                                    <span class="badge bg-secondary">
                                        <?php
                                        echo match ($donation['payment_method']) {
                                            'cash' => 'Espèces',
                                            'bank_transfer' => 'Virement',
                                            'online' => 'En ligne',
                                            default => $donation['payment_method']
                                        };
                                        ?>
                                    </span>
                                </td>
                                <td>
                                    <a href="<?php echo BASE_URL; ?>/donations?action=edit&id=<?php echo $donation['id']; ?>" class="btn btn-sm btn-warning" title="Modifier">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <a href="<?php echo BASE_URL; ?>/donations?action=delete&id=<?php echo $donation['id']; ?>" class="btn btn-sm btn-danger" data-confirm="Êtes-vous sûr ?" title="Supprimer">
                                        <i class="fas fa-trash"></i>
                                    </a>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="text-center py-5">
                <div style="font-size: 3rem; color: var(--gray-300); margin-bottom: 1rem;">
                    <i class="fas fa-inbox"></i>
                </div>
                <p class="text-muted">Aucun don enregistré.</p>
                <a href="<?php echo BASE_URL; ?>/donations?action=create" class="btn btn-primary">
                    <i class="fas fa-plus"></i> Enregistrer un don
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>
```

---

## 7. SEARCH - Index

### ✅ Après (Recommandé)
```php
<!-- Utiliser le header existant -->
<?php
require_once 'views/header.php';
?>

<div class="main-content">
    <!-- Section Héro -->
    <div class="hero-section">
        <div class="hero-container">
            <h1 class="hero-title">Résultats de recherche</h1>
            <?php if (!empty($query)): ?>
                <p class="hero-subtitle">
                    Résultats pour "<strong><?php echo htmlspecialchars($query); ?></strong>"
                </p>
            <?php else: ?>
                <p class="hero-subtitle">Trouvez ce que vous cherchez dans notre système</p>
            <?php endif; ?>
        </div>
    </div>

    <div class="content-container">
        <?php if (empty($results['members']) && empty($results['projects']) && empty($results['events']) && empty($results['donations'])): ?>
            <!-- Aucun résultat -->
            <div class="sidebar-widget" style="margin: 2rem auto; text-align: center; max-width: 400px;">
                <div class="widget-content">
                    <div style="font-size: 4rem; color: var(--gray-300); margin-bottom: 1rem;">
                        <i class="fas fa-search"></i>
                    </div>
                    <h3>Aucun résultat trouvé</h3>
                    <p>Essayez d'ajuster vos termes de recherche ou vérifiez l'orthographe.</p>
                </div>
            </div>
        <?php else: ?>
            <!-- Membres -->
            <?php if (!empty($results['members'])): ?>
                <div class="content-container">
                    <div class="section-header">
                        <h2><i class="fas fa-users"></i> Membres (<?php echo count($results['members']); ?>)</h2>
                    </div>
                    <div class="search-results-grid">
                        <?php foreach ($results['members'] as $member): ?>
                            <div class="sidebar-widget">
                                <div class="widget-content">
                                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                                        <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, var(--primary), var(--primary-light)); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <div>
                                            <h5 style="margin: 0;"><?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?></h5>
                                            <p style="margin: 0; color: var(--gray-500); font-size: 0.875rem;"> <?php echo htmlspecialchars($member['email']); ?></p>
                                        </div>
                                    </div>
                                    <a href="<?php echo BASE_URL; ?>/members?action=show&id=<?php echo $member['id']; ?>" class="btn btn-primary w-100">
                                        <i class="fas fa-arrow-right"></i> Voir le profil
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Projets -->
            <?php if (!empty($results['projects'])): ?>
                <div class="content-container">
                    <div class="section-header">
                        <h2><i class="fas fa-project-diagram"></i> Projets (<?php echo count($results['projects']); ?>)</h2>
                    </div>
                    <div class="search-results-grid">
                        <?php foreach ($results['projects'] as $project): ?>
                            <div class="sidebar-widget">
                                <div class="widget-content">
                                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                                        <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, var(--warning), var(--accent)); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                                            <i class="fas fa-project-diagram"></i>
                                        </div>
                                        <div>
                                            <h5 style="margin: 0;"><?php echo htmlspecialchars($project['name']); ?></h5>
                                            <p style="margin: 0; color: var(--gray-500); font-size: 0.875rem;">
                                                <?php echo htmlspecialchars(substr($project['description'], 0, 50)) . '...'; ?>
                                            </p>
                                        </div>
                                    </div>
                                    <a href="<?php echo BASE_URL; ?>/projects?action=show&id=<?php echo $project['id']; ?>" class="btn btn-primary w-100">
                                        <i class="fas fa-arrow-right"></i> Voir le projet
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Événements -->
            <?php if (!empty($results['events'])): ?>
                <div class="content-container">
                    <div class="section-header">
                        <h2><i class="fas fa-calendar-alt"></i> Événements (<?php echo count($results['events']); ?>)</h2>
                    </div>
                    <div class="search-results-grid">
                        <?php foreach ($results['events'] as $event): ?>
                            <div class="sidebar-widget">
                                <div class="widget-content">
                                    <div style="display: flex; align-items: center; gap: 1rem; margin-bottom: 1rem;">
                                        <div style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, var(--accent), var(--primary)); display: flex; align-items: center; justify-content: center; color: white; font-size: 1.5rem;">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                        <div>
                                            <h5 style="margin: 0;"><?php echo htmlspecialchars($event['title']); ?></h5>
                                            <p style="margin: 0; color: var(--gray-500); font-size: 0.875rem;">
                                                <?php echo date('d/m/Y', strtotime($event['event_date'])); ?>
                                            </p>
                                        </div>
                                    </div>
                                    <a href="<?php echo BASE_URL; ?>/events?action=show&id=<?php echo $event['id']; ?>" class="btn btn-primary w-100">
                                        <i class="fas fa-arrow-right"></i> Voir l'événement
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Dons -->
            <?php if (!empty($results['donations'])): ?>
                <div class="content-container">
                    <div class="section-header">
                        <h2><i class="fas fa-donate"></i> Dons (<?php echo count($results['donations']); ?>)</h2>
                    </div>
                    <div class="search-results-grid">
                        <?php foreach ($results['donations'] as $donation): ?>
                            <div class="sidebar-widget">
                                <div class="widget-content">
                                    <div style="margin-bottom: 1rem;">
                                        <h5 style="margin: 0;"><?php echo htmlspecialchars($donation['donor_name']); ?></h5>
                                        <p style="margin: 0.5rem 0 0 0; color: var(--gray-500); font-size: 0.875rem;">
                                            <?php echo htmlspecialchars($donation['project_name'] ?? 'Donation générale'); ?>
                                        </p>
                                    </div>
                                    <p style="margin: 1rem 0; font-size: 1.5rem; font-weight: 700; color: var(--success);">
                                        <?php echo number_format($donation['amount'], 2, ',', ' '); ?> €
                                    </p>
                                    <a href="<?php echo BASE_URL; ?>/donations?action=show&id=<?php echo $donation['id']; ?>" class="btn btn-primary w-100">
                                        <i class="fas fa-arrow-right"></i> Voir le don
                                    </a>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>
```

---

## Notes d'Implémentation

### CSS à Vérifier
- `.nav-container` - Déjà dans le style.css ✅
- `.kpi-grid`, `.kpi-card` - Déjà dans le style.css ✅
- `.chart-card` - Déjà dans le style.css ✅
- `.btn` classes - Déjà dans le style.css ✅
- `.sidebar-widget` - Déjà dans le style.css ✅
- `.search-results-grid` - À vérifier ou créer

### Icône Font Awesome
Assurez-vous que Font Awesome est inclus dans [views/header.php](views/header.php):
```html
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
```

### Classes Bootstrap
Les classes Bootstrap anciennes peuvent être progressivement supprimées:
- `.d-flex` → déjà dans le CSS
- `.table-striped` → garder pour compatibilité
- `.badge` → utiliser avec les couleurs du système

### Test Responsive
Vérifier sur:
- Mobile (< 480px)
- Tablet (480px - 768px)
- Desktop (> 768px)
- Large Desktop (> 1280px)
