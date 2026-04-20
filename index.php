<?php

session_start();

require_once 'src/controllers/pages/homepageCtrl.php';
require_once 'src/controllers/pages/mainPageCtrl.php';
require_once 'src/controllers/pages/playersPageCtrl.php';
require_once 'src/controllers/pages/firstConnectionCtrl.php';
require_once 'src/controllers/userAuthentification/inscriptionCtrl.php';
require_once 'src/controllers/userAuthentification/connectionCtrl.php';
require_once 'src/controllers/userAuthentification/getUserCtrl.php';
require_once 'src/controllers/userAuthentification/createUserCtrl.php';
require_once 'src/controllers/games/newGameSelectedCtrl.php';
require_once 'src/controllers/games/chooseGamesSelectedCtrl.php';
require_once 'src/controllers/games/chooseFavoriteGamesCtrl.php';
require_once 'src/controllers/players/playerSelectionFormFilledCtrl.php';

/**
 * ==================== Router ====================
 *
 * Central routing mechanism for the Allgamers application.
 * Reads the 'action' parameter from the URL and dispatches
 * the request to the appropriate controller function.
 *
 * Available actions:
 *      - inscription              : Display the registration page.
 *      - connection               : Display the login page.
 *      - createUser               : Register a new user.
 *      - getUserData              : Authenticate a user.
 *      - firstConnection          : Display the first-use game selection page.
 *      - newGameSelected          : Save a game selection.
 *      - mainPage                 : Display the main page.
 *      - playersPage              : Display the players page.
 *      - playerSelectionFormFilled: Process the player search form.
 *      - chooseGamesSelected      : Set the active list to "selected games".
 *      - chooseFavoriteGames      : Set the active list to "favorite games".
 *      - passwordForgotten        : (not yet implemented)
 *      - teamPage                 : (not yet implemented)
 *      - streamNewsPage           : (not yet implemented)
 *      - eventPage                : (not yet implemented)
 *
 * @throws Exception If an invalid action is provided.
 *
 * @package Allgamers
 * @author  Muriel Bullot
 * @version 1.0
 */
try {
    $action = $_GET['action'] ?? '';

    switch ($action) {
        case 'inscription':
            inscription();
            break;
        case 'connection':
            connection();
            break;
        case 'createUser':
            createUser($_POST);
            break;
        case 'getUserData':
            getUserData($_POST);
            break;
        case 'firstConnection':
            firstConnection();
            break;
        case 'newGameSelected':
            newGameSelected($_POST);
            break;
        case 'mainPage':
            mainPage();
            break;
        case 'playersPage':
            playersPage();
            break;
        case 'playerSelectionFormFilled':
            playerSelectionFormFilled($_POST);
            break;
        case 'chooseGamesSelected':
            chooseGamesSelected();
            break;
        case 'chooseFavoriteGames':
            chooseFavoriteGames();
            break;
        case 'passwordForgotten':
        case 'teamPage':
        case 'streamNewsPage':
        case 'eventPage':
            vueHomepage(); // temporary redirection, not yet implemented
            break;
        case '':
            vueHomepage();
            break;
        default:
            throw new Exception("La page que vous recherchez n'existe pas.");
    }
} catch (Exception $e) {
    echo "Erreur : " . $e->getMessage();
}

/*
feat : Nouvelle fonctionnalité
fix : Correctif
build : Système de build ou dépendances
ci : Intégration continue
docs : Documentation
perf : Amélioration des performances
refactor : Modification, hors fonctionnalités ou correctifs
style : Style du code
test : Ajout/modification de tests
revert : Annulation d’un commit
chore : Autre modification
wip : en cours
*/


//require_once : vérifie d'abord si le fichier a déjà été inclus, si oui, il ne le recharge pas
    // isset() vérifie si la variable est définie.
    // et vérifie si le paramètre action n'est pas vide. 

//   echo "userData['email']" . $rowUserData['email'] . "<br>";

//     echo "<pre>Liste des joueurs sélectionnés : ";
//     var_dump($listOfPlayersSelected);
//     echo "</pre>";

//Les tokens CSRF (Cross-Site Request Forgery) protègent les formulaires web contre les attaques de type CSRF.
    // suivre les instructions de connection dans FreeMind PHP.mm
    // ouvrir xampp et cliquer sur start à apache et mySQLfdgf
    // taper sur le web localhost/Application-web-Allgamers/index.php  

