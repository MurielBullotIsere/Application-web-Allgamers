<?php

/**
 * Récupérer la liste de tous les jeux.
 *
 * @return array|null Tableau contenant tous les jeux avec leurs détails, sinon null. 
 * @throws Exception Si une erreur survient lors de la préparation de la requête.
 * @throws Exception Si une erreur survient lors de l'exécution de la requête.
 */
require_once 'src/models/database/databaseConnection.php';

function getAllGames() {
    $connection = bddConnect();

    $sql = "SELECT * FROM game ORDER BY `nameGame`,`platformGame` ASC";
    $statement = $connection->prepare($sql);
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête : ");
    }
    if (!$statement->execute()) {
        error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
        throw new Exception("Erreur lors de l'exécution de la requête : ");
    }
    $result = $statement->get_result();

    $allGames = [];
    while ($row = $result->fetch_assoc()) {
        $allGames[] = $row;
    }

    // Libération des ressources
    $result->free();
    $statement->close();
    $connection->close();

    return $allGames;
}
    
