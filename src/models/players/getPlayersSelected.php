<?php

require_once 'src/models/database/databaseConnection.php';
require_once 'src/models/games/getGamesSelected.php';
require_once 'src/models/games/getFavoriteGames.php';
require_once 'src/models/games/getGameData.php';
require_once 'src/models/players/getPlayersData.php';

/**
 * Retrieve a list of players based on selection criteria.
 *
 * Places the game identifier(s) in the $gameIds array :
 *      - if one game is selected : uses the given identifier.
 *      - if all selected games are chosen : calls `getGamesSelected` to retrieve their ids.
 *      - if all favorite games are chosen : calls `getFavoriteGames` to retrieve their ids.
 *
 * Then queries the 'gamesuser' table to find players who have the selected game(s)
 * marked as favorite, filtered by level if specified.
 *
 * Enriches each result with player data via `getPlayersData`
 * and game data via `getGameData`.
 *
 * @param string $gameSelected The selected game id, "*" for all selected games,
 *                             or "allFavorite" for all favorite games.
 * @param string $level        The required game level, or "*" for any level.
 * @param string $weekday      The day of the week (reserved for future filtering).
 * @param string $hour         The hour of play (reserved for future filtering).
 * @param string $age          The age range (reserved for future filtering).
 * @return array An array of matching players, each containing :
 *                  - 'idPlayer'     : Player's id.
 *                  - 'alias'        : Player's alias.
 *                  - 'ageRangeUser' : Player's age range.
 *                  - 'nameGame'     : Game name.
 *                  - 'platformGame' : Game platform.
 *                  - 'levelGame'    : Player's level for the game.
 *               Returns an empty array if no players are found.
 * @throws Exception If an error occurs during query preparation.
 * @throws Exception If an error occurs during query execution.
 */
function getPlayersSelected(string $gameSelected,
                            string $level,
                            string $weekday,
                            string $hour,
                            string $age): array {

    $connection = bddConnect();

    // Place the selected game id(s) in $gameIds
    if ($gameSelected === "*") {
        $gameIds = array_column(getGamesSelected(), 'idGame');
    } else if ($gameSelected === "allFavorite") {
        $gameIds = array_column(getFavoriteGames(), 'idGame');
    } else {
        $gameIds[] = $gameSelected;
    }

    // Generate placeholders for the IN clause
    $placeholders = implode(',', array_fill(0, count($gameIds), '?'));

    // Build query filtered by level if specified
    if ($level === "*") {
        $sql = "SELECT * FROM gamesuser WHERE idGame IN ($placeholders) AND favoriteGame = 1";
        $types = str_repeat('i', count($gameIds));
        $params = $gameIds;
    } else {
        $sql = "SELECT * FROM gamesuser WHERE idGame IN ($placeholders) AND favoriteGame = 1 AND levelGame = ?";
        $types = str_repeat('i', count($gameIds)) . 's';
        $params = array_merge($gameIds, [$level]);
    }

    $statement = $connection->prepare($sql);
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête.");
    }
    $statement->bind_param($types, ...$params);
    if (!$statement->execute()) {
        error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
        throw new Exception("Erreur lors de l'exécution de la requête.");
    }
    $result = $statement->get_result();

    // Place results in $foundPlayersList
    $foundPlayersList = [];
    while ($row = $result->fetch_assoc()) {
        $foundPlayersList[] = $row; 
    }

    // Free resources
    $result->free();
    $statement->close();
    $connection->close();

    if (empty($foundPlayersList)) {
        return [];
    }

    // Retrieve alias and age range for all found players
    $listPlayerData = getPlayersData($foundPlayersList);

    // For each found player, retrieve game data and merge with player data
    $listPlayerAndGameData = [];
    foreach ($foundPlayersList as $game) {
        $gameData = getGameData($game['idGame']);
        foreach ($listPlayerData as $player) {
            if ($player['id'] === $game['idUser']) {
                $listPlayerAndGameData[] = [
                    'idPlayer'     => $game['idUser'],
                    'alias'        => $player['alias'],
                    'ageRangeUser' => $player['ageRangeUser'],
                    'nameGame'     => $gameData['nameGame'],
                    'platformGame' => $gameData['platformGame'],
                    'levelGame'    => $game['levelGame'],
                ];
                break;
            }  
        }
    }

    return $listPlayerAndGameData;
}