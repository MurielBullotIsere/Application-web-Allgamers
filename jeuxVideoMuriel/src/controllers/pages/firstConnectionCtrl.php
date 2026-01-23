<?php 
/**
 * Display the first use page.
 *
 * This function retrieves the list of games selectable via the getGamesSelectable function, 
 *               retrieves the list of games already selected via the getGamesSelected function, 
 *               loads and displays the user's first use page.
 * 
 * @return void Loads the first-use page: `templates/pages/newUserPage.php`.
 */

require_once 'src/models/games/getGamesSelectable.php'; 
require_once 'src/models/games/getGamesSelected.php'; 
require_once 'src\models\database\tokenValidityCheck.php';


function firstConnection() {
    $rightUser = tokenValidityCheck();
    if (!$rightUser) {
        die("Invalid CSRF token");
    }
    $listOfGamesSelectable = getGamesSelectable();
    $listOfGamesSelected = getGamesSelected();
    require 'templates/pages/newUserPage.php';
}

