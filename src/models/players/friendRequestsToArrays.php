<?php
/**
 * Retrieves and categorizes friend requests and friendships for a given user.
 *
 * This function queries the database to fetch all friend requests related to the provided user ID.
 * It then categorizes them into different groups:
 *      `invitations`: Incoming friend requests waiting for approval.
 *      `yes`: Newly accepted friend requests that have not been notified.
 *      `friends`: Confirmed friendships.
 *      `no`: Rejected friend requests.
 *      `wait`: Outgoing friend requests that are still pending.
 *
 * @param string $idUser The user ID for whom friend requests and friendships are retrieved.
 * @return array An array containing categorized friend request data.
 * @throws Exception If there is an error in query preparation.
 * @throws Exception If there is an error in execution.
 */


 require_once 'src/models/database/databaseConnection.php';

function friendRequestsToArrays(string $idUser) {
    $getArrays = [];
    $wait = [];
    $no = [];
    $yes = [];
    $friends = [];
    $invitations = [];

    $connection = bddConnect();
    // recherche d'invitations
    $sql = "SELECT * FROM friendrequest WHERE invitation = ? OR request = ?";
    $statement = $connection->prepare($sql); 
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête : ");
    }
    $statement->bind_param("ss", $idUser, $idUser); 
    if (!$statement->execute()) {
        error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
        throw new Exception("Erreur lors de l'exécution de la requête : ");
    }
    $result = $statement->get_result();

    if ($result->num_rows === 0) {
        return []; // aucune demande, aucun ami
    }

    while ($row = $result->fetch_assoc()) {
        // est ce que j'ai reçu des invitations ?
        if ($row['invitation'] == $idUser && $row['agree'] == "wait"){
            $invitations[] = $row;
        }
        // est ce que j'ai de nouveaux amis ?
        if ($row['request'] == $idUser && $row['agree'] == "yes" && $row['notified'] == 0){
            $yes[] = $row;
            $friends[] = $row;
        }
        // quels sont mes amis ?
        if (($row['request'] == $idUser && $row['notified'] == 1) || ($row['invitation'] == $idUser && $row['notified'] == 1)){
            $friends[] = $row;
        }
        if ($row['request'] == $idUser && $row['agree'] == "no"){
            $no[] = $row;
        }
        // qui n'a pas répondu à mon invitation ?
        if ($row['request'] == $idUser && $row['agree'] == "wait"){
            $wait[] = $row;
        }
    }
    
    $getArrays[] = [
        'invitations' => $invitations,
        'yes' => $yes,
        'friends' => $friends,
        'no' => $no,
        'wait' => $wait,
    ];

    // Libération des ressources
    $result->free();
    $statement->close();
    $connection->close();
    
    return $getArrays;
}
