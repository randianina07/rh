<?php $this->extend('admin/layout'); ?>
<?php $this->section('content'); ?>

<div class="flex items-center justify-between mb-4">
    <form method="get" action="<?= base_url('admin/soldes') ?>" class="flex gap-2 items-center">
        <select name="annee" class="form-control" style="width:120px;">
            <?php for ($y = date('Y') + 1; $y >= date('Y') - 3; $y--): ?>
                <option value="<?= $y ?>" <?= $annee == $y ? 'selected' : '' ?>><?= $y ?></option>
            <?php endfor; ?>
        </select>
        <button type="submit" class="btn btn-ghost">🔍 Filtrer</button>
    </form>

    <form method="post" action="<?= base_url('admin/soldes/init') ?>"
          onsubmit="return confirm('Initialiser les soldes pour <?= $annee ?> ? (N\'écrase pas les existants)')">
        <?= csrf_field() ?>
        <input type="hidden" name="annee" value="<?= $annee ?>">
        <button type="submit" class="btn btn-success">⚡ Initialiser soldes <?= $annee ?></button>
    </form>
</div>

<div class="card">
    <div class="card-title">💰 Soldes — Année <?= $annee ?> (<?= count($soldes) ?> entrée(s))</div>
    <table>
        <thead>
            <tr>
                <th>Employé</th>
                <th>Département</th>
                <th>Type de congé</th>
                <th>Attribués</th>
                <th>Pris</th>
                <th>Restants</th>
                <th>Modifier</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($soldes)): ?>
                <tr>
                    <td colspan="7" class="text-muted" style="text-align:center;padding:24px;">
                        Aucun solde pour <?= $annee ?>. Cliquez sur "Initialiser" pour créer les soldes.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($soldes as $s): ?>
                    <tr>
                        <td><strong><?= esc($s['prenom'] . ' ' . $s['nom']) ?></strong></td>
                        <td class="text-muted"><?= esc($s['departement_nom'] ?? '—') ?></td>
                        <td><?= esc($s['libelle']) ?></td>
                        <td><?= $s['jours_attribues'] ?> j</td>
                        <td><?= $s['jours_pris'] ?> j</td>
                        <td>
                            <?php $restants = $s['jours_attribues'] - $s['jours_pris']; ?>
                            <span class="badge <?= $restants > 0 ? 'badge-approuvee' : 'badge-inactif' ?>">
                                <?= $restants ?> j
                            </span>
                        </td>
                        <td>
                            <form method="post" action="<?= base_url("admin/soldes/update/{$s['id']}") ?>"
                                  class="flex gap-2 items-center">
                                <?= csrf_field() ?>
                                <input type="number" name="jours_attribues" class="form-control"
                                       style="width:80px;" value="<?= $s['jours_attribues'] ?>" min="0" required>
                                <button type="submit" class="btn btn-ghost btn-sm">💾</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php $this->endSection(); ?>