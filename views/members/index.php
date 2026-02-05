<?php $pageTitle = 'Gestion des Membres'; ?>

<!-- En-tête -->
<div class="nav-container">
    <div class="nav-left">
        <h1>Membres</h1>
        <p class="nav-date">Total: <?php echo count($members); ?> membres inscrits</p>
    </div>
    <div class="nav-actions">
        <a href="<?php echo BASE_URL; ?>/members?action=export<?php echo !empty($search) ? '&search=' . urlencode($search) : ''; ?><?php echo !empty($status) ? '&status=' . urlencode($status) : ''; ?>" class="btn btn-success">
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

    <div class="kpi-card events">
        <div class="kpi-header">
            <div class="kpi-content">
                <h2><?php echo !empty($members) ? date('d/m/Y', strtotime($members[0]['join_date'] ?? 'now')) : 'N/A'; ?></h2>
                <p>Adhésion récente</p>
            </div>
            <div class="kpi-icon">
                <i class="fas fa-calendar"></i>
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
                                    <a href="<?php echo BASE_URL; ?>/members?action=delete&id=<?php echo $member['id']; ?>" class="btn btn-sm btn-danger" data-confirm="Êtes-vous sûr de vouloir supprimer ce membre ?" title="Supprimer">
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