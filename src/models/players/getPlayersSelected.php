<?php
/**
 * Retrieves a list of players based on user requests via a questionnaire (playersSelectedForm.php)
 * 
 * The function getPlayersSelected(string $gameSelected, string $level, string $weekday, string $hour, string $age) :
 *   - places the game identifier(s) in the $gameIds array:
 *        if only one game has been selected, sets the given identifier to it
 *        if all selected games have been chosen: call the getGamesSelected function to retrieve their identifiers
 *        if all favorite games have been chosen: call the getFavoriteGames function to retrieve their identifiers
 *   - connects to the database: databaseConnection.php,
 *   - retrieves, from the 'gamesuser' table, the fields whose :
 *          - game is in the $gameIds array  
 *      and - game is declared as a favorite game
 *     (and - level is equal to the specified value (not mandatory))
 * 
 * It calls the getPlayersData() function (retrieves player information and game details), which returns an array.
 * This information is sorted according to :
 *    - day of week
 *    - time of day
 *    - age group
 * to keep only those players who match the user's choices. 
 * 
 * 
 * The function returns an array containing :
 *  - idPlayer: The player's ID.
 *  - alias: The player's alias.
 *  - ageRangeUser: The player's age range.
 *  - nameGame: The name of the game.
 *  - platformGame: Game platform.
 *  - levelGame: The player's level for the game.
 * 
 * @param string $gameSelected The selected game ID or "*" for all selected games or "allFavorite" for favorite games.
 * @param string $level The required level of the players or "*" for any level.
 * @param string $weekday The day of the week (not used in the function, but included for future filtering).
 * @param string $hour The hour of play (not used in the function, but included for future filtering).
 * @param string $age The age range of the players (not used in the function, but included for future filtering).
 * 
 * @return array An array of players with their game details
 * @throws Exception If the query preparation or execution fails.
*/

require_once 'src/models/database/databaseConnection.php';
require_once 'src\models\games\getGamesSelected.php';
require_once 'src\models\games\getFavoriteGames.php';
require_once 'src\models\players\getPlayersData.php';

function getPlayersSelected(string $gameSelected,
                            string $level,
                            string $weekday,
                            string $hour,
                            string $age){

    $connection = bddConnect();

// mettre, dans le tableau $gameIds, le ou les identifiants des jeux choisis par l'utilisateur
    // cas où tous les jeux sélectionnés ont été choisis
    if($gameSelected === "*"){
        $gameIds = array_column(getGamesSelected(), 'idGame');
    }
    // cas où tous les jeux favoris ont été choisis
    else if($gameSelected === "allFavorite"){
        $gameIds = array_column(getFavoriteGames(), 'idGame');
    } 
    // cas où un seul jeu a été choisi
    else {$gameIds[] = $gameSelected;}

// Génère un tableau de '?' pour correspondre au nombre d'identifiants à inclure dans la clause IN.
    $placeholders = implode(',', array_fill(0, count($gameIds), '?'));

// Recherche des joueurs ayant le(s) jeu(x) sélectionné(s) dans leur liste de jeux favoris et selon un niveau de jeu donné
    if ($level === "*") {
        $sql = "SELECT * FROM gamesuser WHERE idGame IN ($placeholders) AND favoriteGame = 1";
    } else {
        $sql = "SELECT * FROM gamesuser WHERE idGame IN ($placeholders) AND favoriteGame = 1 AND levelGame = $level";
    }
    $statement = $connection->prepare($sql);
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête : ");
    }
    $types = str_repeat('i', count($gameIds)); // 'i' pour entier (integer), répété pour chaque idGame
    $statement->bind_param($types, ...$gameIds); // Utiliser l'opérateur de décomposition pour lier chaque idGame
    if (!$statement->execute()) {
        error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
        throw new Exception("Erreur lors de l'exécution de la requête : ");
    }
    $result = $statement->get_result();

// placer les résultats dans ke tableau $foundPlayersList
    $foundPlayersList = [];
    if ($result->num_rows !== 0) {
        while ($row = $result->fetch_assoc()) {
            $foundPlayersList[] = $row; 
        } 
    }

    $listPlayerData = [];
    $gameData = [];
    $listPlayerAndGameData = [];

    // récupérer alias et âge de tous les joueurs trouvés
    $listPlayerData = getPlayersData($foundPlayersList);

    // pour chaque joueur trouvé, récupérer les données de son jeu (nameGame, platformGame, urlPictureGame)
    foreach ($foundPlayersList as $game) {
            $gameData = getGameData($game['idGame']);
        
        // récupérer les données correspondantes au joueur 
        foreach ($listPlayerData as $player) {
            if ($player['id'] === $game['idUser']){
                $listPlayerAndGameData [] = [
                    'idPlayer' => $game['idUser'],
                    'alias' => $player['alias'],
                    'ageRangeUser' => $player['ageRangeUser'],
                    'nameGame' => $gameData['nameGame'],
                    'platformGame' => $gameData['platformGame'],
                    'levelGame' => $game['levelGame'],
                ];
                break;
            }  
        }
    }

    // Libération des ressources
    $result->free();
    $statement->close();
    $connection->close();

    return $listPlayerAndGameData;

}