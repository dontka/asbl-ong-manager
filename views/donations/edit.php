<?php $pageTitle = 'Modifier un Don'; ?>

<div class="form-page-header">
    <div class="header-wrapper">
        <div class="header-content">
            <div class="header-icon edit">
                <i class="fas fa-edit"></i>
            </div>
            <div>
                <h1 class="form-page-title">Modifier un Don</h1>
                <p class="form-page-subtitle">Mettre à jour les détails de la donation #<?php echo $donation['id']; ?></p>
            </div>
        </div>
        <a href="<?php echo BASE_URL; ?>/donations" class="btn-back" title="Retour à la liste">
            <i class="fas fa-arrow-left"></i>
            <span>Retour</span>
        </a>
    </div>
</div>

<div class="form-container">
    <div class="form-wrapper">
        <div class="form-card">
            <div class="form-header">
                <div class="form-title-section">
                    <h2>Modifier la donation</h2>
                    <p>Mettez à jour les informations de cette donation</p>
                </div>
            </div>

            <form action="/donations" method="post" data-validate class="donation-form">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?php echo $donation['id']; ?>">

                <div class="form-group">
                    <label for="donor_name" class="form-label">
                        <span>Nom du donateur</span>
                        <span class="required-asterisk">*</span>
                    </label>
                    <div class="form-input-wrapper">
                        <i class="fas fa-user"></i>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="donor_name" 
                            name="donor_name" 
                            value="<?php echo htmlspecialchars($donation['donor_name']); ?>" 
                            placeholder="Nom du donateur" 
                            required
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="donor_email" class="form-label">
                        <span>Email du donateur</span>
                        <span class="optional-label">(Optionnel)</span>
                    </label>
                    <div class="form-input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input 
                            type="email" 
                            class="form-control" 
                            id="donor_email" 
                            name="donor_email" 
                            value="<?php echo htmlspecialchars($donation['donor_email'] ?? ''); ?>" 
                            placeholder="email@example.com"
                        >
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="amount" class="form-label">
                            <span>Montant (€)</span>
                            <span class="required-asterisk">*</span>
                        </label>
                        <div class="form-input-wrapper">
                            <i class="fas fa-euro-sign"></i>
                            <input 
                                type="number" 
                                class="form-control" 
                                id="amount" 
                                name="amount" 
                                step="0.01" 
                                min="0.01" 
                                value="<?php echo $donation['amount']; ?>" 
                                required
                            >
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="donation_date" class="form-label">
                            <span>Date du don</span>
                            <span class="required-asterisk">*</span>
                        </label>
                        <div class="form-input-wrapper">
                            <i class="fas fa-calendar-alt"></i>
                            <input 
                                type="date" 
                                class="form-control" 
                                id="donation_date" 
                                name="donation_date" 
                                value="<?php echo $donation['donation_date']; ?>" 
                                required
                            >
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="payment_method" class="form-label">
                        <span>Méthode de paiement</span>
                        <span class="required-asterisk">*</span>
                    </label>
                    <div class="form-select-wrapper">
                        <i class="fas fa-credit-card"></i>
                        <select class="form-control form-select" id="payment_method" name="payment_method" required>
                            <option value="cash" <?php echo $donation['payment_method'] === 'cash' ? 'selected' : ''; ?>>💵 Espèces</option>
                            <option value="bank_transfer" <?php echo $donation['payment_method'] === 'bank_transfer' ? 'selected' : ''; ?>>🏦 Virement bancaire</option>
                            <option value="online" <?php echo $donation['payment_method'] === 'online' ? 'selected' : ''; ?>>💳 Paiement en ligne</option>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="project_id" class="form-label">
                        <span>Projet associé</span>
                        <span class="optional-label">(Optionnel)</span>
                    </label>
                    <div class="form-select-wrapper">
                        <i class="fas fa-folder"></i>
                        <select class="form-control form-select" id="project_id" name="project_id">
                            <option value="">Don général (sans projet spécifique)</option>
                            <?php if (!empty($projects)): ?>
                                <?php foreach ($projects as $project): ?>
                                    <option value="<?php echo $project['id']; ?>" <?php echo ($donation['project_id'] == $project['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($project['name']); ?></option>
                                <?php endforeach; ?>
                            <?php endif; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="notes" class="form-label">
                        <span>Notes</span>
                        <span class="optional-label">(Optionnel)</span>
                    </label>
                    <textarea 
                        class="form-control" 
                        id="notes" 
                        name="notes" 
                        rows="4"
                    ><?php echo htmlspecialchars($donation['notes'] ?? ''); ?></textarea>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-large">
                        <i class="fas fa-save"></i>
                        <span>Mettre à jour</span>
                    </button>
                    <a href="<?php echo BASE_URL; ?>/donations" class="btn btn-secondary btn-large">
                        <i class="fas fa-times-circle"></i>
                        <span>Annuler</span>
                    </a>
                </div>
            </form>
        </div>

        <aside class="form-sidebar">
            <div class="sidebar-card">
                <div class="sidebar-title">
                    <i class="fas fa-info-circle"></i>
                    <span>Informations</span>
                </div>
                <div class="sidebar-content">
                    <div class="info-item">
                        <span class="info-label">ID Don :</span>
                        <span class="info-value">#<?php echo $donation['id']; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Créée le :</span>
                        <span class="info-value"><?php echo date('d/m/Y H:i', strtotime($donation['created_at'])); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Statut :</span>
                        <span class="info-value" style="color: var(--success); font-weight: 600;">✓ Confirmée</span>
                    </div>
                </div>
            </div>

            <div class="sidebar-card">
                <div class="sidebar-title">
                    <i class="fas fa-warning"></i>
                    <span>Important</span>
                </div>
                <div class="sidebar-content">
                    <ul class="warning-list">
                        <li>Les modifications seront sauvegardées immédiatement</li>
                        <li>Vérifiez l'exactitude du montant</li>
                        <li>L'email sera utilisé pour les communications</li>
                    </ul>
                </div>
            </div>
        </aside>
    </div>
</div>

<style>
    .form-page-header {
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

    .header-icon.edit {
        background: rgba(255, 193, 7, 0.1);
        color: #FFD700;
    }

    .form-page-title {
        font-size: var(--font-size-3xl);
        font-weight: 700;
        color: var(--gray-900);
        margin: 0 0 var(--spacing-xs) 0;
    }

    .form-page-subtitle {
        font-size: var(--font-size-sm);
        color: var(--gray-600);
        margin: 0;
    }

    .btn-back {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-sm);
        padding: var(--spacing-sm) var(--spacing-md);
        background: var(--white);
        border: 1px solid var(--gray-300);
        border-radius: var(--border-radius);
        color: var(--gray-700);
        text-decoration: none;
        transition: var(--transition);
        font-weight: 500;
        cursor: pointer;
    }

    .btn-back:hover {
        background: var(--primary);
        border-color: var(--primary);
        color: var(--white);
    }

    .form-container {
        margin-bottom: var(--spacing-lg);
    }

    .form-wrapper {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: var(--spacing-lg);
    }

    .form-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-sm);
        overflow: hidden;
    }

    .form-header {
        padding: var(--spacing-lg);
        border-bottom: 1px solid var(--gray-200);
        background: linear-gradient(135deg, var(--gray-50), var(--white));
    }

    .form-title-section h2 {
        font-size: var(--font-size-2xl);
        font-weight: 700;
        color: var(--gray-900);
        margin: 0 0 var(--spacing-xs) 0;
    }

    .form-title-section p {
        font-size: var(--font-size-sm);
        color: var(--gray-600);
        margin: 0;
    }

    .donation-form {
        padding: var(--spacing-lg);
        display: flex;
        flex-direction: column;
        gap: var(--spacing-lg);
    }

    .form-group {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-sm);
    }

    .form-row {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--spacing-lg);
    }

    .form-label {
        font-size: var(--font-size-sm);
        font-weight: 600;
        color: var(--gray-900);
        display: flex;
        align-items: center;
        gap: var(--spacing-xs);
        margin: 0;
        flex-wrap: wrap;
    }

    .required-asterisk {
        color: var(--error);
    }

    .optional-label {
        font-size: var(--font-size-xs);
        color: var(--gray-500);
        font-weight: 400;
    }

    .form-input-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .form-input-wrapper i {
        position: absolute;
        left: var(--spacing-md);
        color: var(--gray-400);
        font-size: var(--font-size-md);
        pointer-events: none;
    }

    .form-control {
        width: 100%;
        padding: var(--spacing-sm) var(--spacing-md) var(--spacing-sm) 2.5rem;
        border: 1px solid var(--gray-300);
        border-radius: var(--border-radius);
        font-size: var(--font-size-sm);
        color: var(--gray-900);
        background: var(--white);
        transition: var(--transition);
        font-family: inherit;
    }

    .form-control:focus {
        outline: none;
        border-color: var(--primary);
        box-shadow: 0 0 0 3px rgba(123, 97, 255, 0.1);
    }

    .form-control::placeholder {
        color: var(--gray-400);
    }

    textarea.form-control {
        padding: var(--spacing-md);
        padding-left: var(--spacing-md);
    }

    .form-select-wrapper {
        position: relative;
        display: flex;
        align-items: center;
    }

    .form-select-wrapper i {
        position: absolute;
        left: var(--spacing-md);
        color: var(--gray-400);
        font-size: var(--font-size-md);
        pointer-events: none;
    }

    .form-select {
        padding-left: 2.5rem !important;
        appearance: none;
        background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='none' stroke='%23666' stroke-width='2'%3E%3Cpolyline points='6 9 12 15 18 9'%3E%3C/polyline%3E%3C/svg%3E");
        background-repeat: no-repeat;
        background-position: right var(--spacing-md) center;
        background-size: 1.25rem;
        padding-right: 2.5rem;
    }

    .form-text {
        font-size: var(--font-size-xs);
        color: var(--gray-500);
        margin: 0;
    }

    .form-actions {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--spacing-md);
        margin-top: var(--spacing-lg);
        padding-top: var(--spacing-lg);
        border-top: 1px solid var(--gray-200);
    }

    .btn-large {
        padding: var(--spacing-md) var(--spacing-lg) !important;
        display: flex !important;
        align-items: center;
        justify-content: center;
        gap: var(--spacing-sm);
        font-weight: 600;
        white-space: nowrap;
    }

    .form-sidebar {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-lg);
    }

    .sidebar-card {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--border-radius-lg);
        padding: var(--spacing-lg);
        box-shadow: var(--shadow-sm);
    }

    .sidebar-title {
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
        font-weight: 700;
        color: var(--gray-900);
        margin: 0 0 var(--spacing-md) 0;
        font-size: var(--font-size-md);
    }

    .sidebar-title i {
        color: var(--primary);
    }

    .sidebar-content {
        font-size: var(--font-size-sm);
        color: var(--gray-600);
        line-height: 1.6;
    }

    .info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--spacing-sm) 0;
        border-bottom: 1px solid var(--gray-200);
    }

    .info-item:last-child {
        border-bottom: none;
    }

    .info-label {
        font-weight: 600;
        color: var(--gray-700);
    }

    .info-value {
        color: var(--primary);
        font-weight: 500;
    }

    .warning-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: var(--spacing-sm);
    }

    .warning-list li {
        padding-left: var(--spacing-md);
        position: relative;
        margin: 0;
        font-size: var(--font-size-xs);
        color: var(--gray-600);
    }

    .warning-list li::before {
        content: '⚠️';
        position: absolute;
        left: 0;
    }

    @media (max-width: 768px) {
        .form-wrapper {
            grid-template-columns: 1fr;
        }

        .form-actions {
            grid-template-columns: 1fr;
        }

        .form-row {
            grid-template-columns: 1fr;
        }

        .header-wrapper {
            flex-direction: column;
            align-items: flex-start;
        }

        .btn-back {
            width: 100%;
            justify-content: center;
        }
    }
</style>