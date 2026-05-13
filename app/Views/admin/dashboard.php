<?php $this->extend('admin/layout'); ?>
<?php $this->section('content'); ?>

<div class="stats-grid">
    <div class="stat-card warning">
        <div class="stat-label">En attente</div>
        <div class="stat-value"><?= $stats['en_attente'] ?></div>
        <div class="text-muted">demandes à traiter</div>
    </div>
    <div class="stat-card success">
        <div class="stat-label">Approuvées</div>
        <div class="stat-value"><?= $stats['approuvees'] ?></div>
        <div class="text-muted">cette année</div>
    </div>
    <div class="stat-card danger">
        <div class="stat-label">Refusées</div>
        <div class="stat-value"><?= $stats['refusees'] ?></div>
        <div class="text-muted">cette année</div>
    </div>
    <div class="stat-card accent">
        <div class="stat-label">Employés actifs</div>
        <div class="stat-value"><?= $nb_employes ?></div>
        <div class="text-muted"><?= $nb_departs ?> département(s)</div>
    </div>
</div>

<div class="card">
    <div class="card-title">📅 Absences du mois en cours — <?= date('F Y') ?></div>
    <?php if (empty($absences)): ?>
        <p class="text-muted">Aucune absence approuvée ce mois-ci.</p>
    <?php else: ?>
        <table>
            <thead>
                <tr>
                    <th>Employé</th>
                    <th>Type</th>
                    <th>Début</th>
                    <th>Fin</th>
                    <th>Jours</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($absences as $a): ?>
                    <tr>
                        <td><?= esc($a['prenom'] . ' ' . $a['nom']) ?></td>
                        <td><?= esc($a['type_libelle']) ?></td>
                        <td><?= date('d/m/Y', strtotime($a['date_debut'])) ?></td>
                        <td><?= date('d/m/Y', strtotime($a['date_fin'])) ?></td>
                        <td><?= $a['nb_jours'] ?> j</td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</div>

<?php $this->endSection(); ?>