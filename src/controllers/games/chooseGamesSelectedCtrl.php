<?php 
/**
 * Save choice : selected games.
 *
 * This function saves the player's choice 
 * by filling $_SESSION['playerSelectionCriteria'] with the value “1”.
 *
 * @throws Exception If the request is not POST.
 * @return void Redirects to the controller that manages the 'players' section: 'src\controllers\pages\playersPageCtrl.php'.
 */

require_once 'src\models\database\tokenValidityCheck.php';

function chooseGamesSelected(){
    $rightUser = tokenValidityCheck();
    if (!$rightUser) {
        die("Invalid CSRF token");
    }
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Ce n'est pas une requête POST");
    }

    $_SESSION['playerSelectionCriteria']['list'] = "1";
    
    header("Location: index.php?action=playersPage");
    exit(); 
}
