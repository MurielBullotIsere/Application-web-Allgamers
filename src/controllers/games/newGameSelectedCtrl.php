<?php 
/**
 * Registration of a selected game.
 *
 * This function    checks the validity of the form data, 
 *                  saves the game selected for the user via the `createUserGame` function and
 *                  redirects to the first login page.
 *
 * @param array $input from the templates\pages\newUserPage.php form, must contain :
 *                  - 'chooseAGame': The game selected by the user (string).
 *                  - 'levelGame': The user's game level (string).
 *                  - 'favoriteGame': Indicates whether the game is a favorite (string).
 *
 * @throws Exception If the request is not POST.
 * @throws Exception If form data is invalid (missing or empty values).
 * @return void Redirects to the controller that manages the first-use page: src\controllers\pages\firstConnectionCtrl.php.
 */

require_once 'src\models\users\createUserGame.php'; 
require_once 'src\models\database\tokenValidityCheck.php';

// récupère les données du formulaire qui vient de newUserPage.php
function newGameSelected(array $input){
    $rightUser = tokenValidityCheck();
    if (!$rightUser) {
        die("Invalid CSRF token");
    }
    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Ce n'est pas une requête POST");
    }

    if (!isset($input['chooseAGame'], $input['levelGame'], $input['favoriteGame'])
      || $input['chooseAGame'] === '' 
      || $input['levelGame'] === '' 
      || $input['favoriteGame'] === '') {
        throw new Exception('Les données du formulaire sont invalides.');
    }

    $success = createUserGame($input);
    header("Location: index.php?action=firstConnection");
    exit(); 
}

