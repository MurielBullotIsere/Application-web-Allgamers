<?php

require_once 'src/models/database/databaseConnection.php';

/**
 * Searches for a user-game record in the `gamesuser` table.
 *
 * Used by createUserGame() to check that the user-game combination
 * does not already exist before inserting a new record.
 *
 * @param string $idUser The user's ID.
 * @param string $idGame The game's ID.
 *
 * @throws Exception If query preparation fails.
 * @throws Exception If query execution fails.
 * @return string|int The record's ID if found, 0 otherwise.
 *
 * @example
 *      $recordId = getUserGames('abc123', '42');
 *      if ($recordId !== 0) {
 *          // user-game combination already exists
 *      }
 */
function getUserGames(string $idUser, string $idGame): string|int
{
    $connection = bddConnect();

    $sql       = "SELECT * FROM gamesuser WHERE idUser = ? AND idGame = ?";
    $statement = $connection->prepare($sql);
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête.");
    }

    $statement->bind_param("ss", $idUser, $idGame);
    if (!$statement->execute()) {
        error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
        throw new Exception("Erreur lors de l'exécution de la requête.");
    }

    $result = $statement->get_result();
    $data   = $result->num_rows === 1 ? $result->fetch_assoc() : null;

    $result->free();
    $statement->close();
    $connection->close();

    return $data['id'] ?? 0;
}