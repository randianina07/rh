<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>TechMada RH — <?= $title ?? 'Espace Employé' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@300;400;500&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
    <link rel="stylesheet" href="<?= base_url('css/style.css') ?>">
</head>
<body>

<div class="app-wrap">

  <aside class="sidebar">
    <div class="sidebar-brand">
      <div class="sidebar-logo-icon"><i class="bi bi-briefcase"></i></div>
      <div class="sidebar-brand-name">TechMada RH<span>Espace employé</span></div>
    </div>
    <ul class="sidebar-nav" style="margin-top:1rem">
      <li><a href="<?= base_url('employe/dashboard') ?>" class="<?= url_is('employe/dashboard') ? 'active' : '' ?>"><i class="bi bi-grid-1x2"></i> Tableau de bord</a></li>
      <li><a href="<?= base_url('employe/conges/new') ?>"><i class="bi bi-plus-circle"></i> Nouvelle demande</a></li>
      <li><a href="<?= base_url('employe/conges') ?>" class="<?= url_is('employe/conges') ? 'active' : '' ?>"><i class="bi bi-calendar3"></i> Mes demandes</a></li>
      <li><a href="<?= base_url('employe/profil') ?>"><i class="bi bi-person"></i> Mon profil</a></li>
    </ul>
    <div class="sidebar-user">
      <div class="s-user-row">
        <div class="avatar av-green"><?= substr(session()->get('nom'), 0, 2) ?></div>
        <div>
            <div class="user-name"><?= session()->get('nom') ?></div>
            <div class="user-role">Employé</div>
        </div>
      </div>
      <a href="<?= base_url('logout') ?>" class="btn-logout" style="display:block; margin-top:10px; color:rgba(255,255,255,0.5); text-decoration:none; font-size:0.8rem;">
        <i class="bi bi-box-arrow-right"></i> Déconnexion
      </a>
    </div>
  </aside>

  <div class="main">
   
    <?= $this->renderSection('content') ?>
    
    <div class="footer-app"><i class="bi bi-c-circle"></i> 2026 <span>TechMada RH</span></div>
  </div>
</div>

</body>
</html>