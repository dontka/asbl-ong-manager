<?php $pageTitle = 'Détails de l\'Événement'; ?>

<div class="event-header">
    <div class="event-header-gradient"></div>
    <div class="event-header-content">
        <div class="event-icon">
            <i class="fas fa-calendar-check"></i>
        </div>
        <div class="event-info">
            <h1 class="event-title"><?php echo htmlspecialchars($event['title']); ?></h1>
            <div class="event-meta">
                <span class="event-date">
                    <i class="fas fa-calendar-alt"></i>
                    <?php echo date('d/m/Y \à H:i', strtotime($event['event_date'])); ?>
                </span>
                <?php if (!empty($event['location'])): ?>
                    <span class="event-location">
                        <i class="fas fa-map-marker-alt"></i>
                        <?php echo htmlspecialchars($event['location']); ?>
                    </span>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <a href="<?php echo BASE_URL; ?>/events" class="header-btn-back">
        <i class="fas fa-arrow-left"></i>
    </a>
</div>

<div class="event-container">
    <div class="event-wrapper">
        <!-- Main Content -->
        <div class="event-main">
            <!-- Event Details Card -->
            <div class="event-card">
                <div class="card-header">
                    <h2><i class="fas fa-info-circle"></i> Informations de l'événement</h2>
                </div>
                <div class="card-content">
                    <div class="info-grid">
                        <div class="info-item">
                            <span class="info-label">ID Événement</span>
                            <span class="info-value">#<?php echo $event['id']; ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Organisateur</span>
                            <span class="info-value"><?php echo htmlspecialchars($event['organizer_name'] ?? 'Non assigné'); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Capacité maximale</span>
                            <span class="info-value"><?php echo $event['max_participants'] ?? '∞ (Illimité)'; ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Statut</span>
                            <span class="info-value">
                                <span class="status-badge status-<?php echo $event['status']; ?>">
                                    <?php
                                    echo match ($event['status']) {
                                        'planned' => '📅 Planifié',
                                        'ongoing' => '▶️ En cours',
                                        'completed' => '✅ Terminé',
                                        'cancelled' => '❌ Annulé',
                                        default => ucfirst($event['status'])
                                    };
                                    ?>
                                </span>
                            </span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Créé le</span>
                            <span class="info-value"><?php echo date('d/m/Y H:i', strtotime($event['created_at'])); ?></span>
                        </div>
                        <div class="info-item">
                            <span class="info-label">Dernière modification</span>
                            <span class="info-value"><?php echo date('d/m/Y H:i', strtotime($event['updated_at'] ?? $event['created_at'])); ?></span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Card -->
            <?php if (!empty($event['description'])): ?>
                <div class="event-card">
                    <div class="card-header">
                        <h2><i class="fas fa-align-left"></i> Description</h2>
                    </div>
                    <div class="card-content description-content">
                        <?php echo nl2br(htmlspecialchars($event['description'])); ?>
                    </div>
                </div>
            <?php endif; ?>

            <!-- Attendance Metrics Card -->
            <div class="event-card">
                <div class="card-header">
                    <h2><i class="fas fa-users"></i> Participation</h2>
                </div>
                <div class="card-content">
                    <?php
                    $registered = $event['registered_count'] ?? 0;
                    $capacity = $event['max_participants'] ?? PHP_INT_MAX;
                    $percentage = $capacity > 0 && $capacity !== PHP_INT_MAX ? min(100, round(($registered / $capacity) * 100)) : 0;
                    ?>
                    <div class="attendance-metric">
                        <div class="metric-label">
                            <span>Personnes inscrites</span>
                            <span class="metric-value"><?php echo $registered; ?> / <?php echo $capacity === PHP_INT_MAX ? '∞' : $capacity; ?></span>
                        </div>
                        <?php if ($capacity !== PHP_INT_MAX): ?>
                            <div class="progress-bar">
                                <div class="progress-fill" style="width: <?php echo $percentage; ?>%"></div>
                            </div>
                            <div class="progress-text">
                                <?php echo round($percentage, 1); ?>% de capacité utilisée
                            </div>
                        <?php else: ?>
                            <div class="progress-text text-muted">Capacité illimitée</div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sidebar -->
        <aside class="event-sidebar">
            <!-- Quick Actions -->
            <div class="sidebar-card">
                <div class="card-header">
                    <h3><i class="fas fa-bolt"></i> Actions</h3>
                </div>
                <div class="card-content">
                    <div class="action-buttons">
                        <a href="<?php echo BASE_URL; ?>/events?action=edit&id=<?php echo $event['id']; ?>" class="action-btn primary">
                            <i class="fas fa-edit"></i>
                            <span>Modifier</span>
                        </a>
                        <a href="<?php echo BASE_URL; ?>/events?action=delete&id=<?php echo $event['id']; ?>" class="action-btn danger" data-confirm="Êtes-vous sûr de vouloir supprimer cet événement ?">
                            <i class="fas fa-trash-alt"></i>
                            <span>Supprimer</span>
                        </a>
                    </div>
                </div>
            </div>

            <!-- Event Summary -->
            <div class="sidebar-card">
                <div class="card-header">
                    <h3><i class="fas fa-calendar"></i> Résumé</h3>
                </div>
                <div class="card-content">
                    <div class="summary-item">
                        <span class="summary-label">Type d'événement</span>
                        <span class="summary-value">Événement planifié</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Durée</span>
                        <span class="summary-value">À définir</span>
                    </div>
                    <div class="summary-item">
                        <span class="summary-label">Public</span>
                        <span class="summary-value">Tous les membres</span>
                    </div>
                </div>
            </div>

            <!-- Status Information -->
            <div class="sidebar-card status-card">
                <div class="card-header">
                    <h3><i class="fas fa-circle"></i> État</h3>
                </div>
                <div class="card-content">
                    <div class="status-info">
                        <?php
                        $statusEmoji = match ($event['status']) {
                            'planned' => '📅',
                            'ongoing' => '▶️',
                            'completed' => '✅',
                            'cancelled' => '❌',
                            default => '❓'
                        };
                        $statusLabel = match ($event['status']) {
                            'planned' => 'Planifié',
                            'ongoing' => 'En cours',
                            'completed' => 'Terminé',
                            'cancelled' => 'Annulé',
                            default => ucfirst($event['status'])
                        };
                        ?>
                        <div class="status-display">
                            <span class="status-emoji"><?php echo $statusEmoji; ?></span>
                            <div>
                                <div class="status-text"><?php echo $statusLabel; ?></div>
                                <div class="status-description">
                                    <?php
                                    echo match ($event['status']) {
                                        'planned' => 'Événement prévu ultérieurement',
                                        'ongoing' => 'Événement en cours de déroulement',
                                        'completed' => 'Événement terminé avec succès',
                                        'cancelled' => 'Événement annulé ou reporté',
                                        default => ''
                                    };
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </aside>
    </div>
