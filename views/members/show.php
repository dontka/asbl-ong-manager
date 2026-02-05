<?php $pageTitle = 'Détails du Membre'; ?>

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
        <!-- Card Principale Informations -->
        <div class="kpi-card">
            <div class="chart-header">
                <h3>Information du membre</h3>
                <div class="chart-controls">
                    <span class="badge bg-<?php echo $member['status'] === 'active' ? 'success' : 'secondary'; ?>">
                        <i class="fas fa-<?php echo $member['status'] === 'active' ? 'check-circle' : 'times-circle'; ?>"></i>
                        <?php echo $member['status'] === 'active' ? 'Actif' : 'Inactif'; ?>
                    </span>
                </div>
            </div>
            <div class="chart-content">
                <div class="row">
                    <div class="col-md-6">
                        <div class="detail-item" style="margin-bottom: 1rem;">
                            <strong><i class="fas fa-envelope"></i> Email:</strong><br>
                            <a href="mailto:<?php echo htmlspecialchars($member['email']); ?>"><?php echo htmlspecialchars($member['email']); ?></a>
                        </div>
                        <div class="detail-item" style="margin-bottom: 1rem;">
                            <strong><i class="fas fa-phone"></i> Téléphone:</strong><br>
                            <?php if (!empty($member['phone'])): ?>
                                <a href="tel:<?php echo htmlspecialchars($member['phone']); ?>"><?php echo htmlspecialchars($member['phone']); ?></a>
                            <?php else: ?>
                                N/A
                            <?php endif; ?>
                        </div>
                        <div class="detail-item" style="margin-bottom: 1rem;">
                            <strong><i class="fas fa-map-pin"></i> Adresse:</strong><br>
                            <?php echo nl2br(htmlspecialchars($member['address'] ?? 'Non spécifiée')); ?>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="detail-item" style="margin-bottom: 1rem;">
                            <strong><i class="fas fa-home"></i> Code postal:</strong><br>
                            <?php echo htmlspecialchars($member['postal_code'] ?? 'N/A'); ?>
                        </div>
                        <div class="detail-item" style="margin-bottom: 1rem;">
                            <strong><i class="fas fa-city"></i> Ville:</strong><br>
                            <?php echo htmlspecialchars($member['city'] ?? 'N/A'); ?>
                        </div>
                        <div class="detail-item" style="margin-bottom: 1rem;">
                            <strong><i class="fas fa-globe"></i> Pays:</strong><br>
                            <?php echo htmlspecialchars($member['country'] ?? 'N/A'); ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actions Rapides -->
        <div class="quick-access-grid">
            <a href="<?php echo BASE_URL; ?>/projects" class="quick-link">
                <i class="fas fa-project-diagram"></i>
                <span>Projets</span>
            </a>
            <a href="<?php echo BASE_URL; ?>/events" class="quick-link">
                <i class="fas fa-calendar"></i>
                <span>Événements</span>
            </a>
            <a href="<?php echo BASE_URL; ?>/donations" class="quick-link">
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
                    <div class="metric" style="margin-bottom: 1rem;">
                        <div class="metric-label">Statut</div>
                        <span class="badge bg-<?php echo $member['status'] === 'active' ? 'success' : 'secondary'; ?>" style="width: 100%;">
                            <?php echo $member['status'] === 'active' ? 'Actif' : 'Inactif'; ?>
                        </span>
                    </div>
                    <div class="metric" style="margin-bottom: 1rem;">
                        <div class="metric-label">ID Membre</div>
                        <div class="metric-value">#<?php echo $member['id']; ?></div>
                    </div>
                    <div class="metric">
                        <div class="metric-label">Date d'adhésion</div>
                        <div class="metric-value text-muted"><?php echo date('d/m/Y', strtotime($member['join_date'])); ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Widget Activité -->
        <div class="sidebar-widget">
            <div class="widget-header">
                <h4><i class="fas fa-history"></i> Historique</h4>
            </div>
            <div class="widget-content">
                <div class="task-item">
                    <div class="status-indicator completed"></div>
                    <div class="task-content">
                        <div class="task-title">Créé le</div>
                        <div class="task-meta"><?php echo date('d/m/Y H:i', strtotime($member['created_at'])); ?></div>
                    </div>
                </div>
                <div class="task-item">
                    <div class="status-indicator completed"></div>
                    <div class="task-content">
                        <div class="task-title">Modifié le</div>
                        <div class="task-meta"><?php echo date('d/m/Y H:i', strtotime($member['updated_at'])); ?></div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Widget Actions -->
        <div class="sidebar-widget">
            <div class="widget-header">
                <h4><i class="fas fa-cog"></i> Actions</h4>
            </div>
            <div class="widget-content">
                <a href="<?php echo BASE_URL; ?>/members?action=edit&id=<?php echo $member['id']; ?>" class="btn btn-primary w-100 mb-2">
                    <i class="fas fa-edit"></i> Modifier
                </a>
                <?php if (!empty($member['email'])): ?>
                    <a href="mailto:<?php echo htmlspecialchars($member['email']); ?>" class="btn btn-info w-100 mb-2">
                        <i class="fas fa-envelope"></i> Email
                    </a>
                <?php endif; ?>
                <?php if (!empty($member['phone'])): ?>
                    <a href="tel:<?php echo htmlspecialchars($member['phone']); ?>" class="btn btn-info w-100 mb-2">
                        <i class="fas fa-phone"></i> Appeler
                    </a>
                <?php endif; ?>
                <a href="<?php echo BASE_URL; ?>/members?action=delete&id=<?php echo $member['id']; ?>" class="btn btn-danger w-100" data-confirm="Êtes-vous sûr de vouloir supprimer ce membre ? Cette action est irréversible.">
                    <i class="fas fa-trash"></i> Supprimer
                </a>
            </div>
        </div>
    </div>
</div>
