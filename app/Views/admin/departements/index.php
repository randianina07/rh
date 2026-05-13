<?php $this->extend('admin/layout'); ?>
<?php $this->section('content'); ?>

<div style="display: grid; grid-template-columns: 1fr 380px; gap: 20px; align-items: start;">

    <div class="card">
        <div class="card-title">🏢 Départements (<?= count($departements) ?>)</div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Nom</th>
                    <th>Description</th>
                    <th>Employés actifs</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($departements)): ?>
                    <tr><td colspan="5" class="text-muted" style="text-align:center;padding:24px;">Aucun département.</td></tr>
                <?php else: ?>
                    <?php foreach ($departements as $dep): ?>
                        <tr>
                            <td style="color:var(--muted)">#<?= $dep['id'] ?></td>
                            <td><strong><?= esc($dep['nom']) ?></strong></td>
                            <td class="text-muted"><?= esc($dep['description'] ?? '—') ?></td>
                            <td>
                                <span class="badge badge-employe"><?= $dep['nb_employes'] ?> employé(s)</span>
                            </td>
                            <td>
                                <?php if ($dep['nb_employes'] == 0): ?>
                                    <form method="post" action="<?= base_url("admin/departements/delete/{$dep['id']}") ?>"
                                          onsubmit="return confirm('Supprimer ce département ?')">
                                        <?= csrf_field() ?>
                                        <button class="btn btn-danger btn-sm">🗑️ Supprimer</button>
                                    </form>
                                <?php else: ?>
                                    <span class="text-muted" style="font-size:12px;">Non supprimable</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="card">
        <div class="card-title">➕ Nouveau département</div>
        <form method="post" action="<?= base_url('admin/departements/create') ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="form-label">Nom *</label>
                <input type="text" name="nom" class="form-control"
                       value="<?= esc(old('nom')) ?>" required placeholder="Ex : Informatique">
                <?php if (isset($validation) && $validation->hasError('nom')): ?>
                    <div class="validation-error"><?= $validation->getError('nom') ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label class="form-label">Description</label>
                <input type="text" name="description" class="form-control"
                       value="<?= esc(old('description')) ?>" placeholder="Optionnel">
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">✅ Créer</button>
        </form>
    </div>

</div>

<?php $this->endSection(); ?>