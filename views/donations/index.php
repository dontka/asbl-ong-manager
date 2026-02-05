<?php $pageTitle = 'Gestion des Dons'; ?>

<div class="donations-page-header">
    <div class="header-wrapper">
        <div class="header-content">
            <div class="header-icon">
                <i class="fas fa-hand-holding-heart"></i>
            </div>
            <div>
                <h1 class="form-page-title">Gestion des Dons</h1>
                <p class="form-page-subtitle">Consultez et gérez toutes les donations reçues</p>
            </div>
        </div>
        <a href="<?php echo BASE_URL; ?>/donations/create" class="btn btn-primary btn-icon">
            <i class="fas fa-plus"></i>
            <span>Ajouter un don</span>
        </a>
    </div>
</div>

<div class="donations-stats-section">
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon primary">
                <i class="fas fa-euro-sign"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?php echo number_format(array_sum(array_column($donations ?? [], 'amount')), 2, ',', ' '); ?> €</div>
                <div class="stat-label">Montant total</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon secondary">
                <i class="fas fa-gift"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?php echo count($donations ?? []); ?></div>
                <div class="stat-label">Donations</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon info">
                <i class="fas fa-chart-line"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?php echo !empty($donations) ? number_format(array_sum(array_column($donations, 'amount')) / count($donations), 2, ',', ' ') : '0'; ?> €</div>
                <div class="stat-label">Moyenne</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon warning">
                <i class="fas fa-users"></i>
            </div>
            <div class="stat-content">
                <div class="stat-value"><?php echo count(array_unique(array_column($donations ?? [], 'donor_name'))); ?></div>
                <div class="stat-label">Donateurs uniques</div>
            </div>
        </div>
    </div>
</div>

