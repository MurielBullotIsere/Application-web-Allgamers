<?php
/**
 * récupérer la liste des jeux non séléctionnés
 * 
 * @return array Liste des jeux non sélectionnés.
*/
require_once 'getGamesSelected.php';
require_once 'getAllGames.php';

function getGamesSelectable(){
    $gamesSelected = getGamesSelected();
    $allGames = getAllGames();

    // Si aucun jeu n'est sélectionné, renvoyer tous les jeux
    if(empty($gamesSelected)) {
        return $allGames;
    }

    $gamesSelectable = [];
    // Récupérer les IDs des jeux déjà sélectionnés
    $selectedGameIds = array_column($gamesSelected, 'idGame'); 

    foreach ($allGames as $game) {
        // in_array vérifie si la valeur et le type de $game['id'] existe dans le tableau selectedGameIds.
        if (!in_array($game['id'], $selectedGameIds, true)) {
            $gamesSelectable[] = [
                'id' => $game['id'],
                'nameGame' => $game['nameGame'],
                'platformGame' => $game['platformGame'],
                'urlPictureGame' => $game['urlPictureGame']
            ];
        }
    }

    return $gamesSelectable;
}