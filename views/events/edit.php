<?php $pageTitle = 'Modifier un Événement'; ?>

<div class="form-page-header">
    <div class="header-wrapper">
        <div class="header-content">
            <div class="header-icon edit">
                <i class="fas fa-calendar-edit"></i>
            </div>
            <div>
                <h1 class="form-page-title">Modifier l'Événement</h1>
                <p class="form-page-subtitle">Mettre à jour : <strong><?php echo htmlspecialchars(substr($event['title'], 0, 50)); ?></strong></p>
            </div>
        </div>
        <a href="<?php echo BASE_URL; ?>/events" class="btn-back" title="Retour à la liste">
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
                    <h2>Modifier les détails</h2>
                    <p>Mettez à jour les informations de l'événement</p>
                </div>
            </div>

            <form action="/events" method="post" data-validate class="event-form">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?php echo $event['id']; ?>">

                <div class="form-group">
                    <label for="title" class="form-label">
                        <span>Titre</span>
                        <span class="required-asterisk">*</span>
                    </label>
                    <div class="form-input-wrapper">
                        <i class="fas fa-heading"></i>
                        <input type="text" class="form-control" id="title" name="title" value="<?php echo htmlspecialchars($event['title']); ?>" required minlength="3" maxlength="200">
                    </div>
                    <div class="form-text">Titre descriptif de l'événement.</div>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">
                        <span>Description</span>
                    </label>
                    <div class="form-input-wrapper">
                        <i class="fas fa-align-left"></i>
                        <textarea class="form-control" id="description" name="description" rows="4" style="padding-left: 2.5rem;"><?php echo htmlspecialchars($event['description'] ?? ''); ?></textarea>
                    </div>
                    <div class="form-text">Détails et programme de l'événement.</div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="event_date" class="form-label">
                            <span>Date et heure</span>
                            <span class="required-asterisk">*</span>
                        </label>
                        <div class="form-input-wrapper">
                            <i class="fas fa-calendar-alt"></i>
                            <input type="datetime-local" class="form-control" id="event_date" name="event_date" value="<?php echo date('Y-m-d\TH:i', strtotime($event['event_date'])); ?>" required>
                        </div>
                        <div class="form-text">Date et heure de début.</div>
                    </div>

                    <div class="form-group">
                        <label for="location" class="form-label">
                            <span>Lieu</span>
                        </label>
                        <div class="form-input-wrapper">
                            <i class="fas fa-map-marker-alt"></i>
                            <input type="text" class="form-control" id="location" name="location" value="<?php echo htmlspecialchars($event['location'] ?? ''); ?>">
                        </div>
                        <div class="form-text">Adresse physique ou lien visio.</div>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="organizer_id" class="form-label">
                            <span>Organisateur</span>
                        </label>
                        <div class="form-select-wrapper">
                            <i class="fas fa-user-tie"></i>
                            <select class="form-control form-select" id="organizer_id" name="organizer_id">
                                <option value="">-- Sélectionner un organisateur --</option>
                                <?php if (!empty($organizers)): ?>
                                    <?php foreach ($organizers as $organizer): ?>
                                        <option value="<?php echo $organizer['id']; ?>" <?php echo ($event['organizer_id'] == $organizer['id']) ? 'selected' : ''; ?>><?php echo htmlspecialchars($organizer['username']); ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-text">Responsable de l'organisation.</div>
                    </div>

                    <div class="form-group">
                        <label for="max_participants" class="form-label">
                            <span>Participants max</span>
                        </label>
                        <div class="form-input-wrapper">
                            <i class="fas fa-users"></i>
                            <input type="number" class="form-control" id="max_participants" name="max_participants" min="1" value="<?php echo $event['max_participants'] ?? ''; ?>">
                        </div>
                        <div class="form-text">Limite de places disponibles.</div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="status" class="form-label">
                        <span>Statut</span>
                        <span class="required-asterisk">*</span>
                    </label>
                    <div class="form-select-wrapper">
                        <i class="fas fa-tasks"></i>
                        <select class="form-control form-select" id="status" name="status" required>
                            <option value="planned" <?php echo $event['status'] === 'planned' ? 'selected' : ''; ?>>📅 Planifié</option>
                            <option value="ongoing" <?php echo $event['status'] === 'ongoing' ? 'selected' : ''; ?>>▶️ En cours</option>
                            <option value="completed" <?php echo $event['status'] === 'completed' ? 'selected' : ''; ?>>✅ Terminé</option>
                            <option value="cancelled" <?php echo $event['status'] === 'cancelled' ? 'selected' : ''; ?>>❌ Annulé</option>
                        </select>
                    </div>
                    <div class="form-text">État actuel de l'événement.</div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-large">
                        <i class="fas fa-save"></i>
                        <span>Mettre à jour</span>
                    </button>
                    <a href="<?php echo BASE_URL; ?>/events" class="btn btn-secondary btn-large">
                        <i class="fas fa-times-circle"></i>
                        <span>Annuler</span>
                    </a>
                </div>
            </form>
        </div>

        <!-- Sidebar -->
        <aside class="form-sidebar">
            <div class="sidebar-card">
                <div class="sidebar-title">
                    <i class="fas fa-info-circle"></i>
                    <span>Informations</span>
                </div>
                <div class="sidebar-content">
                    <div class="info-item">
                        <span class="info-label">ID événement :</span>
                        <span class="info-value">#<?php echo $event['id']; ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Créé le :</span>
                        <span class="info-value"><?php echo date('d/m/Y H:i', strtotime($event['created_at'])); ?></span>
                    </div>
                    <div class="info-item">
                        <span class="info-label">Statut actuel :</span>
                        <span class="info-value">
                            <?php
                            $statusLabel = match ($event['status']) {
                                'planned' => '📅 Planifié',
                                'ongoing' => '▶️ En cours',
                                'completed' => '✅ Terminé',
                                'cancelled' => '❌ Annulé',
                                default => ucfirst($event['status'])
                            };
                            echo $statusLabel;
                            ?>
                        </span>
                    </div>
                </div>
            </div>

            <div class="sidebar-card">
                <div class="sidebar-title">
                    <i class="fas fa-exclamation-circle"></i>
                    <span>Important</span>
                </div>
                <div class="sidebar-content">
                    <ul class="warning-list">
                        <li>Les modifications s'appliquent immédiatement</li>
                        <li>Prévenez les participants des changements importants</li>
                        <li>Archivez les événements terminés</li>
                    </ul>
                </div>
            </div>
        </aside>
    </div>
</div>

<style>
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
        font-size: var(--font-size-sm);
    }

    .info-value {
        color: var(--primary);
        font-weight: 500;
        font-size: var(--font-size-sm);
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

    .event-form {
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
        grid-template-columns: repeat(2, 1fr);
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
        resize: vertical;
        min-height: 100px;
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