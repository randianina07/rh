<?= $this->extend('rh/layout') ?>

<?= $this->section('content') ?>

<div class="row mb-4">
  <div class="col-12">
    <h2>Tableau de bord RH</h2>
    <p class="text-muted">Résumé des demandes et des présences</p>
  </div>
</div>

<div class="row g-3 mb-4">
  <div class="col-sm-6 col-md-3">
    <div class="card card-stat p-3">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h6>En attente</h6>
          <h3><?= esc($nb_en_attente ?? 0) ?></h3>
        </div>
        <div class="text-end">
          <small class="text-muted">Demandes</small>
        </div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-md-3">
    <div class="card card-stat p-3">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h6>Acceptées</h6>
          <h3><?= esc($nb_accepte ?? 0) ?></h3>
        </div>
        <div class="text-end"><small class="text-muted">Demandes</small></div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-md-3">
    <div class="card card-stat p-3">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h6>Refusées</h6>
          <h3><?= esc($nb_refuse ?? 0) ?></h3>
        </div>
        <div class="text-end"><small class="text-muted">Demandes</small></div>
      </div>
    </div>
  </div>

  <div class="col-sm-6 col-md-3">
    <div class="card card-stat p-3">
      <div class="d-flex justify-content-between align-items-center">
        <div>
          <h6>Absents</h6>
          <h3><?= esc($nb_absents ?? 0) ?></h3>
        </div>
        <div class="text-end"><small class="text-muted">Aujourd'hui</small></div>
      </div>
    </div>
  </div>
</div>

<div class="row">
  <div class="col-12">
    <div class="card">
      <div class="card-header">
        <strong>Demandes en attente</strong>
      </div>
      <div class="card-body p-0">
            <div class="p-3">
              <form method="get" class="row g-3 mb-3">
                <div class="col-md-4">
                  <label class="form-label">Département</label>
                  <select name="departement" class="form-select">
                    <option value="">-- Tous --</option>
                    <?php if (!empty($departements)): foreach ($departements as $d): ?>
                      <option value="<?= esc($d->id) ?>"><?= esc($d->nom) ?></option>
                    <?php endforeach; endif ?>
                  </select>
                </div>

                <div class="col-md-4">
                  <label class="form-label">Statut</label>
                  <select name="statut" class="form-select">
                    <option value="">-- Tous --</option>
                    <option value="en_attente">En attente</option>
                    <option value="accepte">Accepté</option>
                    <option value="refuse">Refusé</option>
                  </select>
                </div>

                <div class="col-md-4 d-flex align-items-end">
                  <button class="btn btn-primary me-2">Filtrer</button>
                  <a class="btn btn-outline-secondary" href="<?= site_url('rh') ?>">Annuler</a>
                </div>
              </form>

              <div class="table-responsive">
          <table class="table table-striped mb-0">
            <thead>
              <tr>
                <th>ID</th>
                <th>Employé</th>
                <th>Type</th>
                <th>Début</th>
                <th>Fin</th>
                <th>Nb jours</th>
                <th>Motif</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (!empty($en_attente)): ?>
                <?php foreach ($en_attente as $d): ?>
                  <tr>
                    <td><?= esc($d->id) ?></td>
                    <td><?= esc($d->prenom . ' ' . $d->nom) ?></td>
                    <td><?= esc($d->libelle ?? '') ?></td>
                    <td><?= esc($d->date_debut) ?></td>
                    <td><?= esc($d->date_fin) ?></td>
                    <td><?= esc($d->nb_jours) ?></td>
                    <td><?= esc($d->motif) ?></td>
                    <td>
                      <a href="<?= site_url('rh/conges/'.$d->id) ?>" class="btn btn-sm btn-info">Détails</a>
                      <form method="post" action="<?= site_url('rh/conges/approuver/'.$d->id) ?>" class="d-inline">
                        <button class="btn btn-sm btn-success">Approuver</button>
                      </form>
                      <form method="post" action="<?= site_url('rh/conges/refuser/'.$d->id) ?>" class="d-inline">
                        <button class="btn btn-sm btn-danger">Refuser</button>
                      </form>
                    </td>
                  </tr>
                <?php endforeach ?>
              <?php else: ?>
                <tr><td colspan="8" class="text-center py-3">Aucune demande en attente.</td></tr>
              <?php endif ?>
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
</div>

<?= $this->endSection() ?>
