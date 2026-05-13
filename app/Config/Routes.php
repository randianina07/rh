<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'AuthController::login');
$routes->get('/login', 'AuthController::login');
$routes->post('/authenticate', 'AuthController::authenticate'); 
$routes->get('/logout', 'AuthController::logout');

$routes->group('employe', ['filter' => 'role:employe'], function($routes) {
    // dashboard
    $routes->get('dashboard', 'EmployeController::index');
    // demandes de congé
    $routes->get('conges', 'EmployeController::mesConges');
    // formulaire demande
    $routes->get('conges/new', 'EmployeController::newConge');
    // soumission
    $routes->post('conges/create', 'EmployeController::createConge');
    // annulation
    $routes->post('conges/annuler/(:num)', 'EmployeController::annulerConge/$1');
    // solde
    $routes->get('soldes', 'EmployeController::mesSoldes');
    // profil
    $routes->get('profil', 'EmployeController::profil');

    $routes->post('profil/update', 'EmployeController::updateProfil');
});

$routes->group('rh', ['filter' => 'role:rh'], function($routes) {
    // dashboard
    $routes->get('dashboard', 'RHController::index');
    // toutes les demandes
    $routes->get('conges', 'RHController::listeConges');
    // détail demande
    $routes->get('conges/(:num)', 'RHController::detailConge/$1');
    // approuver
    $routes->post('conges/approuver/(:num)', 'RHController::approuver/$1');
    // refuser
    $routes->post('conges/refuser/(:num)', 'RHController::refuser/$1');
    // soldes employés
    $routes->get('soldes', 'RHController::soldes');
    // filtrage
    $routes->get('conges/statut/(:any)', 'RHController::filtrerStatut/$1');

    $routes->get('conges/departement/(:num)', 'RHController::filtrerDepartement/$1');
});

$routes->group('admin', ['filter' => 'role:admin'], function($routes) {
    // dashboard
    $routes->get('dashboard', 'AdminController::index');

    // Employés
    $routes->get('employes', 'AdminController::employes');
    $routes->get('employes/new', 'AdminController::newEmploye');
    $routes->post('employes/create', 'AdminController::createEmploye');
    $routes->get('employes/edit/(:num)', 'AdminController::editEmploye/$1');
    $routes->post('employes/update/(:num)', 'AdminController::updateEmploye/$1');
    $routes->post('employes/delete/(:num)', 'AdminController::deleteEmploye/$1');

    // Départements
    $routes->get('departements', 'AdminController::departements');
    $routes->post('departements/create', 'AdminController::createDepartement');
    $routes->post('departements/delete/(:num)', 'AdminController::deleteDepartement/$1');

    // Types de congé
    $routes->get('types-conge', 'AdminController::typesConge');
    $routes->post('types-conge/create', 'AdminController::createTypeConge');
    $routes->post('types-conge/delete/(:num)', 'AdminController::deleteTypeConge/$1');

    // Solde
    $routes->get('soldes', 'AdminController::soldes');
    $routes->post('soldes/init', 'AdminController::initialiserSoldes');
    $routes->post('soldes/update/(:num)', 'AdminController::updateSolde/$1');

    // Historique
    $routes->get('historique', 'AdminController::historique');
});