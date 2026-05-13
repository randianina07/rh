<?= $this->extend('layouts/employe') ?>

<?= $this->section('content') ?>
<div class="topbar">
  <div>
    <div class="topbar-title">Mes demandes de congé</div>
    <div class="topbar-breadcrumb"><a href="<?= base_url('employe/dashboard') ?>">Accueil</a> <i class="bi bi-chevron-right" style="font-size:.6rem"></i> Mes demandes</div>
  </div>
  <div class="topbar-actions">
    <a href="<?= base_url('employe/conges/new') ?>" class="btn-forest" style="padding:7px 14px;font-size:.82rem"><i class="bi bi-plus-lg"></i> Nouvelle demande</a>
  </div>
</div>

<div class="content">
  <div class="data-card">
    <div class="data-card-head">
      <h3>Toutes mes demandes</h3>
      <div style="display:flex;gap:6px">
        <select class="f-select" style="font-size:.8rem;padding:6px 10px;width:auto">
          <option>Tous les statuts</option>
          <option>En attente</option>
          <option>Approuvée</option>
          <option>Refusée</option>
          <option>Annulée</option>
        </select>
      </div>
    </div>
    
    <table class="tbl">
      <thead>
        <tr><th>Type</th><th>Début</th><th>Fin</th><th>Durée</th><th>Statut</th><th>Commentaire RH</th><th>Action</th></tr>
      </thead>
      <tbody>
        <?php if(!empty($conges)): ?>
            <?php foreach($conges as $c): ?>
            <tr>
              <td><span class="type-badge"><?= esc($c['type_nom']) ?></span></td>
              <td class="td-muted"><?= date('d M Y', strtotime($c['date_debut'])) ?></td>
              <td class="td-muted"><?= date('d M Y', strtotime($c['date_fin'])) ?></td>
              <td class="td-mono"><?= $c['nb_jours'] ?> j</td>
              <td><span class="statut s-<?= $c['statut'] ?>"><?= $c['statut'] ?></span></td>
              <td class="td-muted" style="font-size:.78rem"><?= esc($c['commentaire_rh'] ?? '—') ?></td>
              <td>
                <?php if($c['statut'] === 'en_attente'): ?>
                    <form action="<?= base_url('employe/conges/annuler/'.$c['id']) ?>" method="POST">
                        <button type="submit" class="btn-sm btn-cancel" onclick="return confirm('Annuler cette demande ?')"><i class="bi bi-x"></i> Annuler</button>
                    </form>
                <?php else: ?>
                    <span class="td-muted" style="font-size:.75rem">—</span>
                <?php endif; ?>
              </td>
            </tr>
            <?php endforeach; ?>
        <?php else: ?>
            <tr><td colspan="7" class="text-center">Aucune demande trouvée.</td></tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>
</div>
<?= $this->endSection() ?>