<div class="donations-table-section">
    <div class="table-header-bar">
        <div class="section-title">
            <h2>Liste des donations</h2>
            <span class="table-subtitle"><?php echo count($donations ?? []); ?> enregistrement(s)</span>
        </div>
    </div>

    <div class="table-controls-container">
        <div class="advanced-search">
            <input 
                type="text" 
                id="searchInput" 
                placeholder="Rechercher par donateur ou montant..." 
                class="search-input"
                onkeyup="filterAndSearchDonations()"
            >
            <i class="fas fa-search"></i>
            <button class="clear-search-btn" onclick="clearSearch()" style="display:none;" id="clearBtn">
                <i class="fas fa-times"></i>
            </button>
        </div>

        <div class="filter-buttons-group">
            <select id="projectFilter" class="filter-select" onchange="filterByProject()">
                <option value="">Tous les projets</option>
                <?php if (!empty($projects)): ?>
                    <?php foreach ($projects as $project): ?>
                        <option value="<?php echo $project['id']; ?>">
                            <?php echo htmlspecialchars($project['name']); ?>
                        </option>
                    <?php endforeach; ?>
                <?php endif; ?>
            </select>
        </div>

        <div class="action-icons">
            <button class="icon-btn" onclick="exportTableData()" title="Exporter en CSV">
                <i class="fas fa-download"></i>
            </button>
            <button class="icon-btn" onclick="refreshList()" title="Actualiser">
                <i class="fas fa-sync-alt"></i>
            </button>
        </div>
    </div>

    <?php if (!empty($donations)): ?>
    <div class="table-responsive">
        <table class="donations-data-table">
            <thead>
                <tr>
                    <th style="width: 40px;">
                        <input type="checkbox" id="selectAllCheckbox" onchange="toggleSelectAll()">
                    </th>
                    <th>Donateur</th>
                    <th>Email</th>
                    <th style="text-align: right;">Montant</th>
                    <th>Date</th>
                    <th>Projet</th>
                    <th>Méthode</th>
                    <th style="text-align: center; width: 120px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($donations as $index => $donation): ?>
                <tr class="donation-row" data-project="<?php echo $donation['project_id'] ?? ''; ?>" data-amount="<?php echo $donation['amount']; ?>" data-donor="<?php echo htmlspecialchars($donation['donor_name']); ?>">
                    <td>
                        <input type="checkbox" class="row-checkbox" value="<?php echo $donation['id']; ?>">
                    </td>
                    <td>
                        <strong><?php echo htmlspecialchars($donation['donor_name']); ?></strong>
                    </td>
                    <td>
                        <?php if (!empty($donation['donor_email'])): ?>
                            <a href="mailto:<?php echo htmlspecialchars($donation['donor_email']); ?>" style="color: var(--primary);">
                                <?php echo htmlspecialchars($donation['donor_email']); ?>
                            </a>
                        <?php else: ?>
                            <span class="text-muted">-</span>
                        <?php endif; ?>
                    </td>
                    <td style="text-align: right; font-weight: 600; color: var(--success);">
                        <?php echo number_format($donation['amount'], 2, ',', ' '); ?> €
                    </td>
                    <td><?php echo date('d/m/Y', strtotime($donation['donation_date'])); ?></td>
                    <td>
                        <?php if (!empty($donation['project_id'])): ?>
                            <span class="project-badge">
                                <?php 
                                $projName = '';
                                foreach (($projects ?? []) as $p) {
                                    if ($p['id'] == $donation['project_id']) {
                                        $projName = $p['name'];
                                        break;
                                    }
                                }
                                echo htmlspecialchars($projName ?: 'N/A');
                                ?>
                            </span>
                        <?php else: ?>
                            <span class="badge-secondary">Général</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="method-badge">
                            <?php 
                            $methods = ['cash' => 'Espèces', 'bank_transfer' => 'Virement', 'online' => 'En ligne'];
                            echo $methods[$donation['payment_method']] ?? $donation['payment_method'];
                            ?>
                        </span>
                    </td>
                    <td style="text-align: center;">
                        <div class="action-buttons">
                            <a href="<?php echo BASE_URL; ?>/donations/<?php echo $donation['id']; ?>" class="action-btn view-btn" title="Voir">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="<?php echo BASE_URL; ?>/donations/<?php echo $donation['id']; ?>/edit" class="action-btn edit-btn" title="Modifier">
                                <i class="fas fa-edit"></i>
                            </a>
                            <a href="<?php echo BASE_URL; ?>/donations/<?php echo $donation['id']; ?>/delete" class="action-btn delete-btn" title="Supprimer" onclick="return confirm('Confirmer la suppression?');">
                                <i class="fas fa-trash"></i>
                            </a>
                        </div>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="bulk-actions-bar" id="bulkActionsBar" style="display: none;">
        <div class="bulk-info">
            <span id="selectedCount">0</span> élément(s) sélectionné(s)
        </div>
        <div class="bulk-action-buttons">
            <button class="btn btn-danger btn-small" onclick="bulkDeleteDonations()">
                <i class="fas fa-trash"></i> Supprimer la sélection
            </button>
            <button class="btn btn-secondary btn-small" onclick="clearSelection()">
                <i class="fas fa-times"></i> Annuler
            </button>
        </div>
    </div>

    <?php else: ?>
    <div class="empty-state">
        <div class="empty-icon">
            <i class="fas fa-inbox"></i>
        </div>
        <h3>Aucune donation</h3>
        <p>Aucune donation n'a été enregistrée pour le moment.</p>
        <a href="<?php echo BASE_URL; ?>/donations/create" class="btn btn-primary">
            <i class="fas fa-plus"></i> Ajouter une donation
        </a>
    </div>
    <?php endif; ?>
</div>

