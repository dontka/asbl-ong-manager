<?php $pageTitle = 'Modifier un Membre'; ?>

<div class="nav-container">
    <div class="nav-left">
        <h1><i class="fas fa-user-edit"></i> Modifier un Membre</h1>
        <p class="nav-date">Mettre à jour les informations de <?php echo htmlspecialchars($member['first_name'] . ' ' . $member['last_name']); ?></p>
    </div>
    <div class="nav-actions">
        <a href="<?php echo BASE_URL; ?>/members" class="btn btn-secondary">
            <i class="fas fa-arrow-left"></i> Retour à la liste
        </a>
    </div>
</div>

<div class="chart-card" style="max-width: 700px; margin: 0 auto;">
    <div class="chart-header">
        <h3>Modifier les informations</h3>
    </div>
    <div class="chart-content">
        <form action="/members" method="post" data-validate>
            <input type="hidden" name="action" value="update">
            <input type="hidden" name="id" value="<?php echo $member['id']; ?>">

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="first_name" class="form-label">Prénom *</label>
                                <input type="text" class="form-control" id="first_name" name="first_name" value="<?php echo htmlspecialchars($member['first_name']); ?>" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="last_name" class="form-label">Nom *</label>
                                <input type="text" class="form-control" id="last_name" name="last_name" value="<?php echo htmlspecialchars($member['last_name']); ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="email" class="form-label">Email *</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo htmlspecialchars($member['email']); ?>" required>
                        <div class="form-text">L'email doit être unique.</div>
                    </div>

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="phone" class="form-label">Téléphone</label>
                                <input type="tel" class="form-control" id="phone" name="phone" value="<?php echo htmlspecialchars($member['phone'] ?? ''); ?>">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="join_date" class="form-label">Date d'adhésion *</label>
                                <input type="date" class="form-control" id="join_date" name="join_date" value="<?php echo $member['join_date']; ?>" required>
                            </div>
                        </div>
                    </div>

                    <div class="form-group">
                        <label for="address" class="form-label">Adresse</label>
                        <textarea class="form-control" id="address" name="address" rows="3"><?php echo htmlspecialchars($member['address'] ?? ''); ?></textarea>
                    </div>

                    <div class="form-group">
                        <label for="status" class="form-label">Statut *</label>
                        <select class="form-control" id="status" name="status" required>
                            <option value="active" <?php echo $member['status'] === 'active' ? 'selected' : ''; ?>>Actif</option>
                            <option value="inactive" <?php echo $member['status'] === 'inactive' ? 'selected' : ''; ?>>Inactif</option>
                        </select>
                    </div>

                    <div class="form-group" style="display: flex; gap: 8px; margin-top: 24px;">
                        <button type="submit" class="btn btn-primary" style="flex: 1;">
                            <i class="fas fa-check"></i> Mettre à jour
                        </button>
                        <a href="<?php echo BASE_URL; ?>/members" class="btn btn-secondary" style="flex: 1; text-align: center;">
                            <i class="fas fa-times"></i> Annuler
                        </a>
                    </div>
        </form>
    </div>
</div>