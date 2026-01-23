<?php 
/**
 * ==================== Router ====================
 *
 * This script acts as a central routing mechanism for various pages and user actions within the application.
 * Based on the 'action' parameter passed via the URL, the script includes the appropriate controller
 * file and invokes the corresponding function.
 *
 * The flow is as follows:
 *      - First, the necessary controller files are included using 'require_once' to avoid reloading them multiple times.
 *      - The script checks if the 'action' parameter is set in the URL.
 *      - Depending on the action, it triggers different functions (e.g., 'inscription()', 'connection()', 'createUser()', etc.).
 *      - If no valid 'action' is provided, the script defaults to displaying the homepage view.
 *      - If an invalid action is passed, an exception is thrown with an error message.
 *
 * Available actions:
 *      - inscription : Access the user registration page.
 *      - connection : Access the user login page.
 *      - createUser : Create a new user using the provided POST data.
 *      - getUserData : Retrieve user data using the provided POST data.
 *      - firstConnection : Handle first-time user login.
 *      - newGameSelected : save game selection.
 *      - mainPage : Display the main page.
 *      - playersPage : Display the players page.
 *      - playerSelectionFormFilled : player selection form based on the existence of favorite or selected games
 *      - chooseGamesSelected : save choice: “list of selected games”.
 *      - chooseFavoriteGames : save choice: “list of favorite games”.
 *      - passwordForgotten, teamPage, streamNewsPage, eventPage : Placeholder actions for future features.
 *
 * Error Handling:
 *      - If an invalid or non-existent action is specified, an exception is thrown with an error message.
 * 
 * @throws Exception If an invalid action is provided.
 * 
 * @package Allgamers
 * @author Muriel Bullot
 * @version 1.0
 */

 session_start();

require_once 'src/controllers/pages/homepageCtrl.php';                      // access to vueHomepage()
require_once 'src/controllers/pages/mainPageCtrl.php';                      // access to mainPage();
require_once 'src/controllers/pages/playersPageCtrl.php';                   // access to playersPage();
require_once 'src/controllers/pages/firstConnectionCtrl.php';               // access to firstConnection();
require_once 'src/controllers/userAuthentification/inscriptionCtrl.php';      // access to inscription()
require_once 'src/controllers/userAuthentification/connectionCtrl.php';       // access to connection()
require_once 'src/controllers/userAuthentification/getUserCtrl.php';          // access to getdUserData($_POST)
require_once 'src/controllers/userAuthentification/createUserCtrl.php';       // access to createUser($_POST)
require_once 'src/controllers/games/newGameSelectedCtrl.php';               // access to newGameSelected($_POST);
require_once 'src/controllers/games/chooseGamesSelectedCtrl.php';           // access to chooseGamesSelected();
require_once 'src/controllers/games/chooseFavoriteGamesCtrl.php';           // access to chooseFavoriteGames();
require_once 'src/controllers/players/playerSelectionFormFilledCtrl.php';   // access to playerSelectionFormFilled();

try {
    if (isset($_GET['action']) && $_GET['action'] !== '') {
        if ($_GET['action'] === 'inscription') {
            inscription();
        } 
        elseif ($_GET['action'] === 'connection') {
            connection();
        }
        elseif ($_GET['action'] === 'createUser') {
            createUser($_POST);
        } 
        elseif ($_GET['action'] === 'getUserData') {
            getUserData($_POST);
        } 
        elseif ($_GET['action'] === 'firstConnection') {
            firstConnection();
        } 
        elseif ($_GET['action'] === 'newGameSelected') {
            newGameSelected($_POST);
        } 
        elseif ($_GET['action'] === 'mainPage') {
            mainPage(); 
        } 
        elseif ($_GET['action'] === 'playersPage') {
            playersPage();
        } 
        elseif ($_GET['action'] === 'playerSelectionFormFilled') {
            playerSelectionFormFilled($_POST); 
        } 
        elseif ($_GET['action'] === 'chooseGamesSelected') {
            chooseGamesSelected();
        } 
        elseif ($_GET['action'] === 'passwordForgotten') {
            vueHomepage(); //function not created, temporary redirection
        } 
        elseif ($_GET['action'] === 'teamPage') {
            vueHomepage(); //function not created, temporary redirection
        } 
        elseif ($_GET['action'] === 'streamNewsPage') {
            vueHomepage(); //function not created, temporary redirection
        } 
        elseif ($_GET['action'] === 'eventPage') {
            vueHomepage(); //function not created, temporary redirection
        } 
        elseif ($_GET['action'] === 'chooseFavoriteGames') {
            chooseFavoriteGames();
        } 
        else {
            throw new Exception("La page que vous recherchez n'existe pas.");
        }
    }
    else {
        vueHomepage();
    }
}
catch (Exception $e){
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
    // taper sur le web localhost/jeuxVideoMuriel/index.php  

