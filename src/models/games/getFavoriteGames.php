<?php
/** récupérer la liste des jeux favoris avec leurs détails.
 * 
 * @return array Liste des jeux favoris avec leurs détails.
 * @throws Exception Si une erreur survient lors de la préparation de la requête.
 * @throws Exception Si une erreur survient lors de l'exécution de la requête.
*/
require_once 'src/models/database/databaseConnection.php';
require_once 'getGameData.php';

function getFavoriteGames() {
    $id = $_SESSION['userData']['id'];
    $favorite = 1;
    $connection = bddConnect();

    $sql = "SELECT * FROM gamesuser WHERE idUser = ? AND favoriteGame = ?";
    $statement = $connection->prepare($sql); 
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête : ");
    }
    $statement->bind_param("si", $id, $favorite); 
    if (!$statement->execute()) {
        error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
        throw new Exception("Erreur lors de l'exécution de la requête : ");
    }
    $result = $statement->get_result();

    if ($result->num_rows === 0) {
        return []; // Aucun jeu sélectionné
    }
    
    $favoriteGames = []; 
    while ($row = $result->fetch_assoc()) {
        $gameData = getGameData($row['idGame']);
        $favoriteGames[] = [
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

    return $favoriteGames;
}
    