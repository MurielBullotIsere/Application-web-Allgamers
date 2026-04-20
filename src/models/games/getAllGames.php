<?php

require_once 'src/models/database/databaseConnection.php';

/**
 * Retrieve the list of all games.
 *
 * @return array An array containing all games with their details, or an empty array if none found.
 * @throws Exception If an error occurs during query preparation.
 * @throws Exception If an error occurs during query execution.
 */
function getAllGames(): array {
    $connection = bddConnect();

    $sql = "SELECT * FROM game ORDER BY `nameGame`, `platformGame` ASC";
    $statement = $connection->prepare($sql);
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête.");
    }
    if (!$statement->execute()) {
        error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
        throw new Exception("Erreur lors de l'exécution de la requête.");
    }
    $result = $statement->get_result();

    $allGames = [];
    while ($row = $result->fetch_assoc()) {
        $allGames[] = $row;
    }

    // Free resources
    $result->free();
    $statement->close();
    $connection->close();

    return $allGames;
}