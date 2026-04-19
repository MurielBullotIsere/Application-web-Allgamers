<?php 

require_once 'src/models/games/getGamesSelectable.php'; 
require_once 'src/models/games/getGamesSelected.php'; 
require_once 'src/models/database/tokenValidityCheck.php';

/**
 * Display the first use page.
 *
 * Validates the CSRF token, retrieves the list of selectable games
 * via `getGamesSelectable` and the list of already selected games
 * via `getGamesSelected`, then loads the first-use page.
 *
 * @return void Loads templates/pages/newUserPage.php on success,
 *              or terminates with die() if the CSRF token is invalid.
 */
function firstConnection(): void {
    $rightUser = tokenValidityCheck();
    if (!$rightUser) {
        die("Invalid CSRF token");
    }
    $listOfGamesSelectable = getGamesSelectable();
    $listOfGamesSelected = getGamesSelected();
    require 'templates/pages/newUserPage.php';
}