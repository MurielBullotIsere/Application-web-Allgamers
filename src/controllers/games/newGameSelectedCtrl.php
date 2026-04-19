<?php 

require_once 'src/models/users/createUserGame.php'; 
require_once 'src/models/database/tokenValidityCheck.php';

/**
 * Registration of a selected game.
 *
 * Validates the CSRF token, the HTTP method and the form data,
 * then saves the game selected for the user via the `createUserGame` function.
 *
 * @param array $input Form data from templates/pages/newUserPage.php, must contain :
 *                  - 'chooseAGame'  : The game selected by the user (string).
 *                  - 'levelGame'    : The user's game level (string).
 *                  - 'favoriteGame' : Indicates whether the game is a favorite (string).
 *
 * @throws Exception If the request method is not POST.
 * @throws Exception If form data is invalid (missing or empty values).
 * @return void Redirects to index.php?action=firstConnection on success,
 *              or terminates with die() if the CSRF token is invalid.
 */
function newGameSelected(array $input): void {
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

    createUserGame($input);
    header("Location: index.php?action=firstConnection");
    exit(); 
}

