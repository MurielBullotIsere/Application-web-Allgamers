<?php 
/**
 *  Affiche la landing page.
 *
 * This function initializes the user's selection criteria 
 *      by storing default values in $_SESSION['playerSelectionCriteria`],
 *
 *      These criteria include :
 *          - 'list' : "0" (no list selected).
 *          - 'choice' : "0" (no choice made).
 *          - 'gameSelected' : "0" (no game selected).
 *          - 'level' : "0" (no level defined).
 *          - 'weekday' : "0" (no day defined).
 *          - 'hour' : "0" (no hour defined).
 *          - 'age' : "0" (no age defined).
 *
 *      and loads and displays the landing page.
 *
 * @return void Loads the home page: `templates/pages/homePage.php`.
 */

function vueHomepage(){
    $_SESSION['playerSelectionCriteria'] = [
    'list' => "0",
    'choice' => "0",
    'gameSelected' => "0",
    'level' => "0",
    'weekday' => "0",
    'hour' => "0",
    'age' => "0",
    ];

    require 'templates/pages/homePage.php'; 
}
