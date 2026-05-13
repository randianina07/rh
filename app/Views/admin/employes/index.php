<?php $this->extend('admin/layout'); ?>
<?php $this->section('content'); ?>

<div class="flex items-center justify-between mb-4">
    <p class="text-muted"><?= count($employes) ?> employé(s) enregistré(s)</p>
    <a href="<?= base_url('admin/employes/new') ?>" class="btn btn-primary">+ Nouvel employé</a>
</div>

<div class="card">
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Nom</th>
                <th>Email</th>
                <th>Rôle</th>
                <th>Département</th>
                <th>Embauche</th>
                <th>Statut</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php if (empty($employes)): ?>
                <tr><td colspan="8" class="text-muted" style="text-align:center;padding:24px;">Aucun employé.</td></tr>
            <?php else: ?>
                <?php foreach ($employes as $e): ?>
                    <tr>
                        <td style="color:var(--muted)">#<?= $e['id'] ?></td>
                        <td><strong><?= esc($e['prenom'] . ' ' . $e['nom']) ?></strong></td>
                        <td><?= esc($e['email']) ?></td>
                        <td><span class="badge badge-<?= $e['role'] ?>"><?= $e['role'] ?></span></td>
                        <td><?= esc($e['departement_nom'] ?? '—') ?></td>
                        <td><?= $e['date_embauche'] ? date('d/m/Y', strtotime($e['date_embauche'])) : '—' ?></td>
                        <td>
                            <span class="badge badge-<?= $e['actif'] ? 'actif' : 'inactif' ?>">
                                <?= $e['actif'] ? 'Actif' : 'Inactif' ?>
                            </span>
                        </td>
                        <td>
                            <div class="flex gap-2">
                                <a href="<?= base_url("admin/employes/edit/{$e['id']}") ?>" class="btn btn-ghost btn-sm">✏️ Éditer</a>
                                <form method="post" action="<?= base_url("admin/employes/delete/{$e['id']}") ?>"
                                      onsubmit="return confirm('Désactiver cet employé ?')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-danger btn-sm">🚫 Désactiver</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php $this->endSection(); ?>