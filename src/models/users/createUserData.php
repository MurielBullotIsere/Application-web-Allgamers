<?php

require_once 'src/models/database/databaseConnection.php';
require_once 'src/models/users/getAlias.php';
require_once 'src/models/users/createUniqueId.php';

/**
 * Creates a new user in the `user` table if the alias does not already exist.
 *
 * Checks alias uniqueness via getAlias(), generates a unique ID via createUniqueId(),
 * hashes the password, generates a CSRF token, then inserts the user into the database.
 *
 * @param array $input Form data from templates/userAuthentification/registrationForm.php,
 *                     must contain:
 *                          - 'alias'        : The user's chosen alias (string).
 *                          - 'firstName'    : The user's first name (string).
 *                          - 'lastName'     : The user's last name (string).
 *                          - 'passwordUser' : The user's plain-text password (string).
 *                          - 'adMail'       : The user's email address (string).
 *                          - 'ageRange'     : The user's age range (string).
 *
 * @throws Exception If query preparation fails.
 * @throws Exception If query execution fails.
 * @return array The inserted user's data, or an empty array if the alias already exists.
 *               Returned array contains:
 *                          - 'id'           : Generated unique user ID (string).
 *                          - 'firstname'    : User's first name (string).
 *                          - 'lastname'     : User's last name (string).
 *                          - 'alias'        : User's alias (string).
 *                          - 'passwordUser' : Hashed password (string).
 *                          - 'email'        : User's email address (string).
 *                          - 'ageRangeUser' : User's age range (string).
 *                          - 'csrf_token'   : Generated CSRF token (string).
 *
 * @example
 *      $user = createUserData($_POST);
 *      if (empty($user)) {
 *          // alias already taken
 *      }
 */
function createUserData(array $input): array
{
    $aliasExist = getAlias($input['alias']);
    if ($aliasExist) {
        return [];
    }

    $id             = createUniqueId();
    $hashedPassword = password_hash($input['passwordUser'], PASSWORD_DEFAULT);
    $token          = bin2hex(random_bytes(32));

    $data = [
        'id'           => $id,
        'firstname'    => $input['firstName'],
        'lastname'     => $input['lastName'],
        'alias'        => $input['alias'],
        'passwordUser' => $hashedPassword,
        'email'        => $input['adMail'],
        'ageRangeUser' => $input['ageRange'],
        'csrf_token'   => $token,
    ];

    $connection = bddConnect();

    $sql = "INSERT INTO user (id, firstname, lastname, alias, passwordUser, email, ageRangeUser, token)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $statement = $connection->prepare($sql);
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête.");
    }

    $statement->bind_param(
        "ssssssss",
        $data['id'],
        $data['firstname'],
        $data['lastname'],
        $data['alias'],
        $data['passwordUser'],
        $data['email'],
        $data['ageRangeUser'],
        $token
    );
    if (!$statement->execute()) {
        error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
        throw new Exception("Erreur lors de l'exécution de la requête.");
    }

    $statement->close();
    $connection->close();

    return $data;
}