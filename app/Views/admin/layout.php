<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= esc($title ?? 'Admin') ?> — TechMada RH</title>
    <style>
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

        body {
            font-family: 'Segoe UI', system-ui, sans-serif;
            background: var(--bg);
            color: var(--text);
            display: flex;
            min-height: 100vh;
            font-size: 14px;
        }

        /* ---- SIDEBAR ---- */
        .sidebar {
            width: var(--sidebar-w);
            background: var(--surface);
            border-right: 1px solid var(--border);
            display: flex;
            flex-direction: column;
            position: fixed;
            top: 0; left: 0; bottom: 0;
            z-index: 100;
        }

        .sidebar-logo {
            padding: 20px 20px 16px;
            border-bottom: 1px solid var(--border);
        }

        .sidebar-logo .brand {
            font-size: 16px;
            font-weight: 700;
            color: var(--accent);
            letter-spacing: -.3px;
        }

        .sidebar-logo .subbrand {
            font-size: 11px;
            color: var(--muted);
            margin-top: 2px;
        }

        .sidebar-badge {
            display: inline-block;
            background: var(--accent);
            color: #fff;
            font-size: 9px;
            font-weight: 700;
            padding: 2px 6px;
            border-radius: 20px;
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-top: 6px;
        }

        .sidebar nav { flex: 1; padding: 12px 0; overflow-y: auto; }

        .nav-section {
            padding: 8px 16px 4px;
            font-size: 10px;
            text-transform: uppercase;
            letter-spacing: 1px;
            color: var(--muted);
            font-weight: 600;
        }

        .sidebar nav a {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 20px;
            color: var(--muted);
            text-decoration: none;
            font-size: 13.5px;
            transition: all .15s;
            border-left: 3px solid transparent;
        }

        .sidebar nav a:hover,
        .sidebar nav a.active {
            color: var(--text);
            background: rgba(108,99,255,.08);
            border-left-color: var(--accent);
        }

        .sidebar nav a .icon { font-size: 16px; width: 20px; text-align: center; }

        .sidebar-footer {
            padding: 16px 20px;
            border-top: 1px solid var(--border);
            font-size: 12px;
            color: var(--muted);
        }

        .sidebar-footer a { color: var(--danger); text-decoration: none; font-weight: 500; }

        /* ---- MAIN ---- */
        .main {
            margin-left: var(--sidebar-w);
            flex: 1;
            display: flex;
            flex-direction: column;
        }

        .topbar {
            background: var(--surface);
            border-bottom: 1px solid var(--border);
            padding: 14px 28px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            position: sticky; top: 0;
            z-index: 50;
        }

        .topbar h1 { font-size: 18px; font-weight: 600; }
        .topbar .user-info { font-size: 13px; color: var(--muted); }
        .topbar .user-info span { color: var(--text); font-weight: 500; }

        .content { padding: 28px; flex: 1; }

        /* ---- ALERTS ---- */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 20px;
            font-size: 13.5px;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        .alert-success { background: rgba(0,212,170,.1); border: 1px solid rgba(0,212,170,.3); color: var(--accent2); }
        .alert-error   { background: rgba(255,77,109,.1); border: 1px solid rgba(255,77,109,.3); color: var(--danger); }

        /* ---- CARDS ---- */
        .card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 16px;
            padding-bottom: 12px;
            border-bottom: 1px solid var(--border);
        }

        /* ---- TABLE ---- */
        table { width: 100%; border-collapse: collapse; }
        th {
            text-align: left;
            padding: 10px 14px;
            font-size: 11px;
            text-transform: uppercase;
            letter-spacing: .7px;
            color: var(--muted);
            border-bottom: 1px solid var(--border);
        }
        td {
            padding: 12px 14px;
            border-bottom: 1px solid rgba(255,255,255,.03);
            font-size: 13.5px;
        }
        tr:hover td { background: rgba(255,255,255,.02); }

        /* ---- BADGES ---- */
        .badge {
            display: inline-block;
            padding: 3px 10px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: capitalize;
        }
        .badge-employe  { background: rgba(108,99,255,.15); color: var(--accent); }
        .badge-rh       { background: rgba(0,212,170,.15);  color: var(--accent2); }
        .badge-admin    { background: rgba(255,180,70,.15); color: var(--warning); }
        .badge-actif    { background: rgba(0,212,170,.15);  color: var(--accent2); }
        .badge-inactif  { background: rgba(255,77,109,.15); color: var(--danger); }
        .badge-en_attente  { background: rgba(255,180,70,.15); color: var(--warning); }
        .badge-approuvee   { background: rgba(0,212,170,.15);  color: var(--accent2); }
        .badge-refusee     { background: rgba(255,77,109,.15); color: var(--danger); }
        .badge-annulee     { background: rgba(122,127,153,.15); color: var(--muted); }

        /* ---- BUTTONS ---- */
        .btn {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 8px 16px;
            border-radius: 7px;
            font-size: 13px;
            font-weight: 500;
            border: none;
            cursor: pointer;
            text-decoration: none;
            transition: all .15s;
        }
        .btn-primary  { background: var(--accent);  color: #fff; }
        .btn-primary:hover  { background: #5952e0; }
        .btn-success  { background: var(--accent2); color: #0f1117; }
        .btn-success:hover  { background: #00b897; }
        .btn-danger   { background: var(--danger);  color: #fff; }
        .btn-danger:hover   { background: #e03055; }
        .btn-ghost    { background: transparent; border: 1px solid var(--border); color: var(--text); }
        .btn-ghost:hover    { background: rgba(255,255,255,.05); }
        .btn-sm       { padding: 5px 10px; font-size: 12px; }

        /* ---- FORMS ---- */
        .form-group { margin-bottom: 16px; }
        .form-label {
            display: block;
            font-size: 12px;
            font-weight: 600;
            color: var(--muted);
            text-transform: uppercase;
            letter-spacing: .5px;
            margin-bottom: 6px;
        }
        .form-control {
            width: 100%;
            background: var(--bg);
            border: 1px solid var(--border);
            border-radius: 7px;
            padding: 9px 12px;
            color: var(--text);
            font-size: 13.5px;
            transition: border-color .15s;
        }
        .form-control:focus { outline: none; border-color: var(--accent); }

        .form-grid { display: grid; grid-template-columns: 1fr 1fr; gap: 16px; }
        .form-grid-3 { display: grid; grid-template-columns: 1fr 1fr 1fr; gap: 16px; }

        .validation-error { color: var(--danger); font-size: 12px; margin-top: 4px; }

        /* ---- STAT CARDS ---- */
        .stats-grid { display: grid; grid-template-columns: repeat(4, 1fr); gap: 16px; margin-bottom: 24px; }
        .stat-card {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 10px;
            padding: 18px;
        }
        .stat-card .stat-label { font-size: 11px; color: var(--muted); text-transform: uppercase; letter-spacing: .7px; }
        .stat-card .stat-value { font-size: 30px; font-weight: 700; margin: 6px 0 2px; }
        .stat-card.accent  .stat-value { color: var(--accent); }
        .stat-card.success .stat-value { color: var(--accent2); }
        .stat-card.warning .stat-value { color: var(--warning); }
        .stat-card.danger  .stat-value { color: var(--danger); }

        /* ---- UTIL ---- */
        .flex         { display: flex; }
        .items-center { align-items: center; }
        .justify-between { justify-content: space-between; }
        .gap-2        { gap: 8px; }
        .mb-4         { margin-bottom: 16px; }
        .text-muted   { color: var(--muted); font-size: 13px; }

        /* ---- MODAL ---- */
        .modal-overlay {
            display: none;
            position: fixed; inset: 0;
            background: rgba(0,0,0,.6);
            z-index: 200;
            align-items: center;
            justify-content: center;
        }
        .modal-overlay.open { display: flex; }
        .modal-box {
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 12px;
            padding: 28px;
            width: 420px;
            max-width: 95vw;
        }
        .modal-title { font-size: 16px; font-weight: 600; margin-bottom: 16px; }
    </style>
</head>
<body>

<aside class="sidebar">
    <div class="sidebar-logo">
        <div class="brand">TechMada RH</div>
        <div class="subbrand">Système de gestion interne</div>
        <div class="sidebar-badge">Admin</div>
    </div>
    <nav>
        <div class="nav-section">Principal</div>
        <a href="<?= base_url('admin/dashboard') ?>" class="<?= uri_string() === 'admin/dashboard' ? 'active' : '' ?>">
            <span class="icon">📊</span> Tableau de bord
        </a>
        <div class="nav-section">Gestion</div>
        <a href="<?= base_url('admin/employes') ?>" class="<?= str_starts_with(uri_string(), 'admin/employes') ? 'active' : '' ?>">
            <span class="icon">👤</span> Employés
        </a>
        <a href="<?= base_url('admin/departements') ?>" class="<?= str_starts_with(uri_string(), 'admin/departements') ? 'active' : '' ?>">
            <span class="icon">🏢</span> Départements
        </a>
        <a href="<?= base_url('admin/types-conge') ?>" class="<?= str_starts_with(uri_string(), 'admin/types-conge') ? 'active' : '' ?>">
            <span class="icon">📋</span> Types de congé
        </a>
        <div class="nav-section">Congés</div>
        <a href="<?= base_url('admin/soldes') ?>" class="<?= str_starts_with(uri_string(), 'admin/soldes') ? 'active' : '' ?>">
            <span class="icon">💰</span> Soldes
        </a>
        <a href="<?= base_url('admin/historique') ?>" class="<?= str_starts_with(uri_string(), 'admin/historique') ? 'active' : '' ?>">
            <span class="icon">📜</span> Historique
        </a>
    </nav>
    <div class="sidebar-footer">
        Connecté : <strong><?= esc(session('prenom') . ' ' . session('nom')) ?></strong><br>
        <a href="<?= base_url('auth/logout') ?>">Se déconnecter</a>
    </div>
</aside>

<div class="main">
    <div class="topbar">
        <h1><?= esc($title ?? 'Admin') ?></h1>
        <div class="user-info">Bonjour, <span><?= esc(session('prenom')) ?></span></div>
    </div>

    <div class="content">
        <?php if (session()->getFlashdata('success')): ?>
            <div class="alert alert-success">✅ <?= esc(session()->getFlashdata('success')) ?></div>
        <?php endif; ?>
        <?php if (session()->getFlashdata('error')): ?>
            <div class="alert alert-error">❌ <?= esc(session()->getFlashdata('error')) ?></div>
        <?php endif; ?>
        <?php if ($errors = session()->getFlashdata('errors')): ?>
            <div class="alert alert-error">
                ❌
                <ul style="margin: 0; padding-left: 16px;">
                    <?php foreach ($errors as $e): ?>
                        <li><?= esc($e) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
        <?php endif; ?>

        <?= $this->renderSection('content') ?>
    </div>
</div>

</body>
</html>