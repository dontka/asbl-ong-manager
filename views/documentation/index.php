<?php
/**
 * Vue d'accueil de la documentation
 * Phase 7.3: Documentation et Maintenance - Design moderne
 */
?>

<div class="nav-container">
    <div class="nav-left">
        <h1><i class="fas fa-book"></i> Documentation</h1>
        <p class="nav-date">Guide complet pour utilisateurs, développeurs et administrateurs</p>
    </div>
    <div class="nav-actions">
        <a href="<?php echo BASE_URL; ?>/dashboard" class="btn btn-secondary">
            <i class="fas fa-home"></i> Accueil
        </a>
    </div>
</div>

<!-- Documentation Topics as KPI Cards -->
<div class="kpi-grid">
    <!-- User Guide Card -->
    <div class="kpi-card documentation">
        <div class="kpi-header">
            <div class="kpi-icon">
                <i class="fas fa-user-friends"></i>
            </div>
            <div class="kpi-content">
                <h2>Guide d'utilisation</h2>
                <p>Apprenez à utiliser toutes les fonctionnalités du système</p>
            </div>
        </div>
        <div class="kpi-footer">
            <ul style="font-size: 14px; margin: 12px 0; padding-left: 20px;">
                <li>Connexion et rôles</li>
                <li>Gestion des membres</li>
                <li>Organisation d'événements</li>
                <li>Suivi des projets</li>
            </ul>
            <a href="<?php echo BASE_URL; ?>/documentation?action=userGuide" class="btn btn-sm btn-primary" style="width: 100%; margin-top: 8px;">
                <i class="fas fa-eye"></i> Consulter
            </a>
        </div>
    </div>

    <!-- Technical Documentation Card -->
    <div class="kpi-card documentation">
        <div class="kpi-header">
            <div class="kpi-icon">
                <i class="fas fa-cogs"></i>
            </div>
            <div class="kpi-content">
                <h2>Documentation technique</h2>
                <p>Informations pour développeurs et administrateurs</p>
            </div>
        </div>
        <div class="kpi-footer">
            <ul style="font-size: 14px; margin: 12px 0; padding-left: 20px;">
                <li>Architecture MVC</li>
                <li>Schéma base de données</li>
                <li>API et sécurité</li>
                <li>Migrations</li>
            </ul>
            <a href="<?php echo BASE_URL; ?>/documentation?action=technicalDoc" class="btn btn-sm btn-secondary" style="width: 100%; margin-top: 8px;">
                <i class="fas fa-code"></i> Voir
            </a>
        </div>
    </div>

    <!-- Maintenance Card -->
    <div class="kpi-card documentation">
        <div class="kpi-header">
            <div class="kpi-icon">
                <i class="fas fa-tools"></i>
            </div>
            <div class="kpi-content">
                <h2>Plan de maintenance</h2>
                <p>Procédures et sauvegarde du système</p>
            </div>
        </div>
        <div class="kpi-footer">
            <ul style="font-size: 14px; margin: 12px 0; padding-left: 20px;">
                <li>Sauvegardes auto</li>
                <li>Monitoring système</li>
                <li>Mises à jour sécurité</li>
                <li>Procédures urgence</li>
            </ul>
            <a href="<?php echo BASE_URL; ?>/documentation?action=maintenance" class="btn btn-sm btn-warning" style="width: 100%; margin-top: 8px;">
                <i class="fas fa-wrench"></i> Plan
            </a>
        </div>
    </div>

    <!-- API Reference Card -->
    <div class="kpi-card documentation">
        <div class="kpi-header">
            <div class="kpi-icon">
                <i class="fas fa-plug"></i>
            </div>
            <div class="kpi-content">
                <h2>Référence API</h2>
                <p>Documentation complète des endpoints API</p>
            </div>
        </div>
        <div class="kpi-footer">
            <ul style="font-size: 14px; margin: 12px 0; padding-left: 20px;">
                <li>Authentification</li>
                <li>Gestion membres</li>
                <li>Événements & projets</li>
                <li>Dons & rapports</li>
            </ul>
            <a href="<?php echo BASE_URL; ?>/documentation?action=api" class="btn btn-sm btn-info" style="width: 100%; margin-top: 8px;">
                <i class="fas fa-terminal"></i> Référence
            </a>
        </div>
    </div>
</div>

<!-- Quick Links Section -->
<div class="chart-card" style="margin-top: 32px;">
    <div class="chart-header">
        <h3><i class="fas fa-link"></i> Accès rapide aux modules</h3>
    </div>
    <div class="chart-content">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(150px, 1fr)); gap: 12px;">
            <a href="<?php echo BASE_URL; ?>/dashboard" class="btn btn-outline-primary" style="display: flex; flex-direction: column; align-items: center; padding: 20px; height: auto;">
                <i class="fas fa-tachometer-alt" style="font-size: 24px; margin-bottom: 8px;"></i>
                <span>Tableau de bord</span>
            </a>
            <a href="<?php echo BASE_URL; ?>/members" class="btn btn-outline-primary" style="display: flex; flex-direction: column; align-items: center; padding: 20px; height: auto;">
                <i class="fas fa-users" style="font-size: 24px; margin-bottom: 8px;"></i>
                <span>Membres</span>
            </a>
            <a href="<?php echo BASE_URL; ?>/events" class="btn btn-outline-primary" style="display: flex; flex-direction: column; align-items: center; padding: 20px; height: auto;">
                <i class="fas fa-calendar" style="font-size: 24px; margin-bottom: 8px;"></i>
                <span>Événements</span>
            </a>
            <a href="<?php echo BASE_URL; ?>/projects" class="btn btn-outline-primary" style="display: flex; flex-direction: column; align-items: center; padding: 20px; height: auto;">
                <i class="fas fa-project-diagram" style="font-size: 24px; margin-bottom: 8px;"></i>
                <span>Projets</span>
            </a>
            <a href="<?php echo BASE_URL; ?>/donations" class="btn btn-outline-primary" style="display: flex; flex-direction: column; align-items: center; padding: 20px; height: auto;">
                <i class="fas fa-donate" style="font-size: 24px; margin-bottom: 8px;"></i>
                <span>Dons</span>
            </a>
            <a href="<?php echo BASE_URL; ?>/search" class="btn btn-outline-primary" style="display: flex; flex-direction: column; align-items: center; padding: 20px; height: auto;">
                <i class="fas fa-search" style="font-size: 24px; margin-bottom: 8px;"></i>
                <span>Recherche</span>
            </a>
        </div>
    </div>
</div>

<!-- Information Box -->
<div class="alert-item" style="margin-top: 32px;">
    <div style="padding: 20px;">
        <h4><i class="fas fa-info-circle"></i> À propos de cette documentation</h4>
        <p style="margin: 12px 0; color: var(--text-secondary);">
            Cette documentation est intégrée directement dans le système pour un accès facile et rapide. 
            Elle est automatiquement mise à jour avec les nouvelles versions du système.
        </p>
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px; margin-top: 16px;">
            <div>
                <strong><i class="fas fa-calendar-alt"></i> Dernière mise à jour</strong>
                <p style="color: var(--text-secondary);"><?php echo date('d/m/Y'); ?></p>
            </div>
            <div>
                <strong><i class="fas fa-code-branch"></i> Version système</strong>
                <p style="color: var(--text-secondary);">1.0</p>
            </div>
            <div>
                <strong><i class="fas fa-database"></i> Base de données</strong>
                <p style="color: var(--text-secondary);">PostgreSQL / MySQL</p>
            </div>
        </div>
    </div>
</div>
        
