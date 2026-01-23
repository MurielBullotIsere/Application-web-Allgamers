<?php
/**
 * Met à jour le token dans la table 'user' pour un utilisateur précis.
 *
 * @param string $token Le nouveau token à définir pour l'utilisateur.
 * @param string $userId L'identifiant de l'utilisateur.
 * @throws Exception Si une erreur survient lors de la préparation ou de l'exécution de la requête.
 */
require_once 'src/models/database/databaseConnection.php';

function updateToken(string $token, string $userId): void {
    $connection = bddConnect();
    // $sql = "UPDATE user SET token = $token WHERE id = $userId;

    $sql = "UPDATE user SET token = ? WHERE id = ?";

    $statement = $connection->prepare($sql);
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête.");
    }

    $statement->bind_param("ss", $token, $userId); 
    if (!$statement->execute()) {
        error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
        throw new Exception("Erreur lors de l'exécution de la requête.");
    }
    $statement->close();
    $connection->close();
}
