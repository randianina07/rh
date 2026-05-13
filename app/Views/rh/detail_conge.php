<?= $this->extend('rh/layout') ?>

<?= $this->section('content') ?>

<div class="row mb-3">
  <div class="col-8">
    <h3>Détail de la demande #<?= esc($conge->id ?? '') ?></h3>
  </div>
  <div class="col-4 text-end">
    <a href="<?= site_url('rh/conges') ?>" class="btn btn-secondary">Retour</a>
  </div>
</div>

<div class="card">
  <div class="card-body">
    <?php if (!empty($conge)): ?>
      <p><strong>Employé :</strong> <?= esc($conge->prenom . ' ' . $conge->nom) ?></p>
      <p><strong>Type :</strong> <?= esc($conge->libelle) ?></p>
      <p><strong>Période :</strong> <?= esc($conge->date_debut) ?> — <?= esc($conge->date_fin) ?></p>
      <p><strong>Nb jours :</strong> <?= esc($conge->nb_jours) ?></p>
      <p><strong>Motif :</strong> <?= esc($conge->motif) ?></p>
      <p><strong>Statut :</strong> <?= esc($conge->statut) ?></p>

      <?php if ($conge->statut == 'en_attente'): ?>
        <p class="text-muted">Un commentaire est requis pour approuver la demande. Pour refuser, le commentaire est optionnel mais recommandé.</p>
        <form method="post" action="<?= site_url('rh/conges/approuver/'.$conge->id) ?>" class="mb-2">
          <div class="mb-2">
            <label>Commentaire (requis)</label>
            <textarea name="commentaire" class="form-control" required></textarea>
          </div>
          <button class="btn btn-success">Approuver</button>
        </form>

        <form method="post" action="<?= site_url('rh/conges/refuser/'.$conge->id) ?>">
          <div class="mb-2">
            <label>Commentaire (optionnel)</label>
            <textarea name="commentaire" class="form-control"></textarea>
          </div>
          <button class="btn btn-danger">Refuser</button>
        </form>
      <?php endif ?>

    <?php else: ?>
      <p>Aucune donnée trouvée pour cette demande.</p>
    <?php endif ?>
  </div>
</div>

<?= $this->endSection() ?>
