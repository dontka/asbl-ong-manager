<?php $pageTitle = 'Gestion des Événements'; ?>

<div class="list-page-header">
    <div class="header-wrapper">
        <div class="header-content">
            <div class="header-icon">
                <i class="fas fa-calendar"></i>
            </div>
            <div>
                <h1 class="page-title">Événements</h1>
                <p class="page-subtitle">Planification et suivi de vos événements</p>
            </div>
        </div>
        <a href="<?php echo BASE_URL; ?>/events?action=create" class="btn btn-primary btn-lg">
            <i class="fas fa-plus-circle"></i>
            <span>Ajouter un événement</span>
        </a>
    </div>
</div>

<!-- KPI Stats Grid -->
<div class="stats-grid">
    <div class="stat-card card-primary">
        <div class="stat-icon">
            <i class="fas fa-calendar-plus"></i>
        </div>
        <div class="stat-content">
            <div class="stat-value"><?php echo count(array_filter($events, fn($e) => $e['status'] === 'planned')); ?></div>
            <div class="stat-label">Planifiés</div>
        </div>
    </div>

    <div class="stat-card card-secondary">
        <div class="stat-icon">
            <i class="fas fa-play-circle"></i>
        </div>
        <div class="stat-content">
            <div class="stat-value"><?php echo count(array_filter($events, fn($e) => $e['status'] === 'ongoing')); ?></div>
            <div class="stat-label">En cours</div>
        </div>
    </div>

    <div class="stat-card card-success">
        <div class="stat-icon">
            <i class="fas fa-check-circle"></i>
        </div>
        <div class="stat-content">
            <div class="stat-value"><?php echo count(array_filter($events, fn($e) => $e['status'] === 'completed')); ?></div>
            <div class="stat-label">Terminés</div>
        </div>
    </div>

    <div class="stat-card card-info">
        <div class="stat-icon">
            <i class="fas fa-calendar"></i>
        </div>
        <div class="stat-content">
            <div class="stat-value"><?php echo count($events); ?></div>
            <div class="stat-label">Total</div>
        </div>
    </div>
</div>

<!-- Controls Section -->
<div class="controls-section">
    <div class="controls-wrapper">
        <!-- Search and Filters -->
        <div class="controls-left">
            <div class="search-bar">
                <i class="fas fa-search"></i>
                <input type="text" id="searchInput" class="search-input" placeholder="Rechercher un événement..." data-target="eventsTable">
                <button id="clearSearch" class="search-clear">
                    <i class="fas fa-times-circle"></i>
                </button>
            </div>
        </div>

        <!-- Filter Buttons -->
        <div class="filter-buttons">
            <button class="filter-btn active" data-filter="">
                Tous <span class="filter-count"><?php echo count($events); ?></span>
            </button>
            <button class="filter-btn" data-filter="planned">
                Planifiés <span class="filter-count"><?php echo count(array_filter($events, fn($e) => $e['status'] === 'planned')); ?></span>
            </button>
            <button class="filter-btn" data-filter="ongoing">
                En cours <span class="filter-count"><?php echo count(array_filter($events, fn($e) => $e['status'] === 'ongoing')); ?></span>
            </button>
            <button class="filter-btn" data-filter="completed">
                Terminés <span class="filter-count"><?php echo count(array_filter($events, fn($e) => $e['status'] === 'completed')); ?></span>
            </button>
        </div>
    </div>
</div>

