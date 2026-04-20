<?php

require_once 'src/models/database/databaseConnection.php';

/**
 * Generates a unique user ID.
 *
 * Connects to the database, generates a candidate ID with uniqid(),
 * then checks whether it already exists in the `user` table.
 * Repeats until a truly unique ID is found.
 *
 * @throws Exception If query preparation fails.
 * @throws Exception If query execution fails.
 * @return string A unique user ID guaranteed not to exist in the `user` table.
 *
 * @example
 *      $id = createUniqueId(); // e.g. "6642f3a1c7e8b"
 */
function createUniqueId(): string
{
    $connection = bddConnect();

    $sql       = "SELECT id FROM user WHERE id = ?";
    $statement = $connection->prepare($sql);
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête.");
    }

    $id = '';

    do {
        $id = uniqid();

        $statement->bind_param("s", $id);
        if (!$statement->execute()) {
            error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
            throw new Exception("Erreur lors de l'exécution de la requête.");
        }

        $result     = $statement->get_result();
        $idIsUnique = ($result->num_rows === 0);
        $result->free();

    } while (!$idIsUnique);

    $statement->close();
    $connection->close();

    return $id;
}