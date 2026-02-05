<?php $pageTitle = 'Mon Profil'; ?>

<div class="myprofile-page-header">
    <div class="header-top">
        <div class="header-title-section">
            <div class="my-avatar">
                <i class="fas fa-user-circle"></i>
            </div>
            <div>
                <h1>Mon Profil</h1>
                <p>Gérez vos informations personnelles et vos préférences</p>
            </div>
        </div>
        <a href="<?php echo BASE_URL; ?>/dashboard" class="btn-back-dash" title="Retour au dashboard">
            <i class="fas fa-home"></i>
            <span>Dashboard</span>
        </a>
    </div>
</div>

<div class="myprofile-container">
    <div class="myprofile-main">
        <!-- Section Informations -->
        <div class="profile-section">
            <div class="section-header">
                <h2><i class="fas fa-user"></i> Informations personnelles</h2>
                <p>Votre identité dans le système</p>
            </div>
            <div class="section-body">
                <form action="/profile" method="post" data-validate class="profile-form">
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
                                placeholder="Votre nom d'utilisateur" 
                                required
                                minlength="3"
                            >
                        </div>
                        <div class="form-text">Votre identifiant unique dans le système (3+ caractères).</div>
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
                                placeholder="votre.email@example.com" 
                                required
                            >
                        </div>
                        <div class="form-text">Utilisée pour les notifications et la récupération de compte.</div>
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
                        <div class="form-text">Minimum 6 caractères. Pour votre sécurité, utilisez des caractères variés.</div>
                    </div>

                    <div class="form-actions-profile">
                        <button type="submit" class="btn btn-primary btn-large-profile">
                            <i class="fas fa-save"></i>
                            <span>Enregistrer les modifications</span>
                        </button>
                        <button type="reset" class="btn btn-secondary btn-large-profile">
                            <i class="fas fa-redo"></i>
                            <span>Réinitialiser</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Sidebar information -->
    <aside class="myprofile-sidebar">
        <!-- Compte Info -->
        <div class="sidebar-section">
            <div class="section-title">
                <i class="fas fa-id-card"></i>
                <span>Informations du compte</span>
            </div>
            <div class="section-items">
                <div class="account-item">
                    <span class="account-label">Rôle</span>
                    <span class="account-value">
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
                <div class="account-item">
                    <span class="account-label">ID utilisateur</span>
                    <span class="account-value">#<?php echo $user['id']; ?></span>
                </div>
                <div class="account-item">
                    <span class="account-label">Créé le</span>
                    <span class="account-value"><?php echo date('d/m/Y', strtotime($user['created_at'])); ?></span>
                </div>
                <div class="account-item">
                    <span class="account-label">Modifié le</span>
                    <span class="account-value"><?php echo date('d/m/Y', strtotime($user['updated_at'] ?? $user['created_at'])); ?></span>
                </div>
            </div>
        </div>

        <!-- Sécurité -->
        <div class="sidebar-section">
            <div class="section-title">
                <i class="fas fa-shield-alt"></i>
                <span>Sécurité</span>
            </div>
            <div class="section-items">
                <p class="security-tip">Pour protéger votre compte, assurez-vous que :</p>
                <ul class="security-checklist">
                    <li>Votre mot de passe est unique et complexe</li>
                    <li>Vous ne le partagez jamais</li>
                    <li>Vous vous déconnectez après chaque session</li>
                    <li>L'email du compte est à jour</li>
                </ul>
            </div>
        </div>

        <!-- Aide -->
        <div class="sidebar-section help">
            <div class="section-title">
                <i class="fas fa-question-circle"></i>
                <span>Besoin d'aide ?</span>
            </div>
            <div class="section-items">
                <a href="<?php echo BASE_URL; ?>/documentation" class="help-link">
                    <i class="fas fa-book"></i>
                    <span>Consulter la documentation</span>
                </a>
                <a href="<?php echo BASE_URL; ?>/support" class="help-link">
                    <i class="fas fa-headset"></i>
                    <span>Contacter le support</span>
                </a>
            </div>
        </div>
    </aside>
</div>

