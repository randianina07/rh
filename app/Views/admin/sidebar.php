<?php /** Sidebar admin réutilisable */ ?>
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
