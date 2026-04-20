<?php

require_once 'getGamesSelected.php';
require_once 'getAllGames.php';

/**
 * Retrieve the list of games not yet selected by the user.
 *
 * Compares all games with the user's selected games
 * and returns only those that have not been selected yet.
 *
 * @return array An array of selectable games, each containing :
 *                  - 'id'            : Game id.
 *                  - 'nameGame'      : Game name.
 *                  - 'platformGame'  : Game platform.
 *                  - 'urlPictureGame': Game picture URL.
 *               Returns all games if none have been selected yet.
 */
function getGamesSelectable(): array {
    $gamesSelected = getGamesSelected();
    $allGames = getAllGames();

    // If no games are selected yet, return all games
    if (empty($gamesSelected)) {
        return $allGames;
    }

    // Retrieve the ids of already selected games
    $selectedGameIds = array_column($gamesSelected, 'idGame'); 

    $gamesSelectable = [];
    foreach ($allGames as $game) {
        // in_array with strict mode (true) checks both value and type
        if (!in_array($game['id'], $selectedGameIds, true)) {
            $gamesSelectable[] = [
                'id'             => $game['id'],
                'nameGame'       => $game['nameGame'],
                'platformGame'   => $game['platformGame'],
                'urlPictureGame' => $game['urlPictureGame'],
            ];
        }
    }

    return $gamesSelectable;
}