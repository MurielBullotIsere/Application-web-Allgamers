<?php

require_once 'src/models/database/databaseConnection.php';

/**
 * Searches for a user in the `user` table by their alias.
 *
 * Used to check alias uniqueness before registration,
 * and to retrieve user data during login.
 *
 * @param string $alias The alias to search for.
 *
 * @throws Exception If query preparation fails.
 * @throws Exception If query execution fails.
 * @return array|null The user's data if found, null otherwise.
 *                    Returned array contains:
 *                         - 'id'           : User's unique ID (string).
 *                         - 'firstname'    : User's first name (string).
 *                         - 'lastname'     : User's last name (string).
 *                         - 'alias'        : User's alias (string).
 *                         - 'passwordUser' : User's hashed password (string).
 *                         - 'email'        : User's email address (string).
 *                         - 'ageRangeUser' : User's age range (string).
 *                         - 'token'        : User's CSRF token (string).
 *
 * @example
 *      $user = getAlias('player42');
 *      if ($user === null) {
 *          // alias is available
 *      }
 */
function getAlias(string $alias): array|null
{
    $connection = bddConnect();

    $sql       = "SELECT * FROM user WHERE alias = ?";
    $statement = $connection->prepare($sql);
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête.");
    }

    $statement->bind_param("s", $alias);
    if (!$statement->execute()) {
        error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
        throw new Exception("Erreur lors de l'exécution de la requête.");
    }

    $result = $statement->get_result();
    $data   = $result->num_rows === 1 ? $result->fetch_assoc() : null;

    $result->free();
    $statement->close();
    $connection->close();

    return $data;
}