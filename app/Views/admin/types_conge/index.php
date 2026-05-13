<?php $this->extend('admin/layout'); ?>
<?php $this->section('content'); ?>

<div style="display: grid; grid-template-columns: 1fr 380px; gap: 20px; align-items: start;">

    <div class="card">
        <div class="card-title">📋 Types de congé (<?= count($types) ?>)</div>
        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Libellé</th>
                    <th>Jours annuels</th>
                    <th>Déductible</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($types)): ?>
                    <tr><td colspan="5" class="text-muted" style="text-align:center;padding:24px;">Aucun type de congé.</td></tr>
                <?php else: ?>
                    <?php foreach ($types as $t): ?>
                        <tr>
                            <td style="color:var(--muted)">#<?= $t['id'] ?></td>
                            <td><strong><?= esc($t['libelle']) ?></strong></td>
                            <td><?= $t['jours_annuels'] ?> jours</td>
                            <td>
                                <?php if ($t['deductible']): ?>
                                    <span class="badge badge-approuvee">Oui</span>
                                <?php else: ?>
                                    <span class="badge badge-inactif">Non</span>
                                <?php endif; ?>
                            </td>
                            <td>
                                <form method="post" action="<?= base_url("admin/types-conge/delete/{$t['id']}") ?>"
                                      onsubmit="return confirm('Supprimer ce type de congé ?')">
                                    <?= csrf_field() ?>
                                    <button class="btn btn-danger btn-sm">🗑️ Supprimer</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>

    <div class="card">
        <div class="card-title">➕ Nouveau type de congé</div>
        <form method="post" action="<?= base_url('admin/types-conge/create') ?>">
            <?= csrf_field() ?>
            <div class="form-group">
                <label class="form-label">Libellé *</label>
                <input type="text" name="libelle" class="form-control"
                       value="<?= esc(old('libelle')) ?>" required placeholder="Ex : Congé payé">
                <?php if (isset($validation) && $validation->hasError('libelle')): ?>
                    <div class="validation-error"><?= $validation->getError('libelle') ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label class="form-label">Jours annuels *</label>
                <input type="number" name="jours_annuels" class="form-control"
                       value="<?= esc(old('jours_annuels')) ?>" required min="1" placeholder="Ex : 30">
                <?php if (isset($validation) && $validation->hasError('jours_annuels')): ?>
                    <div class="validation-error"><?= $validation->getError('jours_annuels') ?></div>
                <?php endif; ?>
            </div>
            <div class="form-group">
                <label class="form-label">Déductible du solde ? *</label>
                <select name="deductible" class="form-control" required>
                    <option value="1" <?= old('deductible') === '1' ? 'selected' : '' ?>>Oui</option>
                    <option value="0" <?= old('deductible') === '0' ? 'selected' : '' ?>>Non</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%;">✅ Créer</button>
        </form>
    </div>

</div>

<?php $this->endSection(); ?>