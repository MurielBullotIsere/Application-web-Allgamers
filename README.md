# Allgamers

## Description
Application de communauté sociale conçue pour les joueurs de jeux vidéo.

Allgamers permet à ses utilisateurs de :
- s'inscrire et se connecter
- gérer leur profil de joueur (jeux sélectionnés, niveaux, favoris)
- rechercher d'autres joueurs selon des critères (jeu, niveau, disponibilité, âge)
- gérer leurs relations avec d'autres joueurs (demandes d'amis, liste d'amis)

Les sections suivantes sont en cours de développement :
- groupes (teams)
- évènements
- stream et actualités

---

## Prérequis
- PHP 8.0 ou supérieur
- MySQL
- XAMPP (ou tout autre serveur local Apache + MySQL)

---

## Installation
- Installer XAMPP
- Se placer dans le dossier `xampp/htdocs`
- Cloner ce dépôt :
```
git clone https://github.com/ton-compte/Application-web-Allgamers.git
```
- Lancer XAMPP et cliquer sur Start pour Apache et MySQL
- Importer la base de données via phpMyAdmin (`https://localhost/phpmyadmin`)
- Accéder à l'application via `http://localhost/Application-web-Allgamers/index.php`

---

## Accès en ligne
`allgamers.infinityfreeapp.com/Application-web-Allgamers/index.php`

---

## Structure du projet
- `index.php` : routeur central de l'application
- `src/controllers` : contrôleurs par domaine (pages, jeux, joueurs, authentification)
- `src/models` : accès aux données (base de données, utilisateurs, jeux, joueurs)
- `templates` : vues et composants d'affichage
- `templates/assets` : feuilles de style et images

---

## Sécurité
- Les mots de passe sont hachés avec `password_hash()`
- Les requêtes SQL sont préparées avec des paramètres liés pour prévenir les injections SQL
- Les tokens CSRF sont générés à la connexion et vérifiés à chaque action sensible
