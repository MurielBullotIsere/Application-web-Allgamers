<?php 

require_once 'src/models/users/userExistence.php';

/**
 * Retrieve and validate user login data.
 *
 * Validates the HTTP method and form data, checks user existence
 * via `userExistence`, then stores user data in $_SESSION['userData'].
 *
 * $_SESSION['userData'] contains :
 *      - 'id'           : User's id.
 *      - 'firstname'    : User's first name.
 *      - 'lastname'     : User's last name.
 *      - 'alias'        : User's alias.
 *      - 'passwordUser' : User's password.
 *      - 'email'        : User's email address.
 *      - 'ageRangeUser' : User's age range.
 *      - 'csrf_token'   : User's CSRF token.
 *
 * @param array $input Form data from templates/userAuthentification/loginForm.php
 *                     or templates/userAuthentification/loginFormForCorrection.php, must contain :
 *                  - 'alias'        : User's alias (string).
 *                  - 'passwordUser' : User's password (string).
 *
 * @throws Exception If the request method is not POST.
 * @throws Exception If form data is invalid (missing or empty values).
 * @return void Redirects to index.php?action=mainPage on success,
 *              loads templates/userAuthentification/loginFormForCorrection.php on failure.
 */
function getUserData(array $input): void {
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($input['alias'], $input['passwordUser'])
                && $input['alias'] !== '' 
                && $input['passwordUser'] !== '') {
            $success = userExistence($input);  
            if($success){
                $_SESSION['userData'] = $success;
                header("Location: index.php?action=mainPage");
                exit(); 
            }
            else {
                require 'templates/userAuthentification/loginFormForCorrection.php';
            }
        } else {
            throw new Exception('Les données du formulaire sont invalides.');
        }
    }
    else {
        throw new Exception("Ce n'est pas une requête POST");
    }
}