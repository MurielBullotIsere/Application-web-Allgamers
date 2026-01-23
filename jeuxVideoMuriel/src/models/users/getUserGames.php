<?php
/**
 * Rechercher les données dans la table `userGames`.
 *
 * @param string $idUser L'ID de l'utilisateur.
 * @param string $idGame L'ID du jeu.
 * @return array|null Tableau des données si trouvé, sinon null.
 * @throws Exception Si une erreur survient lors de la préparation de la requête.
 * @throws Exception Si une erreur survient lors de l'exécution de la requête.
 */

require_once 'src/models/database/databaseConnection.php';

function getUserGames(string $idUser, string $idGame) {
    $connection = bddConnect();

    $sql = "SELECT * FROM gamesuser 
                     WHERE idUser = ? AND idGame = ?";
    $statement = $connection->prepare($sql);
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête : ");
    }
    $statement->bind_param("ss", $idUSer, $idGame);
    $statement->execute();
    if (!$statement->execute()) {
        error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
        throw new Exception("Erreur lors de l'exécution de la requête : ");
    }
    $result = $statement->get_result();

    $data = [];

    /* if($result->num_rows === 1) {
    $data = $result->fetch_assoc(); 
    return $data['id']
    }    else{return 0;}*/
    $data = $result->num_rows === 1 ? $result->fetch_assoc() : null;

    $result->free();
    $statement->close();
    $connection->close();

    // si $data['id'] existe (??) il est retourné, sinon 0 est retourné
    return $data['id'] ?? 0;
}

