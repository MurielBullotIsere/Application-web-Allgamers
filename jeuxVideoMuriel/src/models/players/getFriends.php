<?php
/**
 * recherche tous les amis de l'utilisateur
 *
 * @param string $idUser id l'utilisateur.
 * @return array|null Tableau des amis si trouvé, sinon null.
 * @throws Exception Si une erreur survient lors de la préparation de la requête.
 * @throws Exception Si une erreur survient lors de l'exécution de la requête.
 */
require_once 'src/models/database/databaseConnection.php';

function getFriends(string $idUser) {
    $connection = bddConnect();

    $sql = "SELECT * FROM matchmaking WHERE idUser = ?";// requête préparée avec un placeholder (?)
    $statement = $connection->prepare($sql);    // prépare la requête SQL pour une exécution sécurisée.
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête : ");
    }
    $statement->bind_param("s", $idUser);    // Associe la variable $inputAlias au placeholder ? dans la requête SQL.
    if (!$statement->execute()) {
        error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
        throw new Exception("Erreur lors de l'exécution de la requête : ");
        }
    $result = $statement->get_result();     // Retourne un objet contenant les résultats de la requête.
    
    $listOfFriends = [];
    $listFriendsData = [];
    $list = [];
    if ($result->num_rows !== 0) {
        while ($row = $result->fetch_assoc()) {
            $listOfFriends[] = $row; 
        }
        // récupérer les données des amis
        foreach ($listOfFriends as $friends){
            $list[] = [
                'idUser' => $friends['idPlayer'],
            ];
            $listFriendsData = getPlayersData($list);
        } 
    }
    // Libération des ressources
    $result->free();
    $statement->close();
    $connection->close();

    return $listFriendsData;
}