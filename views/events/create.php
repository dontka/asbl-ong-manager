<?php $pageTitle = 'Ajouter un Événement'; ?>

<div class="form-page-header">
    <div class="header-wrapper">
        <div class="header-content">
            <div class="header-icon">
                <i class="fas fa-calendar-plus"></i>
            </div>
            <div>
                <h1 class="form-page-title">Ajouter un Événement</h1>
                <p class="form-page-subtitle">Planifiez un nouvel événement dans votre calendrier</p>
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
                    <h2>Détails de l'événement</h2>
                    <p>Remplissez les informations pour créer un nouvel événement</p>
                </div>
            </div>

            <form action="/events" method="post" data-validate class="event-form">
                <input type="hidden" name="action" value="store">
                <div class="form-group">
                    <label for="title" class="form-label">
                        <span>Titre</span>
                        <span class="required-asterisk">*</span>
                    </label>
                    <div class="form-input-wrapper">
                        <i class="fas fa-heading"></i>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Titre de l'événement" required minlength="3" maxlength="200">
                    </div>
                    <div class="form-text">Le titre doit contenir 3 à 200 caractères.</div>
                </div>

                <div class="form-group">
                    <label for="description" class="form-label">
                        <span>Description</span>
                    </label>
                    <div class="form-input-wrapper">
                        <i class="fas fa-align-left"></i>
                        <textarea class="form-control" id="description" name="description" placeholder="Décrivez l'événement..." rows="4" style="padding-left: 2.5rem;"></textarea>
                    </div>
                    <div class="form-text">Fournissez les détails et objectifs de l'événement.</div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="event_date" class="form-label">
                            <span>Date et heure</span>
                            <span class="required-asterisk">*</span>
                        </label>
                        <div class="form-input-wrapper">
                            <i class="fas fa-calendar-alt"></i>
                            <input type="datetime-local" class="form-control" id="event_date" name="event_date" required>
                        </div>
                        <div class="form-text">Date et heure de début de l'événement.</div>
                    </div>

                    <div class="form-group">
                        <label for="location" class="form-label">
                            <span>Lieu</span>
                        </label>
                        <div class="form-input-wrapper">
                            <i class="fas fa-map-marker-alt"></i>
                            <input type="text" class="form-control" id="location" name="location" placeholder="Adresse ou lien visioconférence">
                        </div>
                        <div class="form-text">Laissez vide si l'événement est en ligne.</div>
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
                                        <option value="<?php echo $organizer['id']; ?>"><?php echo htmlspecialchars($organizer['username']); ?></option>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                            </select>
                        </div>
                        <div class="form-text">Personne responsable de l'organisation.</div>
                    </div>

                    <div class="form-group">
                        <label for="max_participants" class="form-label">
                            <span>Participants max</span>
                        </label>
                        <div class="form-input-wrapper">
                            <i class="fas fa-users"></i>
                            <input type="number" class="form-control" id="max_participants" name="max_participants" placeholder="Nombre illimité si vide" min="1">
                        </div>
                        <div class="form-text">Capacité maximale de l'événement.</div>
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
                            <option value="planned">📅 Planifié - Événement prévu ultérieurement</option>
                            <option value="ongoing">▶️ En cours - Événement actuellement actif</option>
                            <option value="completed">✅ Terminé - Événement achevé</option>
                            <option value="cancelled">❌ Annulé - Événement annulé</option>
                        </select>
                    </div>
                    <div class="form-text">État actuel de l'événement.</div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-large">
                        <i class="fas fa-check-circle"></i>
                        <span>Créer l'événement</span>
                    </button>
                    <a href="<?php echo BASE_URL; ?>/events" class="btn btn-secondary btn-large">
                        <i class="fas fa-times-circle"></i>
                        <span>Annuler</span>
                    </a>
                </div>
            </form>
        </div>

        <!-- Sidebar avec infos -->
        <aside class="form-sidebar">
            <div class="sidebar-card">
                <div class="sidebar-title">
                    <i class="fas fa-lightbulb"></i>
                    <span>Conseils</span>
                </div>
                <div class="sidebar-content">
                    <ul class="tip-list">
                        <li><strong>Titre clair :</strong> Utilisez un titre descriptif et accrocheur</li>
                        <li><strong>Description détaillée :</strong> Incluez objectifs et programme</li>
                        <li><strong>Capacité :</strong> Définissez si vous avez une limite de places</li>
                        <li><strong>Statut :</strong> Mettez à jour au fur et à mesure de l'événement</li>
                    </ul>
                </div>
            </div>

            <div class="sidebar-card">
                <div class="sidebar-title">
                    <i class="fas fa-info-circle"></i>
                    <span>Statuts disponibles</span>
                </div>
                <div class="sidebar-content">
                    <div class="status-guide">
                        <div class="status-item">
                            <div class="status-badge planned">📅</div>
                            <div>
                                <strong>Planifié</strong>
                                <p>Événement prévu mais non commencé</p>
                            </div>
                        </div>
                        <div class="status-item">
                            <div class="status-badge ongoing">▶️</div>
                            <div>
                                <strong>En cours</strong>
                                <p>Événement en déroulement maintenant</p>
                            </div>
                        </div>
                        <div class="status-item">
                            <div class="status-badge completed">✅</div>
                            <div>
                                <strong>Terminé</strong>
                                <p>Événement achevé avec succès</p>
                            </div>
                        </div>
                        <div class="status-item">
                            <div class="status-badge cancelled">❌</div>
                            <div>
                                <strong>Annulé</strong>
                                <p>Événement annulé ou reporté</p>
                            </div>
                        </div>
                    </div>
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

    .tip-list {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: var(--spacing-md);
    }

    .tip-list li {
        padding-left: var(--spacing-md);
        position: relative;
        margin: 0;
    }

    .tip-list li::before {
        content: '✓';
        position: absolute;
        left: 0;
        color: var(--success);
        font-weight: 700;
    }

    .status-guide {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-md);
    }

    .status-item {
        display: flex;
        gap: var(--spacing-sm);
        align-items: flex-start;
    }

    .status-badge {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--white);
        font-size: var(--font-size-lg);
        flex-shrink: 0;
    }

    .status-badge.planned {
        background: linear-gradient(135deg, #B0BEC5, #90A4AE);
    }

    .status-badge.ongoing {
        background: linear-gradient(135deg, #00D4AA, #00C4CC);
    }

    .status-badge.completed {
        background: linear-gradient(135deg, #4CAF50, #45a049);
    }

    .status-badge.cancelled {
        background: linear-gradient(135deg, #FF6B6B, #FF4757);
    }

    .status-item strong {
        font-weight: 600;
        color: var(--gray-900);
        display: block;
        margin-bottom: 0.25rem;
    }

    .status-item p {
        font-size: var(--font-size-xs);
        color: var(--gray-500);
        margin: 0;
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