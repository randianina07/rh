<?= $this->extend('rh/layout') ?>

<?= $this->section('content') ?>

<div class="row mb-3">
  <div class="col-12 d-flex justify-content-between align-items-center">
    <h3>Liste des congés</h3>
    <a href="<?= site_url('rh/conges') ?>" class="btn btn-secondary">Réinitialiser</a>
  </div>
</div>

<form method="get" class="row g-3 mb-3">
  <div class="col-md-4">
    <label class="form-label">Département</label>
    <select name="departement" class="form-select">
      <option value="">-- Tous --</option>
      <?php foreach ($departements as $d): ?>
        <option value="<?= esc($d->id) ?>" <?= ($selected_departement == $d->id) ? 'selected' : '' ?>><?= esc($d->nom) ?></option>
      <?php endforeach ?>
    </select>
  </div>

  <div class="col-md-4">
    <label class="form-label">Statut</label>
    <select name="statut" class="form-select">
      <option value="">-- Tous --</option>
      <option value="en_attente" <?= ($selected_statut == 'en_attente') ? 'selected' : '' ?>>En attente</option>
      <option value="accepte" <?= ($selected_statut == 'accepte') ? 'selected' : '' ?>>Accepté</option>
      <option value="refuse" <?= ($selected_statut == 'refuse') ? 'selected' : '' ?>>Refusé</option>
    </select>
  </div>

  <div class="col-md-4 d-flex align-items-end">
    <button class="btn btn-primary me-2">Filtrer</button>
    <a class="btn btn-outline-secondary" href="<?= site_url('rh/conges') ?>">Annuler</a>
  </div>
</form>

<div class="table-responsive">
  <table class="table table-striped">
    <thead>
      <tr>
        <th>ID</th>
        <th>Employé</th>
        <th>Département</th>
        <th>Type</th>
        <th>Début</th>
        <th>Fin</th>
        <th>Statut</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if (!empty($conges)): foreach ($conges as $c): ?>
        <tr>
          <td><?= esc($c->id) ?></td>
          <td><?= esc($c->prenom . ' ' . $c->nom) ?></td>
          <td><?= esc($c->departement_id) ?></td>
          <td><?= esc($c->libelle) ?></td>
          <td><?= esc($c->date_debut) ?></td>
          <td><?= esc($c->date_fin) ?></td>
          <td><?= esc($c->statut) ?></td>
          <td>
            <a class="btn btn-sm btn-info" href="<?= site_url('rh/conges/'.$c->id) ?>">Détails</a>
            <?php if ($c->statut == 'en_attente'): ?>
              <a class="btn btn-sm btn-success" href="<?= site_url('rh/conges/'.$c->id) ?>">Approuver / Refuser</a>
            <?php endif ?>
          </td>
        </tr>
      <?php endforeach; else: ?>
        <tr><td colspan="8" class="text-center">Aucun congé trouvé.</td></tr>
      <?php endif ?>
    </tbody>
  </table>
</div>

<?= $this->endSection() ?>
