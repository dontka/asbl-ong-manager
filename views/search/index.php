<?php
require_once 'views/header.php';
?>

<div class="nav-container">
    <div class="nav-left">
        <h1><i class="fas fa-search"></i> Résultats de recherche</h1>
        <p class="nav-date">
            <?php if (!empty($query)): ?>
                Résultats pour : <strong><?php echo htmlspecialchars($query); ?></strong>
            <?php else: ?>
                Explorez vos données
            <?php endif; ?>
        </p>
    </div>
    <div class="nav-actions">
        <form method="get" action="<?php echo BASE_URL; ?>/search" style="display: flex; gap: 8px;">
            <input type="text" name="query" placeholder="Rechercher..." value="<?php echo htmlspecialchars($query ?? ''); ?>" class="form-control" style="width: 250px;">
            <button type="submit" class="btn btn-primary">
                <i class="fas fa-search"></i> Chercher
            </button>
        </form>
    </div>
</div>

<?php if (empty($results['members']) && empty($results['projects']) && empty($results['events']) && empty($results['donations'])): ?>
    <div style="text-align: center; padding: 60px 20px;">
        <i class="fas fa-search" style="font-size: 64px; color: var(--primary); opacity: 0.3;"></i>
        <h3 style="margin-top: 20px; color: var(--text-secondary);">Aucun résultat trouvé</h3>
        <p style="color: var(--text-secondary); margin-bottom: 20px;">Essayez d'ajuster vos termes de recherche ou vérifiez l'orthographe.</p>
    </div>
<?php else: ?>
    <!-- Members Results -->
    <?php if (!empty($results['members'])): ?>
        <div class="chart-card" style="margin-bottom: 32px;">
            <div class="chart-header">
                <h3><i class="fas fa-users"></i> Membres (<?php echo count($results['members']); ?>)</h3>
            </div>
            <div class="chart-content">
                <div class="search-results-grid">
                    <?php foreach ($results['members'] as $member): ?>
                        <div class="search-result-card">
                            <div class="result-icon members">
                                <i class="fas fa-user-circle"></i>
                            </div>
                            <div class="result-content">
                                <h5><?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?></h5>
                                <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($member['email']); ?></p>
                                <span class="badge bg-secondary" style="margin-top: 8px;">ID: <?php echo $member['id']; ?></span>
                            </div>
                            <div class="result-actions">
                                <a href="<?php echo BASE_URL; ?>/members?action=show&id=<?php echo $member['id']; ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Projects Results -->
    <?php if (!empty($results['projects'])): ?>
        <div class="chart-card" style="margin-bottom: 32px;">
            <div class="chart-header">
                <h3><i class="fas fa-project-diagram"></i> Projets (<?php echo count($results['projects']); ?>)</h3>
            </div>
            <div class="chart-content">
                <div class="search-results-grid">
                    <?php foreach ($results['projects'] as $project): ?>
                        <div class="search-result-card">
                            <div class="result-icon projects">
                                <i class="fas fa-folder-open"></i>
                            </div>
                            <div class="result-content">
                                <h5><?php echo htmlspecialchars($project['name']); ?></h5>
                                <p><?php echo htmlspecialchars(substr($project['description'] ?? '', 0, 100)); ?><?php echo strlen($project['description'] ?? '') > 100 ? '...' : ''; ?></p>
                                <span class="badge bg-<?php
                                    echo match ($project['status']) {
                                        'planning' => 'secondary',
                                        'active' => 'success',
                                        'completed' => 'info',
                                        'on_hold' => 'warning',
                                        default => 'secondary'
                                    };
                                    ?>" style="margin-top: 8px;">
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
                            </div>
                            <div class="result-actions">
                                <a href="<?php echo BASE_URL; ?>/projects?action=show&id=<?php echo $project['id']; ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Events Results -->
    <?php if (!empty($results['events'])): ?>
        <div class="chart-card" style="margin-bottom: 32px;">
            <div class="chart-header">
                <h3><i class="fas fa-calendar-alt"></i> Événements (<?php echo count($results['events']); ?>)</h3>
            </div>
            <div class="chart-content">
                <div class="search-results-grid">
                    <?php foreach ($results['events'] as $event): ?>
                        <div class="search-result-card">
                            <div class="result-icon events">
                                <i class="fas fa-calendar-check"></i>
                            </div>
                            <div class="result-content">
                                <h5><?php echo htmlspecialchars($event['title']); ?></h5>
                                <p><?php echo htmlspecialchars(substr($event['description'] ?? '', 0, 100)); ?><?php echo strlen($event['description'] ?? '') > 100 ? '...' : ''; ?></p>
                                <span class="badge bg-<?php
                                    echo match ($event['status']) {
                                        'planned' => 'secondary',
                                        'ongoing' => 'success',
                                        'completed' => 'info',
                                        'cancelled' => 'danger',
                                        default => 'secondary'
                                    };
                                    ?>" style="margin-top: 8px;">
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
                            </div>
                            <div class="result-actions">
                                <a href="<?php echo BASE_URL; ?>/events?action=show&id=<?php echo $event['id']; ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>

    <!-- Donations Results -->
    <?php if (!empty($results['donations'])): ?>
        <div class="chart-card" style="margin-bottom: 32px;">
            <div class="chart-header">
                <h3><i class="fas fa-donate"></i> Dons (<?php echo count($results['donations']); ?>)</h3>
            </div>
            <div class="chart-content">
                <div class="search-results-grid">
                    <?php foreach ($results['donations'] as $donation): ?>
                        <div class="search-result-card">
                            <div class="result-icon finance">
                                <i class="fas fa-gift"></i>
                            </div>
                            <div class="result-content">
                                <h5 class="trend-value positive"><?php echo number_format($donation['amount'], 2, ',', ' '); ?> €</h5>
                                <p><i class="fas fa-user"></i> <?php echo htmlspecialchars($donation['donor_name'] ?? 'Anonyme'); ?></p>
                                <p><i class="fas fa-calendar"></i> <?php echo date('d/m/Y', strtotime($donation['donation_date'] ?? $donation['created_at'])); ?></p>
                            </div>
                            <div class="result-actions">
                                <a href="<?php echo BASE_URL; ?>/donations?action=show&id=<?php echo $donation['id']; ?>" class="btn btn-sm btn-primary">
                                    <i class="fas fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>
    <?php endif; ?>
