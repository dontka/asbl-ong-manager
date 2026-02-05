<?php $pageTitle = 'Modifier un Utilisateur'; ?>

<div class="form-page-header">
    <div class="header-wrapper">
        <div class="header-content">
            <div class="header-icon edit">
                <i class="fas fa-user-edit"></i>
            </div>
            <div>
                <h1 class="form-page-title">Modifier un Utilisateur</h1>
                <p class="form-page-subtitle">Mettre à jour le compte de <strong><?php echo htmlspecialchars($user['username']); ?></strong></p>
            </div>
        </div>
        <a href="<?php echo BASE_URL; ?>/users" class="btn-back" title="Retour à la liste">
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
                    <h2>Modifier les informations</h2>
                    <p>Modifiez les détails du compte utilisateur ci-dessous</p>
                </div>
            </div>

            <form action="/users" method="post" data-validate class="user-form">
                <input type="hidden" name="action" value="update">
                <input type="hidden" name="id" value="<?php echo $user['id']; ?>">

                <div class="form-group">
                    <label for="username" class="form-label">
                        <span>Nom d'utilisateur</span>
                        <span class="required-asterisk">*</span>
                    </label>
                    <div class="form-input-wrapper">
                        <i class="fas fa-user"></i>
                        <input 
                            type="text" 
                            class="form-control" 
                            id="username" 
                            name="username" 
                            value="<?php echo htmlspecialchars($user['username']); ?>" 
                            placeholder="Nom d'utilisateur" 
                            required
                            minlength="3"
                            maxlength="50"
                        >
                    </div>
                    <div class="form-text">Le nom doit contenir 3 à 50 caractères et être unique.</div>
                </div>

                <div class="form-group">
                    <label for="email" class="form-label">
                        <span>Adresse email</span>
                        <span class="required-asterisk">*</span>
                    </label>
                    <div class="form-input-wrapper">
                        <i class="fas fa-envelope"></i>
                        <input 
                            type="email" 
                            class="form-control" 
                            id="email" 
                            name="email" 
                            value="<?php echo htmlspecialchars($user['email']); ?>" 
                            placeholder="exemple@domaine.com" 
                            required
                        >
                    </div>
                    <div class="form-text">L'adresse email doit être unique et valide.</div>
                </div>

                <div class="form-group">
                    <label for="password" class="form-label">
                        <span>Nouveau mot de passe</span>
                        <span class="optional-label">(Optionnel)</span>
                    </label>
                    <div class="form-input-wrapper">
                        <i class="fas fa-lock"></i>
                        <input 
                            type="password" 
                            class="form-control" 
                            id="password" 
                            name="password" 
                            placeholder="Laissez vide pour conserver le mot de passe actuel" 
                            minlength="6"
                        >
                    </div>
                    <div class="form-text">Minimum 6 caractères. Laissez vide si vous ne souhaitez pas changer le mot de passe.</div>
                </div>

                <div class="form-group">
                    <label for="role" class="form-label">
                        <span>Rôle d'accès</span>
                        <span class="required-asterisk">*</span>
                    </label>
                    <div class="form-select-wrapper">
                        <i class="fas fa-shield-alt"></i>
                        <select class="form-control form-select" id="role" name="role" required>
                            <option value="visitor" <?php echo $user['role'] === 'visitor' ? 'selected' : ''; ?>>👤 Visiteur - Accès lecture seule</option>
                            <option value="moderator" <?php echo $user['role'] === 'moderator' ? 'selected' : ''; ?>>🎖️ Modérateur - Accès modération</option>
                            <option value="admin" <?php echo $user['role'] === 'admin' ? 'selected' : ''; ?>>👑 Administrateur - Accès complet</option>
                        </select>
                    </div>
                    <div class="form-text">Le rôle détermine les permissions et l'accès aux fonctionnalités du système.</div>
                </div>

                <div class="form-actions">
                    <button type="submit" class="btn btn-primary btn-large">
                        <i class="fas fa-save"></i>
                        <span>Mettre à jour</span>
                    </button>
                    <a href="<?php echo BASE_URL; ?>/users" class="btn btn-secondary btn-large">
                        <i class="fas fa-times-circle"></i>
                        <span>Annuler</span>
                    </a>
                </div>
            </form>
        </div>

        <!-- Sidebar avec informations -->
        <aside class="form-sidebar">
            <div class="sidebar-card">
                <div class="sidebar-title">
                    <i class="fas fa-info-circle"></i>
                    <span>Informations du compte</span>
                </div>
                <div class="sidebar-content">
                    <div class="user-info-item">
                        <span class="info-label">ID utilisateur :</span>
                        <span class="info-value">#<?php echo $user['id']; ?></span>
                    </div>
                    <div class="user-info-item">
                        <span class="info-label">Créé le :</span>
                        <span class="info-value"><?php echo date('d/m/Y H:i', strtotime($user['created_at'])); ?></span>
                    </div>
                    <div class="user-info-item">
                        <span class="info-label">Rôle actuel :</span>
                        <span class="info-value">
                            <?php
                            $roleLabel = match ($user['role']) {
                                'admin' => 'Administrateur',
                                'moderator' => 'Modérateur',
                                'visitor' => 'Visiteur',
                                default => ucfirst($user['role'])
                            };
                            echo $roleLabel;
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
                        <li>Les modifications seront appliquées immédiatement</li>
                        <li>Changement de rôle affecte les permissions</li>
                        <li>L'utilisateur devra se reconnecter si vous modifiez son rôle</li>
                    </ul>
                </div>
            </div>
        </aside>
    </div>
</div>

<style>
    .optional-label {
        font-size: var(--font-size-xs);
        color: var(--gray-500);
        font-weight: 400;
    }

    .user-info-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--spacing-sm) 0;
        border-bottom: 1px solid var(--gray-200);
    }

    .user-info-item:last-child {
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

    .form-page-header .header-icon.edit {
        background: rgba(255, 193, 7, 0.1);
        color: #FFD700;
    }

    /* Réutiliser les styles du create.php */
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

    .user-form {
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