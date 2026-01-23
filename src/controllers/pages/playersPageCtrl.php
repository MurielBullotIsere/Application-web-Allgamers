<?php 
/** affiche la page de la section 'joueurs'.
 *
 * Cette fonction récupère la liste des jeux sélectionnés de l'utilisateur               via la fonction 'getGamesSelected'       dans src\models\games\getGamesSelected.php,
 *                récupère la liste des jeux favori de l'utilisateur                     via la fonction 'getFavoriteGames'       dans src\models\games\getFavoriteGames.php,
 *                récupère la liste des joueurs correspondants aux critères de sélection via la fonction 'getPlayersSelected'     dans src\models\players\getPlayersSelected.php
 *                récupère le tableau contenant différentes listes d'amis                via la fonction 'friendRequestsToArrays' dans src\models\players\friendRequestsToArrays.php
 *                  - la liste des amis de l'utilisateur ("friends")
 *                  - la liste des joueurs qui font une demande d'ami à l'utilisateur ("guests")
 *                  - la liste des demandes de l'utilisateur en attente ("wait")
 *                  - la liste des demandes de l'utilisateur acceptées ("yes")
 *                  - la liste des demandes de l'utilisateur refusées ("no")
 *                charge et affiche la page de la section 'joueurs': templates/pages/playersPage.php.
 *
 * @return void charge la page qui gère la section 'joueurs' : 'templates/pages/playersPage.php'.
 */
require_once 'src/models/games/getGamesSelected.php'; 
require_once 'src/models/games/getFavoriteGames.php'; 
require_once 'src/models/players/getPlayersSelected.php';
require_once 'src\models\database\tokenValidityCheck.php';
require_once 'src\models\players\friendRequestsToArrays.php';
function playersPage(){
    $rightUser = tokenValidityCheck();
    if (!$rightUser) {
        die("Invalid CSRF token");
    }
    $listOfGamesSelected = getGamesSelected();  // pour les menus déroulants
    $listOfFavoriteGames = getFavoriteGames();  // pour les menus déroulants
    $listOfPlayersSelected = getPlayersSelected($_SESSION['playerSelectionCriteria']['gameSelected'],
                                                $_SESSION['playerSelectionCriteria']['level'],
                                                $_SESSION['playerSelectionCriteria']['weekday'],
                                                $_SESSION['playerSelectionCriteria']['hour'],
                                                $_SESSION['playerSelectionCriteria']['age']);    
    $arraysOfRequests = friendRequestsToArrays($_SESSION['userData']['id']);
    require 'templates/pages/playersPage.php';
}
