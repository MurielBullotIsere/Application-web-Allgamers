<?php

require_once 'src/models/database/databaseConnection.php';

/**
 * Retrieve game information based on its identifier.
 *
 * Fetches name, platform and image URL for a specific game from the 'game' table.
 *
 * @param string $idGame Game identifier.
 * @return array Associative array containing :
 *                  - 'nameGame'       : Game name.
 *                  - 'platformGame'   : Game platform.
 *                  - 'urlPictureGame' : Game picture URL.
 * @throws Exception If an error occurs during query preparation.
 * @throws Exception If an error occurs during query execution.
 * @throws Exception If no game is found with the given identifier.
 */
function getGameData(string $idGame): array {
    $connection = bddConnect();

    $sql = "SELECT nameGame, platformGame, urlPictureGame FROM game WHERE id = ?";
    $statement = $connection->prepare($sql); 
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête.");
    }
    $statement->bind_param("i", $idGame); 
    if (!$statement->execute()) {
        error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
        throw new Exception("Erreur lors de l'exécution de la requête.");
    }
    $result = $statement->get_result();

    if ($result->num_rows !== 1) {
        throw new Exception("Aucun jeu trouvé avec l'identifiant fourni.");
    }

    $gameData = $result->fetch_assoc();

    // Free resources
    $result->free();
    $statement->close();
    $connection->close();

    return $gameData;
}