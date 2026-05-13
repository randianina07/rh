# RH - Système de gestion des congés

Projet CodeIgniter 4 léger pour la gestion interne des ressources humaines (congés, soldes, employés, départements).

Ce dépôt contient une application PHP/CodeIgniter 4 prête à l'emploi avec une base SQLite fournie (`rh.db`).

## Prérequis

- PHP 8.0+ (avec les extensions SQLite activées)
- Composer
- Un serveur web local (php -S ou `spark serve` de CodeIgniter)

## Installation rapide

1. Cloner le dépôt ou décompresser l'archive dans votre dossier de projet.
2. Installer les dépendances PHP :

```bash
composer install
```

3. Vérifier que PHP peut écrire dans `writable/` (permissions) :

```bash
chmod -R 0777 writable
```

4. La base de données SQLite fournie est `rh.db` (à la racine) et une copie dans `writable/rh.db` est également présente. La configuration par défaut dans `app/Config/Database.php` pointe vers `ROOTPATH . 'rh.db'`.

5. Lancer le serveur de développement (optionnel) :

```bash
php spark serve
```

Puis ouvrir http://localhost:8080

## Comptes de test

Le projet contient déjà des comptes d'exemple dans la base SQLite `rh.db` :

- Administrateur
	- Email: claire.rasoanaivo@entreprise.com
	- Mot de passe: password123
	- Rôle: admin

- RH
	- Email: marie.rabe@entreprise.com
	- Mot de passe: password123
	- Rôle: rh

- Employé exemple
	- Email: jean.rakoto@entreprise.com
	- Mot de passe: password123
	- Rôle: employe

Remarque : les mots de passe dans la DB sont en clair pour l'instant (uniquement en développement). Changez-les en production.

## Routes principales

- /auth/login  — page de connexion
- /admin/*     — pages réservées aux administrateurs (tableau de bord, gestion des employés, départements, types de congé)
- /rh/*        — pages pour le rôle RH (demandes de congé, soldes, types, départements)
- /employe/*   — pages pour les employés (tableau de bord, mes congés, mon solde, profil)

Les vues partagent désormais un layout commun (`app/Views/shared/layout.php`) et des sidebars spécifiques pour chaque rôle :

- `app/Views/admin/sidebar.php`
- `app/Views/rh/sidebar.php` (existant)
- `app/Views/employe/sidebar.php`

