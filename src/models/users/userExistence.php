<?php

require_once 'src/models/users/getAlias.php';
require_once 'src/models/database/updateToken.php';

/**
 * Verifies user credentials against the database.
 *
 * Searches for the alias via getAlias(), then verifies the password.
 * If both match, generates a new CSRF token, updates it in the database
 * via updateToken(), and returns the user's data.
 *
 * @param array $input Form data from templates/userAuthentification/loginForm.php,
 *                     must contain:
 *                          - 'alias'        : The user's alias (string).
 *                          - 'passwordUser' : The user's plain-text password (string).
 *
 * @return array The authenticated user's data if credentials are valid, empty array otherwise.
 *               Returned array contains:
 *                          - 'id'           : User's unique ID (string).
 *                          - 'firstname'    : User's first name (string).
 *                          - 'lastname'     : User's last name (string).
 *                          - 'alias'        : User's alias (string).
 *                          - 'passwordUser' : User's hashed password (string).
 *                          - 'email'        : User's email address (string).
 *                          - 'ageRangeUser' : User's age range (string).
 *                          - 'csrf_token'   : Newly generated CSRF token (string).
 *
 * @example
 *      $user = userExistence($_POST);
 *      if (empty($user)) {
 *          // invalid alias or password
 *      }
 */
function userExistence(array $input): array
{
    $user = getAlias($input['alias']);

    if ($user === null) {
        return [];
    }

    if (!password_verify($input['passwordUser'], $user['passwordUser'])) {
        return [];
    }

    $token = bin2hex(random_bytes(32));
    updateToken($token, $user['id']);

    return [
        'id'           => $user['id'],
        'firstname'    => $user['firstname'],
        'lastname'     => $user['lastname'],
        'alias'        => $user['alias'],
        'passwordUser' => $user['passwordUser'],
        'email'        => $user['email'],
        'ageRangeUser' => $user['ageRangeUser'],
        'csrf_token'   => $token,
    ];
}