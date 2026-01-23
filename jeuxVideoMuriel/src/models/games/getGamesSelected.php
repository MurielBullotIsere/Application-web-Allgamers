<?php
/**
 * Retrieves the list of games selected by the user, along with their data.
 *
 * This function:
 * - Gets the user ID from the session
 * - Connects to the database : src\models\database\databaseConnection.php
 * - Fetches the games linked to this user from the `gamesuser` table
 * - For each game, retrieve its data: src\models\games\getGameData.php
 * - Returns an array containing the user's selected games and their data 
 *
 * @throws Exception If the SQL query preparation or execution fails
 * @return array An array containing the user's selected games and their data.
 */

require_once 'src\models\database\databaseConnection.php';
require_once 'src\models\games\getGameData.php';

function getGamesSelected() {
    $id = $_SESSION['userData']['id'];

    $connection = bddConnect();

    $sql = "SELECT * FROM gamesuser WHERE idUser = ?";
    $statement = $connection->prepare($sql); 
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête : ");
    }
    $statement->bind_param("s", $id); 
    if (!$statement->execute()) {
        error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
        throw new Exception("Erreur lors de l'exécution de la requête : ");
    }
    $result = $statement->get_result();

    if ($result->num_rows === 0) {
        return []; // No games selected
    }
    
    $gamesSelected = []; 
    while ($row = $result->fetch_assoc()) {
        $gameData = getGameData($row['idGame']);
        $gamesSelected [] = [
            'idGame' => $row['idGame'],
            'levelGame' => $row['levelGame'],
            'favoriteGame' => $row['favoriteGame'],
            'nameGame' => $gameData['nameGame'],
            'platformGame' => $gameData['platformGame'],
            'urlPictureGame' => $gameData['urlPictureGame'],
        ];
    }

    // Libération des ressources
    $result->free();
    $statement->close();
    $connection->close();

    return $gamesSelected;
}