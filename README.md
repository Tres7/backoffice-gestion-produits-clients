# Projet de conception d'un backoffice de gestion des clients et produits
# Type de produits: Produits électroniques

# Description
Ce projet est une plateforme web permettant à une entreprise de gérer ses clients et produits via un backoffice sécurisé. L'objectif est de moderniser les outils internes en fournissant une interface intuitive et robuste pour les employés.

# Prérequis du projet
- PHP 8.1 ou supérieur
- Composer
- Symfony CLI
- MySQL
- Git

# Installation
## Cloner le repository :
 `git clone <URL_du_repository>`
 `cd <Nom_du_projet>`

## Installer les dépendances PHP :
`composer install`

## Configurer la base de données :
### Si vous n'avez pas de fichier .env.local, créez-le et Modifiez-le pour définir les informations de connexion à la base de données :
`DATABASE_URL="mysql://<username>:<password>@127.0.0.1:3306/<nom_de_la_base>"`
### Créer la base de données :
`php bin/console doctrine:database:create`
`php bin/console make:migration`
`php bin/console doctrine:migrations:migrate`
### Exécuter les fixtures pour ajouter les données à la base de données
`php bin/console doctrine:fixtures:load`
### Lancer le serveur Symfony :
`symfony serve` ou `symfony serve:start` 
Le projet sera accessible à l'adresse http://localhost:8000/home.


# Structure du projet
## Fonctionnalités principales
### Gestion des utilisateurs :
- Ajout, modification et suppression des utilisateurs (administrateurs uniquement).
- Liste des utilisateurs affichant email, rôle, nom et prénom.
- Gestion des rôles : Administrateur, Gestionnaire, Utilisateur standard.
- Sécurisation avec un Voter pour restreindre l'accès selon le rôle.
### Gestion des produits :
- Ajout, modification et suppression des produits (administrateurs uniquement).
- Liste des produits avec tri par prix décroissant.
- Exportation CSV des produits.
- Importation de produits depuis un fichier CSV via une commande Symfony.
### Gestion des Clients
- Ajout et modification des clients (administrateurs et gestionnaires uniquement).
- Liste et filtrage des clients.
- Vérification du format et de l’unicité des emails.
- Ajout de clients via une commande en ligne.
### Sécurité et Authentification
- Formulaire de connexion.
- Accès restreint selon les rôles (Voter).
- Redirection en cas d'accès interdit avec message d'erreur.
### Exécution des tests:
#### Tester un service spécifique
`php bin/phpunit NomDuTest`
- Statut des commandes visible dans le tableau de bord utilisateur.
#### Tester tous les tests
`php bin/phpunit`

## Lien vers la vidéo de démonstration
https://drive.google.com/file/d/1SidgGNvTyE3h4_vRp1gvP4aay9ccr3y8/view?usp=sharing 

## Petite remarque
Si vous lancez l'application et vous avez une erreur du type: "LogicException  RuntimeError
HTTP 500 Internal Server Error
An exception has been thrown during the rendering of a template ("The "@hotwired/stimulus" vendor asset is missing. Try running the "importmap:install" command."). "
- Faites les commandes suivantes pour installer Stimulus:
  `composer require symfony/stimulus-bundle`
  `php bin/console importmap:install`