<style>
    .donations-page-header {
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

    .form-page-title { font-size: var(--font-size-3xl); font-weight: 700; color: var(--gray-900); margin: 0 0 var(--spacing-xs) 0; }
    .form-page-subtitle { font-size: var(--font-size-sm); color: var(--gray-600); margin: 0; }

    .btn-icon {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-sm);
    }

    .donations-stats-section {
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
        align-items: center;
        gap: var(--spacing-md);
        box-shadow: var(--shadow-sm);
        transition: var(--transition);
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: var(--shadow-md);
    }

    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: var(--border-radius-lg);
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: var(--white);
        flex-shrink: 0;
    }

    .stat-icon.primary { background: linear-gradient(135deg, var(--primary), var(--primary-light)); }
    .stat-icon.secondary { background: linear-gradient(135deg, var(--secondary), #00B0B8); }
    .stat-icon.info { background: linear-gradient(135deg, #3498DB, #2980B9); }
    .stat-icon.warning { background: linear-gradient(135deg, var(--warning), #FFC107); }

    .stat-content {
        flex: 1;
    }

    .stat-value { font-size: var(--font-size-2xl); font-weight: 700; color: var(--gray-900); margin-bottom: var(--spacing-xs); }
    .stat-label { font-size: var(--font-size-sm); color: var(--gray-600); }

    .donations-table-section {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--border-radius-lg);
        padding: var(--spacing-lg);
        box-shadow: var(--shadow-sm);
    }

    .table-header-bar {
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: var(--spacing-lg);
        padding-bottom: var(--spacing-lg);
        border-bottom: 1px solid var(--gray-200);
    }

    .section-title {
        display: flex;
        align-items: baseline;
        gap: var(--spacing-md);
    }

    .section-title h2 { font-size: var(--font-size-2xl); font-weight: 700; color: var(--gray-900); margin: 0; }
    .table-subtitle { font-size: var(--font-size-sm); color: var(--gray-500); }

    .table-controls-container {
        display: flex;
        gap: var(--spacing-md);
        margin-bottom: var(--spacing-lg);
        flex-wrap: wrap;
        align-items: center;
    }

    .advanced-search {
        position: relative;
        flex: 1;
        min-width: 250px;
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

    .advanced-search i {
        position: absolute;
        left: var(--spacing-md);
        top: 50%;
        transform: translateY(-50%);
        color: var(--gray-400);
        pointer-events: none;
    }

    .filter-buttons-group {
        display: flex;
        gap: var(--spacing-sm);
        flex-wrap: wrap;
    }

    .filter-select {
        padding: var(--spacing-sm) var(--spacing-md);
        border: 1px solid var(--gray-300);
        border-radius: var(--border-radius);
        font-size: var(--font-size-sm);
        background: var(--white);
        cursor: pointer;
        transition: var(--transition);
    }

    .filter-select:hover { border-color: var(--primary); }

    .action-icons {
        display: flex;
        gap: var(--spacing-sm);
    }

    .icon-btn {
        width: 40px;
        height: 40px;
        border: 1px solid var(--gray-300);
        background: var(--white);
        border-radius: var(--border-radius);
        color: var(--gray-600);
        cursor: pointer;
        transition: var(--transition);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .icon-btn:hover {
        background: var(--primary);
        border-color: var(--primary);
        color: var(--white);
    }

    .table-responsive {
        overflow-x: auto;
        margin-bottom: var(--spacing-lg);
    }

    .donations-data-table {
        width: 100%;
        border-collapse: collapse;
        font-size: var(--font-size-sm);
    }

    .donations-data-table thead {
        background: var(--gray-50);
        border-bottom: 2px solid var(--gray-200);
    }

    .donations-data-table th {
        padding: var(--spacing-md);
        font-weight: 600;
        color: var(--gray-700);
        text-align: left;
    }

    .donations-data-table td {
        padding: var(--spacing-md);
        border-bottom: 1px solid var(--gray-200);
        vertical-align: middle;
    }

    .donation-row:hover {
        background: var(--gray-50);
    }

    .action-buttons {
        display: flex;
        gap: var(--spacing-xs);
        justify-content: center;
    }

    .action-btn {
        width: 32px;
        height: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        border-radius: var(--border-radius);
        color: var(--white);
        text-decoration: none;
        transition: var(--transition);
        font-size: var(--font-size-sm);
    }

    .view-btn { background: var(--secondary); }
    .view-btn:hover { background: #00B0B8; }
    .edit-btn { background: #FFD700; color: var(--gray-900); }
    .edit-btn:hover { background: #FFA500; }
    .delete-btn { background: var(--error); }
    .delete-btn:hover { background: #FF3333; }

    .project-badge, .badge-secondary, .method-badge {
        display: inline-block;
        padding: var(--spacing-xs) var(--spacing-sm);
        border-radius: var(--border-radius);
        font-size: var(--font-size-xs);
        font-weight: 600;
    }

    .project-badge { background: rgba(123, 97, 255, 0.1); color: var(--primary); }
    .badge-secondary { background: rgba(0, 196, 204, 0.1); color: var(--secondary); }
    .method-badge { background: rgba(100, 100, 100, 0.1); color: var(--gray-700); }

    .text-muted { color: var(--gray-400); }

    .bulk-actions-bar {
        background: var(--primary);
        color: var(--white);
        padding: var(--spacing-md) var(--spacing-lg);
        border-radius: var(--border-radius);
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: var(--spacing-lg);
    }

    .bulk-action-buttons {
        display: flex;
        gap: var(--spacing-md);
    }

    .btn-small { padding: var(--spacing-xs) var(--spacing-md) !important; font-size: var(--font-size-sm) !important; }

    .empty-state {
        text-align: center;
        padding: var(--spacing-2xl) var(--spacing-lg);
    }

    .empty-icon {
        font-size: 4rem;
        color: var(--gray-300);
        margin-bottom: var(--spacing-lg);
    }

    .empty-state h3 { color: var(--gray-900); font-size: var(--font-size-2xl); margin: 0 0 var(--spacing-sm) 0; }
    .empty-state p { color: var(--gray-600); margin: 0 0 var(--spacing-lg) 0; }

    @media (max-width: 768px) {
        .header-wrapper { flex-direction: column; align-items: flex-start; }
        .table-controls-container { flex-direction: column; }
        .advanced-search { min-width: 100%; }
        .stats-grid { grid-template-columns: 1fr; }
        .stat-card { flex-direction: column; text-align: center; }
    }
</style>

<script>
function filterAndSearchDonations() {
    const searchInput = document.getElementById('searchInput');
    const rows = document.querySelectorAll('.donation-row');
    const searchValue = searchInput.value.toLowerCase();
    const hasSearch = searchValue.length > 0;
    
    document.getElementById('clearBtn').style.display = hasSearch ? 'block' : 'none';
    
    rows.forEach(row => {
        const donor = row.dataset.donor.toLowerCase();
        const email = row.textContent.toLowerCase();
        const amount = row.dataset.amount;
        
        const matches = donor.includes(searchValue) || email.includes(searchValue) || amount.includes(searchValue);
        row.style.display = matches ? '' : 'none';
    });
}

function clearSearch() {
    document.getElementById('searchInput').value = '';
    document.getElementById('clearBtn').style.display = 'none';
    document.querySelectorAll('.donation-row').forEach(row => row.style.display = '');
}

function filterByProject() {
    const filter = document.getElementById('projectFilter').value;
    const rows = document.querySelectorAll('.donation-row');
    
    rows.forEach(row => {
        const project = row.dataset.project;
        row.style.display = !filter || project === filter ? '' : 'none';
    });
}

function toggleSelectAll() {
    const checkbox = document.getElementById('selectAllCheckbox');
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(cb => cb.checked = checkbox.checked);
    updateBulkActions();
}

function updateBulkActions() {
    const selected = document.querySelectorAll('.row-checkbox:checked').length;
    const bar = document.getElementById('bulkActionsBar');
    const count = document.getElementById('selectedCount');
    
    bar.style.display = selected > 0 ? 'flex' : 'none';
    count.textContent = selected;
}

function clearSelection() {
    document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = false);
    document.getElementById('selectAllCheckbox').checked = false;
    updateBulkActions();
}

function bulkDeleteDonations() {
    if (!confirm('Confirmer la suppression des donations sélectionnées?')) return;
    const ids = Array.from(document.querySelectorAll('.row-checkbox:checked')).map(cb => cb.value);
    if (ids.length) {
        // Implement bulk delete via AJAX or form submission
        alert('Suppressions: ' + ids.join(', '));
    }
}

function exportTableData() {
    const csv = [];
    const table = document.querySelector('.donations-data-table');
    
    Array.from(table.rows).forEach((row, i) => {
        const cols = Array.from(row.cells).map((cell, j) => {
            if (i === 0 || j === 0 || j === 7) return '';
            return '"' + cell.textContent.trim().replace(/"/g, '""') + '"';
        }).filter(c => c);
        csv.push(cols.join(','));
    });
    
    const link = document.createElement('a');
    link.href = 'data:text/csv;charset=utf-8,' + encodeURIComponent(csv.join('\n'));
    link.download = 'donations_' + new Date().toISOString().split('T')[0] + '.csv';
    link.click();
}

function refreshList() {
    location.reload();
}

document.querySelectorAll('.row-checkbox').forEach(cb => cb.addEventListener('change', updateBulkActions));
</script>
