<?php

require_once 'src/models/database/databaseConnection.php';
require_once 'src/models/players/getPlayersData.php';

/**
 * Retrieve all friends of a given user.
 *
 * Fetches all entries linked to the user from the 'matchmaking' table,
 * then retrieves their data via `getPlayersData`.
 *
 * @param string $idUser The user's id.
 * @return array An array of friends' data, each containing :
 *                  - 'id'           : Friend's id.
 *                  - 'alias'        : Friend's alias.
 *                  - 'ageRangeUser' : Friend's age range.
 *               Returns an empty array if no friends are found.
 * @throws Exception If an error occurs during query preparation.
 * @throws Exception If an error occurs during query execution.
 */
function getFriends(string $idUser): array {
    $connection = bddConnect();

    $sql = "SELECT * FROM matchmaking WHERE idUser = ?";
    $statement = $connection->prepare($sql);
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête.");
    }
    $statement->bind_param("s", $idUser);
    if (!$statement->execute()) {
        error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
        throw new Exception("Erreur lors de l'exécution de la requête.");
    }
    $result = $statement->get_result();

    $list = [];
    while ($row = $result->fetch_assoc()) {
        $list[] = ['idUser' => $row['idPlayer']];
    }

    // Free resources
    $result->free();
    $statement->close();
    $connection->close();

    if (empty($list)) {
        return [];
    }

    return getPlayersData($list);
}