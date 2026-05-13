<div class="px-3">
  <h5>Menu RH</h5>
  <ul class="nav flex-column">
    <li class="nav-item"><a class="nav-link <?= uri_string()==='rh' ? 'active' : '' ?>" href="<?= site_url('rh') ?>">Tableau de bord</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= site_url('rh/conges') ?>">Demandes de congé</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= site_url('rh/soldes') ?>">Soldes</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= site_url('rh/types') ?>">Types de congé</a></li>
    <li class="nav-item"><a class="nav-link" href="<?= site_url('rh/departements') ?>">Départements</a></li>
  </ul>

  <hr>
  <div>
    <small class="text-muted">Utilisateur: <?= esc(session()->get('username') ?? 'RH') ?></small>
  </div>
</div>