</div>

<style>
    .event-header {
        position: relative;
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        border-radius: var(--border-radius-lg);
        padding: var(--spacing-3xl) var(--spacing-lg) var(--spacing-lg);
        margin-bottom: var(--spacing-lg);
        box-shadow: var(--shadow-md);
        color: var(--white);
        display: flex;
        justify-content: space-between;
        align-items: flex-start;
        gap: var(--spacing-lg);
        overflow: hidden;
    }

    .event-header-gradient {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: radial-gradient(circle at top right, rgba(255, 255, 255, 0.1), transparent);
        pointer-events: none;
    }

    .event-header-content {
        display: flex;
        align-items: center;
        gap: var(--spacing-lg);
        flex: 1;
        position: relative;
        z-index: 1;
    }

    .event-icon {
        width: 100px;
        height: 100px;
        background: rgba(255, 255, 255, 0.2);
        border-radius: var(--border-radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 2.5rem;
        flex-shrink: 0;
    }

    .event-info {
        flex: 1;
    }

    .event-title {
        font-size: var(--font-size-4xl);
        font-weight: 700;
        margin: 0 0 var(--spacing-sm) 0;
        word-break: break-word;
    }

    .event-meta {
        display: flex;
        gap: var(--spacing-md);
        flex-wrap: wrap;
        font-size: var(--font-size-sm);
        opacity: 0.95;
    }

    .event-date,
    .event-location {
        display: flex;
        align-items: center;
        gap: var(--spacing-xs);
    }

    .header-btn-back {
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.3);
        color: var(--white);
        width: 48px;
        height: 48px;
        border-radius: var(--border-radius);
        display: flex;
        align-items: center;
        justify-content: center;
        text-decoration: none;
        transition: var(--transition);
        position: relative;
        z-index: 2;
        flex-shrink: 0;
    }

    .header-btn-back:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.5);
    }

    .event-container {
        margin-bottom: var(--spacing-lg);
    }

    .event-wrapper {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: var(--spacing-lg);
    }

    .event-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
        margin-bottom: var(--spacing-lg);
    }

    .card-header {
        padding: var(--spacing-lg);
        background: linear-gradient(135deg, var(--gray-50), var(--white));
        border-bottom: 1px solid var(--gray-200);
    }

    .card-header h2,
    .card-header h3 {
        margin: 0;
        font-size: var(--font-size-xl);
        font-weight: 700;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
    }

    .card-header h3 {
        font-size: var(--font-size-lg);
    }

    .card-header i {
        color: var(--primary);
    }

    .card-content {
        padding: var(--spacing-lg);
    }

    .info-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: var(--spacing-lg);
    }

    .info-item {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-xs);
    }

    .info-label {
        font-size: var(--font-size-xs);
        font-weight: 600;
        color: var(--gray-500);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .info-value {
        font-size: var(--font-size-md);
        font-weight: 600;
        color: var(--gray-900);
    }

    .status-badge {
        display: inline-block;
        padding: var(--spacing-xs) var(--spacing-sm);
        border-radius: var(--border-radius-full);
        font-weight: 600;
        font-size: var(--font-size-sm);
        white-space: nowrap;
    }

    .status-badge.status-planned {
        background: #f0f4f8;
        color: #64748b;
    }

    .status-badge.status-ongoing {
        background: rgba(0, 212, 170, 0.1);
        color: #00D4AA;
    }

    .status-badge.status-completed {
        background: rgba(76, 175, 80, 0.1);
        color: #4CAF50;
    }

    .status-badge.status-cancelled {
        background: rgba(255, 71, 87, 0.1);
        color: #FF4757;
    }

    .description-content {
        line-height: 1.8;
        color: var(--gray-700);
        white-space: pre-wrap;
        word-break: break-word;
    }

    .attendance-metric {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-md);
    }

    .metric-label {
        display: flex;
        justify-content: space-between;
        align-items: center;
        font-weight: 600;
        color: var(--gray-900);
    }

    .metric-value {
        font-size: var(--font-size-xl);
        color: var(--primary);
        font-weight: 700;
    }

    .progress-bar {
        height: 12px;
        background: var(--gray-200);
        border-radius: var(--border-radius-full);
        overflow: hidden;
    }

    .progress-fill {
        height: 100%;
        background: linear-gradient(90deg, var(--primary), var(--secondary));
        border-radius: var(--border-radius-full);
        transition: width 0.3s ease;
    }

    .progress-text {
        font-size: var(--font-size-xs);
        color: var(--gray-600);
        text-align: right;
    }

    .progress-text.text-muted {
        color: var(--gray-500);
    }

    .event-sidebar {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-lg);
    }

    .sidebar-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .action-buttons {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-sm);
    }

    .action-btn {
        padding: var(--spacing-md) var(--spacing-lg);
        border-radius: var(--border-radius);
        border: none;
        font-weight: 600;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: var(--spacing-sm);
        text-decoration: none;
        transition: var(--transition);
        font-size: var(--font-size-sm);
    }

    .action-btn.primary {
        background: linear-gradient(135deg, var(--primary), #6A4FD4);
        color: var(--white);
    }

    .action-btn.primary:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(123, 97, 255, 0.2);
    }

    .action-btn.danger {
        background: linear-gradient(135deg, #FF6B6B, #FF4757);
        color: var(--white);
    }

    .action-btn.danger:hover {
        transform: translateY(-2px);
        box-shadow: 0 8px 16px rgba(255, 71, 87, 0.2);
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

    .summary-value {
        color: var(--primary);
        font-weight: 500;
        font-size: var(--font-size-sm);
    }

    .status-info {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-md);
    }

    .status-display {
        display: flex;
        gap: var(--spacing-md);
        align-items: flex-start;
    }

    .status-emoji {
        font-size: 2rem;
        flex-shrink: 0;
    }

    .status-text {
        font-weight: 700;
        color: var(--gray-900);
        font-size: var(--font-size-md);
    }

    .status-description {
        font-size: var(--font-size-xs);
        color: var(--gray-600);
        margin-top: var(--spacing-xs);
    }

    @media (max-width: 768px) {
        .event-wrapper {
            grid-template-columns: 1fr;
        }

        .info-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .event-header {
            flex-direction: column;
            padding: var(--spacing-xl) var(--spacing-lg);
        }

        .header-btn-back {
            align-self: flex-start;
        }

        .event-icon {
            width: 80px;
            height: 80px;
            font-size: 2rem;
        }

        .event-title {
            font-size: var(--font-size-2xl);
        }
    }

    @media (max-width: 480px) {
        .event-header {
            padding: var(--spacing-lg);
        }

        .event-icon {
            width: 60px;
            height: 60px;
            font-size: 1.5rem;
        }

        .event-title {
            font-size: var(--font-size-xl);
        }

        .event-meta {
            flex-direction: column;
            gap: var(--spacing-xs);
        }

        .info-grid {
            grid-template-columns: 1fr;
        }
    }
</style>
