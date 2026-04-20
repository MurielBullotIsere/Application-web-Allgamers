<?php

require_once 'src/models/database/databaseConnection.php';

/**
 * Retrieve and categorize friend requests and friendships for a given user.
 *
 * Queries the database to fetch all friend requests related to the given user,
 * then categorizes them into the following groups :
 *      - 'invitations' : Incoming friend requests waiting for approval.
 *      - 'yes'         : Newly accepted friend requests not yet notified.
 *      - 'friends'     : All confirmed friendships (notified or not).
 *      - 'no'          : Rejected friend requests.
 *      - 'wait'        : Outgoing friend requests still pending.
 *
 * @param string $idUser The id of the user for whom requests and friendships are retrieved.
 * @return array An array containing the categorized friend request data,
 *               or an empty array if no requests or friendships are found.
 * @throws Exception If an error occurs during query preparation.
 * @throws Exception If an error occurs during query execution.
 */
function friendRequestsToArrays(string $idUser): array {
    $wait        = [];
    $no          = [];
    $yes         = [];
    $friends     = [];
    $invitations = [];

    $connection = bddConnect();

    $sql = "SELECT * FROM friendrequest WHERE invitation = ? OR request = ?";
    $statement = $connection->prepare($sql); 
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête.");
    }
    $statement->bind_param("ss", $idUser, $idUser); 
    if (!$statement->execute()) {
        error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
        throw new Exception("Erreur lors de l'exécution de la requête.");
    }
    $result = $statement->get_result();

    if ($result->num_rows === 0) {
        return [];
    }

    while ($row = $result->fetch_assoc()) {
        // Incoming friend requests waiting for approval
        if ($row['invitation'] == $idUser && $row['agree'] == "wait") {
            $invitations[] = $row;
        }
        // Newly accepted friend requests not yet notified
        if ($row['request'] == $idUser && $row['agree'] == "yes" && $row['notified'] == 0) {
            $yes[]     = $row;
            $friends[] = $row;
        }
        // Already notified confirmed friendships
        if (($row['request'] == $idUser && $row['notified'] == 1) || ($row['invitation'] == $idUser && $row['notified'] == 1)) {
            $friends[] = $row;
        }
        // Rejected friend requests
        if ($row['request'] == $idUser && $row['agree'] == "no") {
            $no[] = $row;
        }
        // Outgoing friend requests still pending
        if ($row['request'] == $idUser && $row['agree'] == "wait") {
            $wait[] = $row;
        }
    }
    
    // Free resources
    $result->free();
    $statement->close();
    $connection->close();

    return [
        'invitations' => $invitations,
        'yes'         => $yes,
        'friends'     => $friends,
        'no'          => $no,
        'wait'        => $wait,
    ];
}