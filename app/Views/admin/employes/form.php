<?php $this->extend('admin/layout'); ?>
<?php $this->section('content'); ?>

<?php $isEdit = isset($employe); ?>

<div class="flex items-center justify-between mb-4">
    <a href="<?= base_url('admin/employes') ?>" class="btn btn-ghost btn-sm">← Retour</a>
</div>

<div class="card" style="max-width: 700px;">
    <div class="card-title"><?= $isEdit ? '✏️ Modifier l\'employé' : '➕ Créer un employé' ?></div>

    <form method="post" action="<?= $isEdit
        ? base_url("admin/employes/update/{$employe['id']}")
        : base_url('admin/employes/create') ?>">
        <?= csrf_field() ?>

        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Prénom *</label>
                <input type="text" name="prenom" class="form-control"
                       value="<?= esc(old('prenom', $employe['prenom'] ?? '')) ?>" required>
                <?php if ($validation->hasError('prenom')): ?>
                    <div class="validation-error"><?= $validation->getError('prenom') ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label class="form-label">Nom *</label>
                <input type="text" name="nom" class="form-control"
                       value="<?= esc(old('nom', $employe['nom'] ?? '')) ?>" required>
                <?php if ($validation->hasError('nom')): ?>
                    <div class="validation-error"><?= $validation->getError('nom') ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-group">
            <label class="form-label">Email *</label>
            <input type="email" name="email" class="form-control"
                   value="<?= esc(old('email', $employe['email'] ?? '')) ?>" required>
            <?php if ($validation->hasError('email')): ?>
                <div class="validation-error"><?= $validation->getError('email') ?></div>
            <?php endif; ?>
        </div>

        <div class="form-group">
            <label class="form-label"><?= $isEdit ? 'Nouveau mot de passe (laisser vide = inchangé)' : 'Mot de passe *' ?></label>
            <input type="password" name="password" class="form-control"
                   <?= $isEdit ? '' : 'required' ?> minlength="8"
                   placeholder="<?= $isEdit ? 'Laisser vide pour ne pas changer' : 'Min. 8 caractères' ?>">
            <?php if ($validation->hasError('password')): ?>
                <div class="validation-error"><?= $validation->getError('password') ?></div>
            <?php endif; ?>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Rôle *</label>
                <select name="role" class="form-control" required>
                    <option value="">Choisir…</option>
                    <?php foreach (['employe', 'rh', 'admin'] as $r): ?>
                        <option value="<?= $r ?>" <?= old('role', $employe['role'] ?? '') === $r ? 'selected' : '' ?>>
                            <?= ucfirst($r) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if ($validation->hasError('role')): ?>
                    <div class="validation-error"><?= $validation->getError('role') ?></div>
                <?php endif; ?>
            </div>

            <div class="form-group">
                <label class="form-label">Département *</label>
                <select name="departement_id" class="form-control" required>
                    <option value="">Choisir…</option>
                    <?php foreach ($departements as $dep): ?>
                        <option value="<?= $dep['id'] ?>"
                            <?= (int)old('departement_id', $employe['departement_id'] ?? 0) === (int)$dep['id'] ? 'selected' : '' ?>>
                            <?= esc($dep['nom']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <?php if ($validation->hasError('departement_id')): ?>
                    <div class="validation-error"><?= $validation->getError('departement_id') ?></div>
                <?php endif; ?>
            </div>
        </div>

        <div class="form-grid">
            <div class="form-group">
                <label class="form-label">Date d'embauche *</label>
                <input type="date" name="date_embauche" class="form-control"
                       value="<?= esc(old('date_embauche', $employe['date_embauche'] ?? '')) ?>" required>
                <?php if ($validation->hasError('date_embauche')): ?>
                    <div class="validation-error"><?= $validation->getError('date_embauche') ?></div>
                <?php endif; ?>
            </div>

            <?php if ($isEdit): ?>
                <div class="form-group">
                    <label class="form-label">Statut</label>
                    <select name="actif" class="form-control">
                        <option value="1" <?= ($employe['actif'] ?? 1) ? 'selected' : '' ?>>Actif</option>
                        <option value="0" <?= !($employe['actif'] ?? 1) ? 'selected' : '' ?>>Inactif</option>
                    </select>
                </div>
            <?php endif; ?>
        </div>

        <div class="flex gap-2" style="margin-top: 8px;">
            <button type="submit" class="btn btn-primary">
                <?= $isEdit ? '💾 Enregistrer' : '✅ Créer l\'employé' ?>
            </button>
            <a href="<?= base_url('admin/employes') ?>" class="btn btn-ghost">Annuler</a>
        </div>
    </form>
</div>

<?php $this->endSection(); ?>