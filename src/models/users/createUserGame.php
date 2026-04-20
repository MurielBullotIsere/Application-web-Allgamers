<?php

require_once 'src/models/database/databaseConnection.php';
require_once 'src/models/users/getUserGames.php';

/**
 * Saves a game selection for the current user in the `gamesuser` table.
 *
 * Retrieves the user ID from the session, checks that the user-game
 * combination does not already exist via getUserGames(), then inserts
 * the new record into the database.
 *
 * @param array $input Form data from templates/pages/newUserPage.php,
 *                     must contain:
 *                          - 'chooseAGame'  : The selected game's ID (string).
 *                          - 'levelGame'    : The user's level for this game (string).
 *                          - 'favoriteGame' : Whether the game is a favorite, "0" or "1" (string).
 *
 * @throws Exception If the user-game combination already exists in the database.
 * @throws Exception If query preparation fails.
 * @throws Exception If query execution fails.
 * @return array The inserted data, containing:
 *                          - 'idUser'       : The user's ID (string).
 *                          - 'idGame'       : The game's ID (string).
 *                          - 'levelGame'    : The user's level for this game (string).
 *                          - 'favoriteGame' : Whether the game is a favorite, "0" or "1" (string).
 *
 * @example
 *      $data = createUserGame($_POST);
 */
function createUserGame(array $input): array
{
    $data = [
        'idUser'       => $_SESSION['userData']['id'],
        'idGame'       => $input['chooseAGame'],
        'levelGame'    => $input['levelGame'],
        'favoriteGame' => $input['favoriteGame'],
    ];

    $existingRecord = getUserGames($data['idUser'], $data['idGame']);
    if ($existingRecord) {
        throw new Exception("Cet enregistrement utilisateur-jeu existe déjà.");
    }

    $connection = bddConnect();

    $sql = "INSERT INTO gamesuser (idUser, idGame, levelGame, favoriteGame)
            VALUES (?, ?, ?, ?)";
    $statement = $connection->prepare($sql);
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête.");
    }

    $statement->bind_param(
        "ssss",
        $data['idUser'],
        $data['idGame'],
        $data['levelGame'],
        $data['favoriteGame']
    );
    if (!$statement->execute()) {
        error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
        throw new Exception("Erreur lors de l'exécution de la requête.");
    }

    $statement->close();
    $connection->close();

    return $data;
}