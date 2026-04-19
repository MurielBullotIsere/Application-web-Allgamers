<?php

require_once 'src/models/database/databaseConnection.php';

/**
 * Update the token in the 'user' table for a specific user.
 *
 * @param string $token  The new token to set for the user.
 * @param string $userId The user's identifier.
 * @throws Exception If an error occurs during query preparation.
 * @throws Exception If an error occurs during query execution.
 */
function updateToken(string $token, string $userId): void {
    $connection = bddConnect();

    $sql = "UPDATE user SET token = ? WHERE id = ?";

    $statement = $connection->prepare($sql);
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête.");
    }

    $statement->bind_param("ss", $token, $userId); 
    if (!$statement->execute()) {
        error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
        throw new Exception("Erreur lors de l'exécution de la requête.");
    }
    $statement->close();
    $connection->close();
}