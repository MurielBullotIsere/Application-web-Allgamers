<?php 

require_once('src/models/users/createUserData.php');
require_once('src/models/users/checkPasswordStrength.php');

/**
 * Register a new user.
 *
 * Validates the HTTP method and form data, checks password strength
 * via `checkPasswordStrength`, then attempts to create the user
 * in the database via `createUserData`.
 *
 * @param array $input Form data from templates/userAuthentification/registrationForm.php, must contain :
 *                  - 'firstName'    : Player's first name (string).
 *                  - 'lastName'     : Player's last name (string).
 *                  - 'alias'        : Player's unique alias (string).
 *                  - 'ageRange'     : Player's age range (string).
 *                  - 'adMail'       : Player's email address (string).
 *                  - 'passwordUser' : Player's chosen password (string).
 *
 * @throws Exception If the request method is not POST.
 * @throws Exception If form data is invalid (missing or empty values).
 * @return void Redirects to index.php?action=firstConnection on success,
 *              loads templates/userAuthentification/aliasAlreadyTaken.php if the alias is already taken,
 *              loads templates/userAuthentification/passwordNotStrong.php if the password is too weak.
 */
function createUser(array $input): void {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($input['firstName'], $input['lastName'], $input['alias'],
                  $input['ageRange'], $input['adMail'], $input['passwordUser'])
                && $input['firstName'] !== '' 
                && $input['lastName'] !== '' 
                && $input['alias'] !== ''
                && $input['ageRange'] !== '' 
                && $input['adMail'] !== '' 
                && $input['passwordUser'] !== '') {
            if (checkPasswordStrength($input['passwordUser'])){ 
                $success = createUserData($input);
                if ($success) {
                    $_SESSION['userData'] = $success;
                    header("Location: index.php?action=firstConnection");
                    exit(); 
                } 
                else {
                    require 'templates/userAuthentification/aliasAlreadyTaken.php';
                }
            }
            else {
                require 'templates/userAuthentification/passwordNotStrong.php';
            }
        } 
        else {
            throw new Exception('Les données du formulaire sont invalides.');
        }
    }
    else {
        throw new Exception("Ce n'est pas une requête POST");
    }
}