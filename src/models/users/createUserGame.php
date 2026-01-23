<?php
/**
 * Enregistrer l'id du jeu et l'id du joueur dans la table gamesuser
 * 
 * @param array Données d'entrée provenant du formulaire.
 * @return array Données insérées dans la base de données.
 * @throws Exception Si un enregistrement identique existe déjà.
 * @throws Exception Si une erreur survient lors de la préparation de la requête.
 * @throws Exception Si une erreur survient lors de l'exécution de la requête.
 */


require_once 'src/models/database/databaseConnection.php';
require_once 'getUserGames.php';

function createUserGame(array $input) {
    $data = [
        'idUser' => $_SESSION['userData']['id'],
        'idGame' => $input['chooseAGame'],
        'levelGame' => $input['levelGame'],
        'favoriteGame' =>  $input['favoriteGame'],
    ];

    // vérification de l'inexistance d'un enregistrement identique (normlement, 2 enregistrements identiques est impossible)
    $existingProfile = getUserGames($data['idUser'], $data['idGame']);
    if($existingProfile) {
        throw new Exception("Erreur");
    }

    $connection = bddConnect();

    $sql = "INSERT INTO gamesuser(idUser, 
                                    idGame, 
                                    levelGame, 
                                    favoriteGame) 
                VALUES (?, ?, ?, ?)";
    $statement = $connection->prepare($sql);
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête : ");
    }
    $statement->bind_param("ssss", $data['idUser'], 
                                    $data['idGame'], 
                                    $data['levelGame'], 
                                    $data['favoriteGame']);
    if (!$statement->execute()) {
        error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
        throw new Exception("Erreur lors de l'exécution de la requête : ");
    }

    // Libérer les résultats et les ressources pour éviter des fuites mémoire
    $statement->close();
    $connection->close();

    return $data;
}    
// $connection = bddConnect();
// $sql = "UPDATE gamesuser SET idUser = ?, 
//                                idGame = ?, 
//                                levelGame = ?,
//                                favoriteGame = ?
//                             WHERE id = ?";
// $statement = $connection->prepare($sql);
// $statement->bind_param("ssssi", $data['idUser'], 
//                                 $data['idGame'], 
//                                 $data['levelGame'], 
//                                 $data['favoriteGame'],
//                                 $getId);
// $statement ->execute();
