<?php
/** récupère une liste des joueurs avec leur id
 * 
 * @param string $gameSelected l'Id du jeu
 * @param string $level l'Id du jeu
 * @param string $weekday l'Id du jeu
 * @param string $hour l'Id du jeu
 * @param string $age l'Id du jeu
 * @return array Liste des des joueurs avec leur alias, leur age et leur id.
 * @throws Exception Si une erreur survient lors de la préparation de la requête.
 * @throws Exception Si une erreur survient lors de l'exécution de la requête.
*/
require_once 'src/models/database/databaseConnection.php';
require_once 'src\models\games\getGameData.php';
function getPlayersData(array $listPlayers){
    $connection = bddConnect();
    $data = [];

    if(!empty($listPlayers))    {
        foreach ($listPlayers as $player) {
            $sql = "SELECT id, alias, ageRangeUser FROM user WHERE id = ?";
            $statement = $connection->prepare($sql); 
            if (!$statement) {
                error_log("Erreur de préparation de la requête : " . $connection->error);
                throw new Exception("Échec de la préparation de la requête : ");
            }
            $statement->bind_param("s", $player['idUser']); 
            if (!$statement->execute()) {
                error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
                throw new Exception("Erreur lors de l'exécution de la requête : ");
            }
            $result = $statement->get_result();
            if ($result->num_rows !== 1) {
                error_log("Erreur impossible : " . $statement->error);
                throw new Exception("Erreur lors de l'exécution de la requête : ");
            }
            $data[]= $result->fetch_assoc();
        }
        // Libération des ressources
        $result->free();
        $statement->close();
    }
    $connection->close();
    return $data;
}
