<?php
// Layout partagé pour admin, rh et employe
$role = $role ?? 'rh';
$sidebar = $sidebar ?? ($role === 'admin' ? 'admin/sidebar' : ($role === 'rh' ? 'rh/sidebar' : 'employe/sidebar'));
?>
<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? esc($title) : 'RH Dashboard' ?></title>

    <?php if ($role === 'admin'): ?>
        <style>
            /* Copie réduite du thème admin (variables et structure principales) */
            *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
            :root {
                --bg:        #0f1117;
                --surface:   #1a1d27;
                --border:    #2a2d3a;
                --accent:    #6c63ff;
                --accent2:   #00d4aa;
                --danger:    #ff4d6d;
                --warning:   #ffb347;
                --text:      #e2e4ef;
                --muted:     #7a7f99;
                --sidebar-w: 240px;
            }
            body { font-family: 'Segoe UI', system-ui, sans-serif; background: var(--bg); color: var(--text); display: flex; min-height: 100vh; font-size: 14px; }
            .sidebar { width: var(--sidebar-w); background: var(--surface); border-right: 1px solid var(--border); display: flex; flex-direction: column; position: fixed; top: 0; left: 0; bottom: 0; z-index: 100; }
            .sidebar-logo { padding: 20px 20px 16px; border-bottom: 1px solid var(--border); }
            .sidebar-logo .brand { font-size: 16px; font-weight: 700; color: var(--accent); }
            .sidebar-badge { display: inline-block; background: var(--accent); color: #fff; font-size: 9px; font-weight: 700; padding: 2px 6px; border-radius: 20px; margin-top: 6px; }
            .sidebar nav { flex: 1; padding: 12px 0; overflow-y: auto; }
            .nav-section { padding: 8px 16px 4px; font-size: 10px; text-transform: uppercase; color: var(--muted); font-weight: 600; }
            .sidebar nav a { display: flex; align-items: center; gap: 10px; padding: 9px 20px; color: var(--muted); text-decoration: none; font-size: 13.5px; transition: all .15s; border-left: 3px solid transparent; }
            .sidebar nav a:hover, .sidebar nav a.active { color: var(--text); background: rgba(108,99,255,.08); border-left-color: var(--accent); }
            .sidebar-footer { padding: 16px 20px; border-top: 1px solid var(--border); font-size: 12px; color: var(--muted); }
            .main { margin-left: var(--sidebar-w); flex: 1; display: flex; flex-direction: column; }
            .topbar { background: var(--surface); border-bottom: 1px solid var(--border); padding: 14px 28px; display: flex; align-items: center; justify-content: space-between; position: sticky; top: 0; z-index: 50; }
            .content { padding: 28px; flex: 1; }
            .alert { padding: 12px 16px; border-radius: 8px; margin-bottom: 20px; font-size: 13.5px; display: flex; align-items: center; gap: 10px; }
            .alert-success { background: rgba(0,212,170,.1); border: 1px solid rgba(0,212,170,.3); color: var(--accent2); }
            .alert-error   { background: rgba(255,77,109,.1); border: 1px solid rgba(255,77,109,.3); color: var(--danger); }
        </style>
    <?php else: ?>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
        <style>
            body { min-height: 100vh; }
            .sidebar { min-height:100vh; background:#f8f9fa; }
            .card-stat { min-height:80px }
            .nav-link.active { font-weight:600 }
        </style>
    <?php endif; ?>
</head>
<body>

<?php if ($role === 'admin'): ?>
    <aside class="sidebar">
        <?= $this->include($sidebar) ?>
    </aside>

    <div class="main">
        <div class="topbar">
            <h1><?= esc($title ?? ucfirst($role)) ?></h1>
            <div class="user-info">Bonjour, <span><?= esc(session('prenom') ?? session('username') ?? '') ?></span></div>
        </div>

        <div class="content">
            <?php if (session()->getFlashdata('success')): ?>
                <div class="alert alert-success">✅ <?= esc(session()->getFlashdata('success')) ?></div>
            <?php endif; ?>
            <?php if (session()->getFlashdata('error')): ?>
                <div class="alert alert-error">❌ <?= esc(session()->getFlashdata('error')) ?></div>
            <?php endif; ?>
            <?= $this->renderSection('content') ?>
        </div>
    </div>

<?php else: ?>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"><?= esc(ucfirst($role)) ?> - Gestion</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav ms-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="/logout">Se déconnecter</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<div class="container-fluid">
  <div class="row">
    <aside class="col-md-3 col-lg-2 sidebar py-4">
      <?= $this->include($sidebar) ?>
    </aside>

    <main class="col-md-9 col-lg-10 py-4">
      <div class="container-fluid">
        <?php if (session()->has('message')): ?>
          <div class="alert alert-info"><?= esc(session('message')) ?></div>
        <?php endif ?>

        <?= $this->renderSection('content') ?>
      </div>
    </main>
  </div>
</div>

<?php if ($role !== 'admin'): ?>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
<?php endif; ?>

<?php endif; ?>

</body>
</html>