<style>
    .myprofile-page-header {
        background: linear-gradient(135deg, var(--primary), var(--secondary));
        color: var(--white);
        padding: var(--spacing-xl);
        margin-bottom: var(--spacing-lg);
        border-radius: var(--border-radius-lg);
        box-shadow: var(--shadow-lg);
    }

    .header-top {
        display: flex;
        justify-content: space-between;
        align-items: center;
        gap: var(--spacing-lg);
        flex-wrap: wrap;
    }

    .header-title-section {
        display: flex;
        align-items: center;
        gap: var(--spacing-lg);
        flex: 1;
        min-width: 300px;
    }

    .my-avatar {
        font-size: 4rem;
        opacity: 0.9;
    }

    .myprofile-page-header h1 {
        font-size: var(--font-size-4xl);
        font-weight: 700;
        margin: 0 0 var(--spacing-xs) 0;
    }

    .myprofile-page-header p {
        font-size: var(--font-size-md);
        margin: 0;
        opacity: 0.95;
    }

    .btn-back-dash {
        display: inline-flex;
        align-items: center;
        gap: var(--spacing-sm);
        padding: var(--spacing-sm) var(--spacing-md);
        background: rgba(255, 255, 255, 0.2);
        border: 1px solid rgba(255, 255, 255, 0.4);
        border-radius: var(--border-radius);
        color: var(--white);
        text-decoration: none;
        transition: var(--transition);
        font-weight: 500;
        cursor: pointer;
    }

    .btn-back-dash:hover {
        background: rgba(255, 255, 255, 0.3);
        border-color: rgba(255, 255, 255, 0.6);
    }

    .myprofile-container {
        display: grid;
        grid-template-columns: 1fr 350px;
        gap: var(--spacing-lg);
    }

    .myprofile-main {
        flex: 1;
    }

    .profile-section {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--border-radius-lg);
        overflow: hidden;
        box-shadow: var(--shadow-sm);
    }

    .section-header {
        padding: var(--spacing-lg);
        border-bottom: 1px solid var(--gray-200);
        background: linear-gradient(135deg, var(--gray-50), var(--white));
    }

    .section-header h2 {
        font-size: var(--font-size-2xl);
        font-weight: 700;
        color: var(--gray-900);
        margin: 0 0 var(--spacing-xs) 0;
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
    }

    .section-header h2 i {
        color: var(--primary);
        font-size: var(--font-size-2xl);
    }

    .section-header p {
        font-size: var(--font-size-sm);
        color: var(--gray-600);
        margin: 0;
    }

    .section-body {
        padding: var(--spacing-lg);
    }

    .profile-form {
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

    .form-text {
        font-size: var(--font-size-xs);
        color: var(--gray-500);
        margin: 0;
    }

    .form-actions-profile {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: var(--spacing-md);
        padding-top: var(--spacing-lg);
        border-top: 1px solid var(--gray-200);
        margin-top: var(--spacing-lg);
    }

    .btn-large-profile {
        padding: var(--spacing-md) var(--spacing-lg) !important;
        display: flex !important;
        align-items: center;
        justify-content: center;
        gap: var(--spacing-sm);
        font-weight: 600;
    }

    /* Sidebar */
    .myprofile-sidebar {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-lg);
    }

    .sidebar-section {
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--border-radius-lg);
        padding: var(--spacing-lg);
        box-shadow: var(--shadow-sm);
    }

    .sidebar-section.help {
        background: linear-gradient(135deg, rgba(123, 97, 255, 0.05), rgba(0, 196, 204, 0.05));
        border-color: rgba(123, 97, 255, 0.2);
    }

    .section-title {
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
        font-weight: 700;
        color: var(--gray-900);
        margin: 0 0 var(--spacing-md) 0;
        font-size: var(--font-size-md);
    }

    .section-title i {
        color: var(--primary);
        font-size: var(--font-size-lg);
    }

    .section-items {
        display: flex;
        flex-direction: column;
        gap: var(--spacing-sm);
    }

    .account-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: var(--spacing-sm) 0;
        border-bottom: 1px solid var(--gray-200);
    }

    .account-item:last-child {
        border-bottom: none;
    }

    .account-label {
        font-weight: 600;
        color: var(--gray-700);
        font-size: var(--font-size-sm);
    }

    .account-value {
        font-size: var(--font-size-sm);
        color: var(--primary);
        font-weight: 500;
    }

    .security-tip {
        font-size: var(--font-size-sm);
        color: var(--gray-700);
        margin: 0 0 var(--spacing-md) 0;
        font-weight: 600;
    }

    .security-checklist {
        list-style: none;
        padding: 0;
        margin: 0;
        display: flex;
        flex-direction: column;
        gap: var(--spacing-sm);
    }

    .security-checklist li {
        padding-left: var(--spacing-md);
        position: relative;
        margin: 0;
        font-size: var(--font-size-sm);
        color: var(--gray-600);
    }

    .security-checklist li::before {
        content: '✓';
        position: absolute;
        left: 0;
        color: var(--success);
        font-weight: 700;
    }

    .help-link {
        display: flex;
        align-items: center;
        gap: var(--spacing-sm);
        padding: var(--spacing-sm) var(--spacing-md);
        background: var(--white);
        border: 1px solid var(--gray-200);
        border-radius: var(--border-radius-sm);
        color: var(--primary);
        text-decoration: none;
        transition: var(--transition);
        font-size: var(--font-size-sm);
        font-weight: 500;
    }

    .help-link:hover {
        background: var(--primary);
        border-color: var(--primary);
        color: var(--white);
    }

    @media (max-width: 768px) {
        .myprofile-container {
            grid-template-columns: 1fr;
        }

        .header-top {
            flex-direction: column;
            align-items: flex-start;
        }

        .header-title-section {
            width: 100%;
        }

        .btn-back-dash {
            width: 100%;
            justify-content: center;
        }

        .form-actions-profile {
            grid-template-columns: 1fr;
        }
    }
</style>