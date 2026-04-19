<?php 

require_once 'src/models/database/tokenValidityCheck.php';

/**
 * Display the main page.
 *
 * Validates the CSRF token, then loads the main page.
 *
 * @return void Loads templates/pages/mainPage.php on success,
 *              or terminates with die() if the CSRF token is invalid.
 */
function mainPage(): void {
    $rightUser = tokenValidityCheck();
    if (!$rightUser) {
        die("Invalid CSRF token");
    }
    require 'templates/pages/mainPage.php';
}