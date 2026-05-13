<?= $this->extend('layouts/employe') ?>

<?= $this->section('content') ?>
<div class="topbar">
  <div>
    <div class="topbar-title">Nouvelle demande de congé</div>
    <div class="topbar-breadcrumb">
      <a href="<?= base_url('employe/dashboard') ?>">Accueil</a>
      <i class="bi bi-chevron-right" style="font-size:.6rem"></i> Nouvelle demande
    </div>
  </div>
</div>

<div class="content">
  <!-- Début du Formulaire CI4 -->
  <form action="<?= base_url('employe/conges/create') ?>" method="POST">
    <?= csrf_field() ?>

    <div style="display:grid;grid-template-columns:1fr 300px;gap:1.5rem;align-items:start" class="form-layout">

      <!-- Formulaire principal -->
      <div>
        <div class="form-section">
          <h3>Détails de la demande</h3>

          <!-- Type de congé -->
          <div class="f-group" style="margin-bottom:1rem">
            <label class="f-label">Type de congé <span style="color:var(--danger)">*</span></label>
            <select name="type_conge_id" class="f-select <?= isset($errors['type_conge_id']) ? 'is-invalid' : '' ?>" required>
              <option value="">-- Choisir un type --</option>
              <?php foreach($types as $t): ?>
                <option value="<?= $t['id'] ?>" <?= old('type_conge_id') == $t['id'] ? 'selected' : '' ?>>
                    <?= esc($t['libelle']) ?> 
                    (<?= $t['jours_restants'] ?? '?' ?> j restants)
                </option>
              <?php endforeach; ?>
            </select>
            <?php if(isset($errors['type_conge_id'])): ?>
                <div class="f-error"><i class="bi bi-exclamation-circle"></i> <?= $errors['type_conge_id'] ?></div>
            <?php endif; ?>
          </div>

          <!-- Dates -->
          <div class="form-grid-2" style="margin-bottom:1rem">
            <div class="f-group">
              <label class="f-label">Date de début <span style="color:var(--danger)">*</span></label>
              <input type="date" name="date_debut" class="f-input" value="<?= old('date_debut') ?>" required/>
            </div>
            <div class="f-group">
              <label class="f-label">Date de fin <span style="color:var(--danger)">*</span></label>
              <input type="date" name="date_fin" class="f-input" value="<?= old('date_fin') ?>" required/>
            </div>
          </div>

          <!-- Motif -->
          <div class="f-group" style="margin-bottom:1rem">
            <label class="f-label">Motif (optionnel)</label>
            <textarea name="motif" class="f-textarea" placeholder="Précisez le motif de votre demande si nécessaire..."><?= old('motif') ?></textarea>
            <div class="f-hint">Le motif est visible par le responsable RH.</div>
          </div>

          <div class="form-actions">
            <button class="btn-forest" type="submit"><i class="bi bi-send"></i> Soumettre la demande</button>
            <a href="<?= base_url('employe/dashboard') ?>" class="btn-secondary"><i class="bi bi-x"></i> Annuler</a>
          </div>
        </div>
      </div>

      <!-- Panneau latéral : solde & règles -->
      <div style="display:flex;flex-direction:column;gap:1rem">
        <div class="data-card" style="margin:0">
          <div class="data-card-head">
            <h3><i class="bi bi-piggy-bank" style="color:var(--forest);margin-right:5px"></i>Vos soldes actuels</h3>
          </div>
          <div style="padding:.75rem 1.1rem;display:flex;flex-direction:column;gap:.75rem">
            <?php foreach($soldes as $s): ?>
            <div>
              <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4px">
                <span style="font-size:.8rem;color:var(--ink)"><?= esc($s['libelle']) ?></span>
                <span style="font-family:'DM Mono',monospace;font-size:.8rem;color:var(--forest);font-weight:500">
                    <?= $s['jours_restants'] ?> j
                </span>
              </div>
              <div class="solde-bar">
                <!-- Calcul de la barre de progression (exemple : jours restants / jours attribués) -->
                <?php $percent = ($s['jours_attribues'] > 0) ? ($s['jours_restants'] / $s['jours_attribues']) * 100 : 0; ?>
                <div class="solde-fill <?= $percent < 20 ? 'warn' : '' ?>" style="width:<?= $percent ?>%"></div>
              </div>
            </div>
            <?php endforeach; ?>
          </div>
        </div>

        <div class="flash flash-info" style="margin:0">
          <i class="bi bi-info-circle-fill"></i>
          <span style="font-size:.8rem">Le solde est déduit uniquement à l'approbation de votre responsable.</span>
        </div>

        <div style="background:var(--cream);border:1px solid var(--border);border-radius:8px;padding:.85rem 1rem">
          <div style="font-size:.78rem;font-weight:500;color:var(--ink);margin-bottom:.5rem">
            <i class="bi bi-clipboard-check" style="color:var(--forest);margin-right:5px"></i>Rappel des règles
          </div>
          <ul style="margin:0;padding-left:1rem;font-size:.75rem;color:var(--muted);line-height:1.7">
            <li>Préavis minimum : 48h avant la date de début</li>
            <li>Pas de chevauchement avec une demande en cours</li>
            <li>Solde insuffisant = demande refusée automatiquement</li>
          </ul>
        </div>
      </div>

    </div>
  </form>
</div>
<?= $this->endSection() ?>