<!-- Table Section -->
<div class="table-card">
    <div class="card-header">
        <h2><i class="fas fa-list"></i> Tous les événements</h2>
        <div class="card-actions">
            <button class="action-icon" title="Rafraîchir">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>

    <div class="card-content">
        <?php if (!empty($events)): ?>
            <div class="table-responsive">
                <table class="events-table" id="eventsTable">
                    <thead>
                        <tr>
                            <th class="col-title">
                                <span>Titre</span>
                                <i class="fas fa-arrow-down"></i>
                            </th>
                            <th class="col-date">
                                <span>Date & Heure</span>
                                <i class="fas fa-arrow-down"></i>
                            </th>
                            <th class="col-location">Lieu</th>
                            <th class="col-organizer">Organisateur</th>
                            <th class="col-capacity">Participants</th>
                            <th class="col-status">Statut</th>
                            <th class="col-actions">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($events as $event): ?>
                            <tr class="table-row" data-status="<?php echo $event['status']; ?>">
                                <td class="col-title">
                                    <div class="table-cell-content">
                                        <div class="event-icon-small">
                                            <i class="fas fa-calendar-alt"></i>
                                        </div>
                                        <div>
                                            <div class="text-strong"><?php echo htmlspecialchars(substr($event['title'], 0, 50)); ?></div>
                                            <div class="text-muted"><?php echo htmlspecialchars(substr($event['description'] ?? '', 0, 50)); ?></div>
                                        </div>
                                    </div>
                                </td>
                                <td class="col-date">
                                    <span class="date-badge"><?php echo date('d/m/Y', strtotime($event['event_date'])); ?></span>
                                    <span class="time-badge"><?php echo date('H:i', strtotime($event['event_date'])); ?></span>
                                </td>
                                <td class="col-location">
                                    <span class="location-icon">
                                        <i class="fas fa-map-marker-alt"></i>
                                        <?php echo htmlspecialchars($event['location'] ?? 'En ligne'); ?>
                                    </span>
                                </td>
                                <td class="col-organizer">
                                    <?php echo htmlspecialchars($event['organizer_name'] ?? 'Non assigné'); ?>
                                </td>
                                <td class="col-capacity">
                                    <span class="capacity-badge">
                                        <i class="fas fa-users"></i>
                                        <?php if ($event['max_participants']): ?>
                                            <?php echo 'env. ' . ($event['registered_count'] ?? 0) . ' / ' . $event['max_participants']; ?>
                                        <?php else: ?>
                                            Illimité
                                        <?php endif; ?>
                                    </span>
                                </td>
                                <td class="col-status">
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
                                </td>
                                <td class="col-actions">
                                    <div class="action-group">
                                        <a href="<?php echo BASE_URL; ?>/events?action=show&id=<?php echo $event['id']; ?>" class="action-btn view-btn" title="Voir" tabindex="0">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>/events?action=edit&id=<?php echo $event['id']; ?>" class="action-btn edit-btn" title="Modifier" tabindex="0">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?php echo BASE_URL; ?>/events?action=delete&id=<?php echo $event['id']; ?>" class="action-btn delete-btn" title="Supprimer" data-confirm="Êtes-vous sûr?" tabindex="0">
                                            <i class="fas fa-trash-alt"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state">
                <div class="empty-icon">
                    <i class="fas fa-calendar-times"></i>
                </div>
                <h3>Aucun événement trouvé</h3>
                <p>Créez votre premier événement pour commencer</p>
                <a href="<?php echo BASE_URL; ?>/events?action=create" class="btn btn-primary">
                    <i class="fas fa-plus-circle"></i>
                    <span>Créer un événement</span>
                </a>
            </div>
        <?php endif; ?>
    </div>
</div>

