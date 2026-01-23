<?php 
/**
 * Displays the main page.
 *
 * This function loads and displays the main page.
 *
 * @return void Loads the main page: 'templates/pages/mainPage.php'.
 */
require_once 'src\models\database\tokenValidityCheck.php';

function mainPage(){
    $rightUser = tokenValidityCheck();
    if (!$rightUser) {
        die("Invalid CSRF token");
    }
    require 'templates/pages/mainPage.php';
}
