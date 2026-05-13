<?php $this->extend('admin/layout'); ?>
<?php $this->section('content'); ?>

<div class="card" style="padding: 16px 20px; margin-bottom: 16px;">
    <form method="get" action="<?= base_url('admin/historique') ?>" class="flex gap-2 items-center flex-wrap">
        <select name="statut" class="form-control" style="width:160px;">
            <option value="">Tous les statuts</option>
            <?php foreach (['en_attente', 'approuvee', 'refusee', 'annulee'] as $s): ?>
                <option value="<?= $s ?>" <?= $statut === $s ? 'selected' : '' ?>>
                    <?= ucfirst(str_replace('_', ' ', $s)) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <select name="departement_id" class="form-control" style="width:180px;">
            <option value="">Tous les départements</option>
            <?php foreach ($departements as $dep): ?>
                <option value="<?= $dep['id'] ?>" <?= (int)$departement_id === (int)$dep['id'] ? 'selected' : '' ?>>
                    <?= esc($dep['nom']) ?>
                </option>
            <?php endforeach; ?>
        </select>

        <button type="submit" class="btn btn-primary">🔍 Filtrer</button>
        <a href="<?= base_url('admin/historique') ?>" class="btn btn-ghost">✕ Réinitialiser</a>
    </form>
</div>

<div class="card">
    <div class="card-title">📜 Historique des demandes (<?= count($conges) ?>)</div>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Employé</th>
                <th>Département</th>
                <th>Type</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Jours</th>
                <th>Statut</th>
                <th>Traité par</th>
                <th>Commentaire RH</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($conges)): ?>
                <tr>
                    <td colspan="10" class="text-muted" style="text-align:center;padding:24px;">
                        Aucune demande trouvée.
                    </td>
                </tr>
            <?php else: ?>
                <?php foreach ($conges as $c): ?>
                    <tr>
                        <td style="color:var(--muted)">#<?= $c['id'] ?></td>
                        <td><strong><?= esc($c['prenom'] . ' ' . $c['nom']) ?></strong></td>
                        <td class="text-muted"><?= esc($c['departement_nom'] ?? '—') ?></td>
                        <td><?= esc($c['type_libelle']) ?></td>
                        <td><?= date('d/m/Y', strtotime($c['date_debut'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($c['date_fin'])) ?></td>
                        <td><?= $c['nb_jours'] ?> j</td>
                        <td>
                            <span class="badge badge-<?= $c['statut'] ?>">
                                <?= ucfirst(str_replace('_', ' ', $c['statut'])) ?>
                            </span>
                        </td>
                        <td class="text-muted">
                            <?= $c['rh_prenom'] ? esc($c['rh_prenom'] . ' ' . $c['rh_nom']) : '—' ?>
                        </td>
                        <td class="text-muted" style="max-width:180px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;"
                            title="<?= esc($c['commentaire_rh'] ?? '') ?>">
                            <?= esc($c['commentaire_rh'] ?? '—') ?>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php $this->endSection(); ?>