<?php 

require_once 'src/models/games/getGamesSelected.php'; 
require_once 'src/models/games/getFavoriteGames.php'; 
require_once 'src/models/players/getPlayersSelected.php';
require_once 'src/models/database/tokenValidityCheck.php';
require_once 'src/models/players/friendRequestsToArrays.php';

/**
 * Display the players section page.
 *
 * Validates the CSRF token, retrieves all necessary data, then loads the players page.
 *
 * Data retrieved :
 *      - $listOfGamesSelected   : games selected by the user, via `getGamesSelected` (for dropdowns).
 *      - $listOfFavoriteGames   : favorite games of the user, via `getFavoriteGames` (for dropdowns).
 *      - $listOfPlayersSelected : players matching the selection criteria, via `getPlayersSelected`.
 *      - $arraysOfRequests      : friend request lists, via `friendRequestsToArrays`, containing :
 *          - 'friends' : the user's friends.
 *          - 'guests'  : players who sent a friend request to the user.
 *          - 'wait'    : the user's pending requests.
 *          - 'yes'     : the user's accepted requests.
 *          - 'no'      : the user's declined requests.
 *
 * @return void Loads templates/pages/playersPage.php on success,
 *              or terminates with die() if the CSRF token is invalid.
 */
function playersPage(): void {
    $rightUser = tokenValidityCheck();
    if (!$rightUser) {
        die("Invalid CSRF token");
    }
    $listOfGamesSelected = getGamesSelected();
    $listOfFavoriteGames = getFavoriteGames();
    $listOfPlayersSelected = getPlayersSelected(
        $_SESSION['playerSelectionCriteria']['gameSelected'],
        $_SESSION['playerSelectionCriteria']['level'],
        $_SESSION['playerSelectionCriteria']['weekday'],
        $_SESSION['playerSelectionCriteria']['hour'],
        $_SESSION['playerSelectionCriteria']['age']
    );    
    $arraysOfRequests = friendRequestsToArrays($_SESSION['userData']['id']);
    require 'templates/pages/playersPage.php';
}