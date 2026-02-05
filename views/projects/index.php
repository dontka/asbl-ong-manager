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
                                    <a href="<?php echo BASE_URL; ?>/projects?action=delete&id=<?php echo $project['id']; ?>" class="btn btn-sm btn-danger" data-confirm="Êtes-vous sûr de vouloir supprimer ce projet ?" title="Supprimer">
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