<?php endif; ?>
        text-align: center;
    }

    .search-section {
        margin-bottom: 3rem;
    }

    .search-section-title {
        color: #333;
        margin-bottom: 1.5rem;
        padding-bottom: 0.5rem;
        border-bottom: 2px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 0.5rem;
    }

    .search-results-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(350px, 1fr));
        gap: 1.5rem;
    }

    .search-result-card {
        background: white;
        border-radius: 12px;
        padding: 1.5rem;
        box-shadow: 0 4px 6px rgba(0, 0, 0, 0.07);
        border: 1px solid #e9ecef;
        display: flex;
        align-items: center;
        gap: 1rem;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
    }

    .search-result-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 25px rgba(0, 0, 0, 0.15);
    }

    .result-icon {
        width: 50px;
        height: 50px;
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        color: white;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .result-content {
        flex: 1;
    }

    .result-content h5 {
        margin: 0 0 0.5rem 0;
        color: #333;
        font-size: 1.1rem;
    }

    .result-content p {
        margin: 0;
        color: #666;
        font-size: 0.9rem;
    }

    .result-actions {
        flex-shrink: 0;
    }

    .no-results {
        text-align: center;
        padding: 4rem 2rem;
        color: #666;
    }

    .no-results-icon {
        font-size: 4rem;
        margin-bottom: 1rem;
        opacity: 0.5;
    }

    .no-results h3 {
        margin-bottom: 1rem;
        color: #333;
    }

    @media (max-width: 768px) {
        .search-results-container {
            padding: 1rem;
        }

        .search-results-grid {
            grid-template-columns: 1fr;
        }

        .search-result-card {
            flex-direction: column;
            text-align: center;
            gap: 0.5rem;
        }

        .result-actions {
            width: 100%;
        }
    }
</style>

<?php
require_once 'views/footer.php';
?>