<?php

require_once 'src/models/database/databaseConnection.php';
require_once 'getGameData.php';

/**
 * Retrieve the list of the user's favorite games with their details.
 *
 * Fetches all games marked as favorite for the current user,
 * then enriches each entry with game details via `getGameData`.
 *
 * @return array An array of favorite games, each containing :
 *                  - 'idGame'        : Game id.
 *                  - 'levelGame'     : User's level for this game.
 *                  - 'favoriteGame'  : Favorite flag.
 *                  - 'nameGame'      : Game name.
 *                  - 'platformGame'  : Game platform.
 *                  - 'urlPictureGame': Game picture URL.
 *               Returns an empty array if no favorite games are found.
 * @throws Exception If an error occurs during query preparation.
 * @throws Exception If an error occurs during query execution.
 */
function getFavoriteGames(): array {
    $id = $_SESSION['userData']['id'];
    $favorite = 1;
    $connection = bddConnect();

    $sql = "SELECT * FROM gamesuser WHERE idUser = ? AND favoriteGame = ?";
    $statement = $connection->prepare($sql); 
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête.");
    }
    $statement->bind_param("si", $id, $favorite); 
    if (!$statement->execute()) {
        error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
        throw new Exception("Erreur lors de l'exécution de la requête.");
    }
    $result = $statement->get_result();

    if ($result->num_rows === 0) {
        return [];
    }
    
    $favoriteGames = []; 
    while ($row = $result->fetch_assoc()) {
        $gameData = getGameData($row['idGame']);
        $favoriteGames[] = [
            'idGame'         => $row['idGame'],
            'levelGame'      => $row['levelGame'],
            'favoriteGame'   => $row['favoriteGame'],
            'nameGame'       => $gameData['nameGame'],
            'platformGame'   => $gameData['platformGame'],
            'urlPictureGame' => $gameData['urlPictureGame'],
        ];
    }

    // Free resources
    $result->free();
    $statement->close();
    $connection->close();

    return $favoriteGames;
}