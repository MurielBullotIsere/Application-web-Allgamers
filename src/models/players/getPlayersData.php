<?php

require_once 'src/models/database/databaseConnection.php';

/**
 * Retrieve data for a list of players by their id.
 *
 * For each player in the list, fetches their id, alias and age range
 * from the 'user' table.
 *
 * @param array $listPlayers An array of players, each containing :
 *                  - 'idUser' : The player's id (string).
 * @return array An array of players, each containing :
 *                  - 'id'           : Player's id.
 *                  - 'alias'        : Player's alias.
 *                  - 'ageRangeUser' : Player's age range.
 *               Returns an empty array if $listPlayers is empty.
 * @throws Exception If an error occurs during query preparation.
 * @throws Exception If an error occurs during query execution.
 * @throws Exception If no user or more than one user is found for a given id.
 */
function getPlayersData(array $listPlayers): array {
    $connection = bddConnect();
    $data = [];

    foreach ($listPlayers as $player) {
        $sql = "SELECT id, alias, ageRangeUser FROM user WHERE id = ?";
        $statement = $connection->prepare($sql); 
        if (!$statement) {
            error_log("Erreur de préparation de la requête : " . $connection->error);
            throw new Exception("Échec de la préparation de la requête.");
        }
        $statement->bind_param("s", $player['idUser']); 
        if (!$statement->execute()) {
            error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
            throw new Exception("Erreur lors de l'exécution de la requête.");
        }
        $result = $statement->get_result();
        if ($result->num_rows !== 1) {
            throw new Exception("Aucun utilisateur trouvé ou plusieurs utilisateurs trouvés.");
        }
        $data[] = $result->fetch_assoc();

        // Free resources for this iteration
        $result->free();
        $statement->close();
    }

    $connection->close();
    return $data;
}