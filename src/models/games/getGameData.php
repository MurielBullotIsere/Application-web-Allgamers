<?php
/**
 * Retrieves game information based on its identifier.
 * This function
 *   - connects to the database: databaseConnection.php,
 *   - retrieves information on a specific game from the 'game' table.
 * 
 * @param string $idGame Game identifier.
 * @return array Associative array containing game data (name, platform, image URL).
 * @throws Exception If the query preparation or execution fails, or if no game is found.
 */

require_once 'src/models/database/databaseConnection.php';

function getGameData(string $idGame){
    $connection = bddConnect();
    $gameData = [];

    $sql = "SELECT nameGame, platformGame, urlPictureGame FROM game WHERE id = ?";
    $statement = $connection->prepare($sql); 
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête : ");
    }
    $statement->bind_param("i", $idGame); 
    if (!$statement->execute()) {
        error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
        throw new Exception("Erreur lors de l'exécution de la requête : ");
    }
    $result = $statement->get_result();

    if($result->num_rows === 1){
        $gameData = $result->fetch_assoc();
    }
    else {
        throw new Exception("Aucun jeu trouvé avec l'identifiant fourni.");
    }

    // Libération des ressources
    $result->free();
    $statement->close();
    $connection->close();

    return $gameData;
}