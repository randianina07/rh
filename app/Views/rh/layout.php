<!doctype html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= isset($title) ? esc($title) : 'RH Dashboard' ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {min-height:100vh;}
        .sidebar {min-height:100vh; background:#f8f9fa;}
        .card-stat {min-height:80px}
        .nav-link.active {font-weight:600}
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">RH - Gestion</a>
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
      <?= $this->include('rh/sidebar') ?>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
