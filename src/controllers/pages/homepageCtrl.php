<?php 

/**
 * Display the landing page.
 *
 * Initializes the player's selection criteria with default values
 * in $_SESSION['playerSelectionCriteria'], then loads the landing page.
 *
 * Default values :
 *      - 'list'         : "0" (no list selected).
 *      - 'choice'       : "0" (no choice made).
 *      - 'gameSelected' : "0" (no game selected).
 *      - 'level'        : "0" (no level defined).
 *      - 'weekday'      : "0" (no day defined).
 *      - 'hour'         : "0" (no hour defined).
 *      - 'age'          : "0" (no age defined).
 *
 * @return void Loads templates/pages/homePage.php.
 */
function vueHomepage(): void {
    $_SESSION['playerSelectionCriteria'] = [
        'list'         => "0",
        'choice'       => "0",
        'gameSelected' => "0",
        'level'        => "0",
        'weekday'      => "0",
        'hour'         => "0",
        'age'          => "0",
    ];

    require 'templates/pages/homePage.php'; 
}