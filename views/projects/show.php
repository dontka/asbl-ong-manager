<?php $pageTitle = 'Détails du Projet'; ?>

<div class="nav-container">
    <div class="nav-left">
        <h1><?php echo htmlspecialchars($project['name']); ?></h1>
        <p class="nav-date">
            <i class="fas fa-calendar"></i>
            <?php echo $project['start_date'] ? 'Du ' . date('d/m/Y', strtotime($project['start_date'])) : 'Date de début'; ?>
            <?php echo $project['end_date'] ? ' au ' . date('d/m/Y', strtotime($project['end_date'])) : ''; ?>
        </p>
    </div>
    <div class="nav-actions">
        <a href="<?php echo BASE_URL; ?>/projects?action=edit&id=<?php echo $project['id']; ?>" class="btn btn-warning">
            <i class="fas fa-edit"></i> Modifier
        </a>
        <a href="<?php echo BASE_URL; ?>/projects" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour
        </a>
    </div>
</div>

<div class="main-content">
    <div class="content-container">
        <!-- Project Stats KPI Card -->
        <div class="kpi-card projects">
            <div class="kpi-header">
                <div class="kpi-content">
                    <h2>Informations principales</h2>
                    <p><?php echo htmlspecialchars(substr($project['description'] ?? 'Pas de description', 0, 100)); ?>...</p>
                </div>
            </div>
            <div class="detail-items">
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-tag"></i> Statut</span>
                    <span class="detail-value">
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
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-euro-sign"></i> Budget</span>
                    <span class="detail-value">
                        <strong><?php echo $project['budget'] ? number_format($project['budget'], 2, ',', ' ') . ' €' : 'Non défini'; ?></strong>
                    </span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-user-tie"></i> Responsable</span>
                    <span class="detail-value"><?php echo htmlspecialchars($project['manager_name'] ?? 'Non assigné'); ?></span>
                </div>
                <div class="detail-item">
                    <span class="detail-label"><i class="fas fa-clock"></i> Créé le</span>
                    <span class="detail-value"><?php echo date('d/m/Y H:i', strtotime($project['created_at'])); ?></span>
                </div>
            </div>
        </div>

        <!-- Donations Table -->
        <?php if (!empty($project_donations)): ?>
            <div class="chart-card large" style="margin-top: 24px;">
                <div class="chart-header">
                    <h3>Dons reçus pour ce projet</h3>
                    <div class="chart-controls">
                        <span class="badge bg-finance"><?php echo count($project_donations); ?> don(s)</span>
                    </div>
                </div>
                <div class="chart-content">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th><i class="fas fa-user"></i> Donateur</th>
                                    <th><i class="fas fa-euro-sign"></i> Montant</th>
                                    <th><i class="fas fa-calendar"></i> Date</th>
                                    <th style="text-align: center;">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($project_donations as $donation): ?>
                                    <tr>
                                        <td><strong><?php echo htmlspecialchars($donation['donor_name']); ?></strong></td>
                                        <td class="trend-value positive"><?php echo number_format($donation['amount'], 2, ',', ' '); ?> €</td>
                                        <td><?php echo date('d/m/Y', strtotime($donation['donation_date'])); ?></td>
                                        <td style="text-align: center;">
                                            <a href="<?php echo BASE_URL; ?>/donations?action=show&id=<?php echo $donation['id'] ?? ''; ?>" title="Voir le don" class="btn btn-sm btn-outline-primary">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                            <tfoot>
                                <tr style="font-weight: bold;">
                                    <td>Total</td>
                                    <td class="trend-value positive"><?php echo number_format(array_sum(array_column($project_donations, 'amount')), 2, ',', ' '); ?> €</td>
                                    <td colspan="2"></td>
                                </tr>
                            </tfoot>
                        </table>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <div class="alert-item" style="margin-top: 24px;">
                <div style="text-align: center; padding: 40px;">
                    <i class="fas fa-gift" style="font-size: 48px; color: var(--primary); opacity: 0.3;"></i>
                    <p style="margin-top: 12px; color: var(--text-secondary);">Aucun don reçu pour ce projet</p>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Quick Actions Widget -->
        <div class="sidebar-widget">
            <div class="widget-header">
                <h4><i class="fas fa-bolt"></i> Actions rapides</h4>
            </div>
            <div class="widget-body">
                <a href="<?php echo BASE_URL; ?>/projects?action=edit&id=<?php echo $project['id']; ?>" class="widget-link">
                    <i class="fas fa-pencil-alt"></i>
                    <span>Modifier le projet</span>
                </a>
                <a href="<?php echo BASE_URL; ?>/donations?project_id=<?php echo $project['id']; ?>" class="widget-link">
                    <i class="fas fa-donate"></i>
                    <span>Voir tous les dons</span>
                </a>
                <a href="<?php echo BASE_URL; ?>/projects?action=delete&id=<?php echo $project['id']; ?>" class="widget-link" data-confirm="Êtes-vous sûr de vouloir supprimer ce projet ? Cette action est irréversible.">
                    <i class="fas fa-trash-alt"></i>
                    <span>Supprimer</span>
                </a>
            </div>
        </div>

        <!-- Project Summary Widget -->
        <div class="sidebar-widget">
            <div class="widget-header">
                <h4><i class="fas fa-info-circle"></i> Résumé</h4>
            </div>
            <div class="widget-body">
                <div class="task-item">
                    <span class="task-label">ID Projet</span>
                    <span class="task-value"><?php echo $project['id']; ?></span>
                </div>
                <div class="task-item">
                    <span class="task-label">Dons reçus</span>
                    <span class="task-value"><?php echo !empty($project_donations) ? count($project_donations) : 0; ?></span>
                </div>
                <div class="task-item">
                    <span class="task-label">Montant collecté</span>
                    <span class="task-value metric-bar">
                        <?php 
                        $collected = !empty($project_donations) ? array_sum(array_column($project_donations, 'amount')) : 0;
                        $budget = $project['budget'] ?? 0;
                        $percentage = $budget > 0 ? min(100, round(($collected / $budget) * 100)) : 0;
                        ?>
                        <div class="metric-bar-fill" style="width: <?php echo $percentage; ?>%;" title="<?php echo $percentage; ?>%"></div>
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