<style>
    .list-page-header {
        background: linear-gradient(135deg, var(--white), var(--gray-50));
        border-bottom: 1px solid var(--gray-200);
        padding: var(--spacing-lg);
        margin-bottom: var(--spacing-lg);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm);
    }

    .header-wrapper {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: var(--spacing-lg);
        flex-wrap: wrap;
    }

    .header-content {
        display: flex;
        align-items: center;
        gap: var(--spacing-lg);
        flex: 1;
        min-width: 250px;
    }

    .header-icon {
        font-size: 2.5rem;
        color: var(--primary);
        width: 70px;
        height: 70px;
        background: rgba(123, 97, 255, 0.1);
        border-radius: var(--border-radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        flex-shrink: 0;
    }

    .page-title {
        font-size: var(--font-size-3xl);
        font-weight: 700;
        color: var(--gray-900);
        margin: 0 0 var(--spacing-xs) 0;
    }

    .page-subtitle {
        font-size: var(--font-size-sm);
        color: var(--gray-600);
        margin: 0;
    }

    .btn-lg {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-sm);
        padding: var(--spacing-md) var(--spacing-lg);
        white-space: nowrap;
    }

    .stats-grid {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: var(--spacing-lg);
        margin-bottom: var(--spacing-lg);
    }

    .stat-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--border-radius-lg);
        padding: var(--spacing-lg);
        display: flex;
        align-items: center;
        gap: var(--spacing-lg);
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }

    .stat-card:hover {
        transform: translateY(-4px);
        box-shadow: var(--shadow-md);
    }

    .stat-card.card-primary .stat-icon {
        background: linear-gradient(135deg, var(--primary), #6A4FD4);
        color: var(--white);
    }

    .stat-card.card-secondary .stat-icon {
        background: linear-gradient(135deg, var(--secondary), #00B5B9);
        color: var(--white);
    }

    .stat-card.card-success .stat-icon {
        background: linear-gradient(135deg, var(--success), #00C4AA);
        color: var(--white);
    }

    .stat-card.card-info .stat-icon {
        background: linear-gradient(135deg, #5B9BF5, #3B82F6);
        color: var(--white);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: var(--border-radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.75rem;
        flex-shrink: 0;
    }

    .stat-content {
        flex: 1;
    }

    .stat-value {
        font-size: var(--font-size-3xl);
        font-weight: 700;
        color: var(--gray-900);
        line-height: 1;
        margin-bottom: var(--spacing-xs);
    }

    .stat-label {
        font-size: var(--font-size-sm);
        color: var(--gray-600);
        font-weight: 500;
    }

    .controls-section {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--border-radius-lg);
        padding: var(--spacing-lg);
        margin-bottom: var(--spacing-lg);
        box-shadow: var(--shadow-sm);
    }

    .controls-wrapper {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-lg);
    }

    .controls-left {
        flex: 1;
    }

    .search-bar {
        position: relative;
        display: flex;
        align-items: center;
    }

    .search-bar i:first-child {
        position: absolute;
        left: var(--spacing-md);
        color: var(--gray-400);
        pointer-events: none;
    }

    .search-input {
        width: 100%;
        padding: var(--spacing-sm) var(--spacing-md) var(--spacing-sm) 2.5rem;
        border: 1px solid var(--gray-300);
        border-radius: var(--border-radius);
        font-size: var(--font-size-sm);
        transition: var(--transition);
    }

    .search-input:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(123, 97, 255, 0.1);
    }

    .search-clear {
        position: absolute;
        right: var(--spacing-md);
        background: none;
        border: none;
        color: var(--gray-400);
        cursor: pointer;
        display: none;
        transition: var(--transition);
    }

    .search-clear:hover {
        color: var(--gray-600);
    }

    .search-input:not(:placeholder-shown) ~ .search-clear {
        display: block;
    }

    .filter-buttons {
        display: flex;
        gap: var(--spacing-sm);
        flex-wrap: wrap;
    }

    .filter-btn {
        padding: var(--spacing-sm) var(--spacing-md);
        background: var(--gray-100);
        border: 1px solid var(--gray-300);
        border-radius: var(--border-radius-full);
        font-size: var(--font-size-sm);
        font-weight: 500;
        color: var(--gray-700);
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: var(--spacing-xs);
    }

    .filter-btn:hover {
        border-color: var(--primary);
        background: rgba(123, 97, 255, 0.05);
    }

    .filter-btn.active {
        background: var(--primary);
        border-color: var(--primary);
        color: var(--white);
    }

    .filter-count {
        background: rgba(0, 0, 0, 0.1);
        padding: 0 var(--spacing-xs);
        border-radius: var(--border-radius-full);
        font-size: var(--font-size-xs);
        font-weight: 700;
    }

    .table-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .card-header {
        padding: var(--spacing-lg);
        background: linear-gradient(135deg, var(--gray-50), var(--white));
        border-bottom: 1px solid var(--gray-200);
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    .card-header h2 {
        margin: 0;
        font-size: var(--font-size-xl);
        font-weight: 700;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
    }

    .card-header i {
        color: var(--primary);
    }

    .card-actions {
        display: flex;
        gap: var(--spacing-sm);
    }

    .action-icon {
        width: 40px;
        height: 40px;
        border: 1px solid var(--gray-300);
        background: var(--white);
        border-radius: var(--border-radius);
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--gray-600);
        transition: var(--transition);
    }

    .action-icon:hover {
        background: var(--gray-50);
        color: var(--primary);
    }

    .card-content {
        padding: var(--spacing-lg);
    }

    .table-responsive {
        overflow-x: auto;
    }

    .events-table {
        width: 100%;
        border-collapse: collapse;
    }

    .events-table thead {
        background: var(--gray-50);
    }

    .events-table th {
        padding: var(--spacing-md) var(--spacing-lg);
        text-align: left;
        font-weight: 700;
        color: var(--gray-900);
        font-size: var(--font-size-sm);
        border-bottom: 1px solid var(--gray-200);
        white-space: nowrap;
        user-select: none;
        display: flex;
        align-items: center;
        gap: var(--spacing-xs);
    }

    .events-table th i {
        opacity: 0;
        font-size: 0.75rem;
        transition: var(--transition);
    }

    .events-table th:hover i {
        opacity: 1;
        color: var(--primary);
    }

    .events-table tbody tr {
        border-bottom: 1px solid var(--gray-200);
        transition: var(--transition);
    }

    .events-table tbody tr:hover {
        background: var(--gray-50);
    }

    .events-table td {
        padding: var(--spacing-md) var(--spacing-lg);
        font-size: var(--font-size-sm);
        color: var(--gray-700);
    }

    .table-cell-content {
        display: flex;
        align-items: center;
        gap: var(--spacing-md);
    }

    .event-icon-small {
        width: 40px;
        height: 40px;
        background: rgba(123, 97, 255, 0.1);
        border-radius: var(--border-radius);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--primary);
        flex-shrink: 0;
    }

    .text-strong {
        font-weight: 600;
        color: var(--gray-900);
        margin-bottom: 0.25rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .text-muted {
        font-size: var(--font-size-xs);
        color: var(--gray-500);
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .date-badge {
        display: block;
        font-weight: 600;
        color: var(--primary);
    }

    .time-badge {
        font-size: var(--font-size-xs);
        color: var(--gray-600);
    }

    .location-icon {
        display: flex;
        align-items: center;
        gap: var(--spacing-xs);
        color: var(--gray-700);
    }

    .location-icon i {
        color: var(--gray-400);
    }

    .capacity-badge {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-xs);
        padding: var(--spacing-xs) var(--spacing-sm);
        background: var(--gray-100);
        border-radius: var(--border-radius);
        color: var(--gray-700);
        font-weight: 500;
    }

    .capacity-badge i {
        color: var(--gray-400);
    }

    .status-badge {
        display: inline-block;
        padding: var(--spacing-xs) var(--spacing-sm);
        border-radius: var(--border-radius);
        font-weight: 600;
        font-size: var(--font-size-xs);
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

    .action-group {
        display: flex;
        gap: var(--spacing-sm);
        justify-content: center;
    }

    .action-btn {
        width: 36px;
        height: 36px;
        border-radius: var(--border-radius);
        border: 1px solid var(--gray-300);
        background: var(--white);
        color: var(--gray-600);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: var(--transition);
        text-decoration: none;
        font-size: var(--font-size-sm);
    }

    .action-btn:hover {
        text-decoration: none;
    }

    .action-btn.view-btn {
        border-color: #5B9BF5;
        color: #5B9BF5;
    }

    .action-btn.view-btn:hover {
        background: rgba(91, 155, 245, 0.1);
    }

    .action-btn.edit-btn {
        border-color: #FFB800;
        color: #FFB800;
    }

    .action-btn.edit-btn:hover {
        background: rgba(255, 184, 0, 0.1);
    }

    .action-btn.delete-btn {
        border-color: #FF4757;
        color: #FF4757;
    }

    .action-btn.delete-btn:hover {
        background: rgba(255, 71, 87, 0.1);
    }

    .empty-state {
        text-align: center;
        padding: var(--spacing-4xl) var(--spacing-lg);
    }

    .empty-icon {
        font-size: 4rem;
        color: var(--gray-300);
        margin-bottom: var(--spacing-lg);
    }

    .empty-state h3 {
        margin: 0 0 var(--spacing-sm) 0;
        font-size: var(--font-size-2xl);
        color: var(--gray-900);
    }

    .empty-state p {
        margin: 0 0 var(--spacing-lg) 0;
        color: var(--gray-600);
    }

    @media (max-width: 1024px) {
        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
        }

        .events-table th,
        .events-table td {
            padding: var(--spacing-md);
        }
    }

    @media (max-width: 768px) {
        .header-wrapper {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-lg {
            width: 100%;
            justify-content: center;
        }

        .stats-grid {
            grid-template-columns: repeat(2, 1fr);
            gap: var(--spacing-md);
        }

        .stat-card {
            flex-direction: column;
            text-align: center;
        }

        .controls-left {
            width: 100%;
        }

        .filter-buttons {
            justify-content: flex-start;
        }

        .col-organizer,
        .col-capacity {
            display: none;
        }
    }

    @media (max-width: 480px) {
        .page-title {
            font-size: var(--font-size-2xl);
        }

        .stats-grid {
            grid-template-columns: 1fr;
        }

        .table-responsive {
            overflow-x: auto;
        }

        .events-table th,
        .events-table td {
            padding: var(--spacing-sm);
            font-size: var(--font-size-xs);
        }

        .text-strong {
            font-size: var(--font-size-xs);
        }

        .col-date,
        .col-location,
        .col-organizer,
        .col-capacity,
        .col-status {
            display: none;
        }

        .action-btn {
            width: 32px;
            height: 32px;
            font-size: var(--font-size-xs);
        }
    }
</style>

<script>
    // Search functionality
    const searchInput = document.getElementById('searchInput');
    const clearSearch = document.getElementById('clearSearch');
    const table = document.getElementById('eventsTable');

    searchInput?.addEventListener('input', function() {
        const searchTerm = this.value.toLowerCase();
        const rows = table?.querySelectorAll('tbody tr') || [];
        
        rows.forEach(row => {
            const text = row.textContent.toLowerCase();
            row.style.display = text.includes(searchTerm) ? '' : 'none';
        });
    });

    clearSearch?.addEventListener('click', function() {
        searchInput.value = '';
        searchInput.dispatchEvent(new Event('input'));
        searchInput.focus();
    });

    // Filter buttons
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');
            
            const filter = this.dataset.filter;
            const rows = table?.querySelectorAll('tbody tr') || [];
            
            rows.forEach(row => {
                const status = row.dataset.status;
                row.style.display = filter === '' || status === filter ? '' : 'none';
            });
        });
    });

    // Delete confirmation
    document.querySelectorAll('[data-confirm]').forEach(btn => {
        btn.addEventListener('click', function(e) {
            if (!confirm(this.dataset.confirm)) {
                e.preventDefault();
            }
        });
    });
</script>
