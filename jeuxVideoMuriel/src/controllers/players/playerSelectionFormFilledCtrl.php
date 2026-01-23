<?php 
/**
 *      change de liste de jeux 
 *   ou stocke les valeurs du formulaire dans $_SESSION['playerSelectionCriteria`]
 *
 * Cette fonction vérifie la valeur de 'criteriaGamesSelected' et celle de 'criteriaFavoriteGames',
 * si une des deux vaut "0" (demande de changement de liste) alors 
 *      la fonction change la valeur de  $_SESSION['playerSelectionrCiteria']['list'] 
 *      et redirige vers la page qui gère la section 'joueur'.
 * sinon
 *      la fonction enregistre les critères de sélection de l'utilisateur
 *                en remplissant $_SESSION['playerSelectionrCiteria'].
 * 
 *      Ces critères deviennent :
 *      - 'choice' : "1" pour signaler que le formulaire est rempli, "0" si non rempli
 *      - 'gameSelected' : soit "*" pour sélectionner tous les jeux de la liste des jeux sélectionnés,
 *                         soit "allFavorite" pour sélectionner tous les jeux de la liste des jeux favoris,
 *                         soit l'id d'un jeu.
 *      - 'level' : soit "*" pour sélectionner tous les niveaux
 *                  soit un niveau de jeu (beginner, confirmed, expert, master).
 *      - 'weekday' : soit "week" pour tous les jours,
 *                    soit un jour de la semaine (monday, tuesday, wednesday, thursday, friday, saturday, sunday).
 *      - 'hour' : soit "*" pour toutes les heures
 *                 soit "allMorning" pour toutes les heures entre 1h et 12h,
 *                 soit "allAfternoon" pour toutes les heures entre 13h et 24h,
 *                 soit une heure précise.
 *      - 'age' : soit "range0" pour sélectionner toutes les tranches d'âge
 *                soit une tranche d'age (range1, range2, range3, range4)
 *
 *                et charge et affiche la page qui gère la section "joueurs".
 * 
 * @param array $input provenant du formulaire templates\players\playersSelectedForm.php, 
 * contenant obligatoirement :
 *          - 'criteriaLevel' : Le niveau de jeu du joueur à sélectionner (string).
 *          - 'criteriaWeekdays' : le jour de disponibilité du joueur à sélectionner (string).
 *          - 'criteriaPeriod' : la période de disponibilité  (journée, matin, après-midi) du joueur à sélectionner (string).
 *          - 'criteriaAge' : la tranche d'âge du joueur à sélectionner (string).
 * contenant, selon la valeur de $_SESSION['playerSelectionCriteria']['list'] :
 *          soit - 'criteriaGamesSelected' : L'id du jeu sélectionné parmi la liste des jeux sélectionnés par l'utilisateur (number)('list' = "1") ou tous les jeux.
 *          soit - 'criteriaFavoriteGames' : L'id du jeu sélectionné parmi la liste des jeux favoris de l'utilisateur (number)('list' = "2"). ou tous les jeux
 * contenant, selon la valeur de 'criteriaPeriod' :
 *          soit - 'criteriaHourAM' : une heure entre 1h et 12h (string). 
 *          soit - 'criteriaHourPM' : une heure entre 13h et 24h (string). 
 *
 * @throws Exception Si la requête n'est pas de type POST.
 * @throws Exception si les données du formulaire sont invalides.
 * @return void charge la page qui gère la section 'joueurs' : 'templates\pages\playersPage.php'.
 */
require_once 'src\models\database\tokenValidityCheck.php';


function playerSelectionFormFilled(array $input){
    $rightUser = tokenValidityCheck();
    if (!$rightUser) {
        die("Invalid CSRF token");
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // liste choisie : jeux sélectionnés
        if ($_SESSION['playerSelectionCriteria']['list'] === "1"){
            // si les variables existent et ne sont pas vide
            if (isset($input['criteriaGamesSelected']) && $input['criteriaGamesSelected'] !== '') {
                // si demande de changement de liste :
               if ($input['criteriaGamesSelected'] === "0"){
                    $_SESSION['playerSelectionCriteria']['list'] = "2";
                    $_SESSION['playerSelectionCriteria']['choice'] = "0";
                    header("Location: index.php?action=playersPage");
                    exit(); 
                }
                else {
                    $_SESSION['playerSelectionCriteria']['gameSelected'] = $input['criteriaGamesSelected'];
                }
            }
            else {
                throw new Exception('Les données du formulaire sont invalides.');
            }
        }
        // liste choisie : jeux favoris
        else if ($_SESSION['playerSelectionCriteria']['list'] === "2"){
            if (isset($input['criteriaFavoriteGames']) && $input['criteriaFavoriteGames'] !== '') {
                // si demande de changement de liste :
                if ($input['criteriaFavoriteGames'] === "0"){
                    $_SESSION['playerSelectionCriteria']['list'] = "1";
                    $_SESSION['playerSelectionCriteria']['choice'] = "0";
                    header("Location: index.php?action=playersPage");
                    exit(); 
                }
                else {
                    $_SESSION['playerSelectionCriteria']['gameSelected'] = $input['criteriaFavoriteGames'];
                }
            }
            else {
                throw new Exception('Les données du formulaire sont invalides.');
            }
        }

        // définir les critères simples (qui ne dépendent pas d'un choix préalable)
        if (isset($input['criteriaLevel'], $input['criteriaWeekdays'], $input['criteriaPeriod'], $input['criteriaAge'])
          && $input['criteriaLevel'] !== '' 
          && $input['criteriaWeekdays'] !== ''
          && $input['criteriaPeriod'] !== ''
          && $input['criteriaAge'] !== '') {
            // définir le niveau
            $_SESSION['playerSelectionCriteria']['level'] = $input['criteriaLevel'];
            // définr le jour
            $_SESSION['playerSelectionCriteria']['weekday'] = $input['criteriaWeekdays'];
            // définir l'âge
            $_SESSION['playerSelectionCriteria']['age'] = $input['criteriaAge'];        
        } 
        else {
            throw new Exception('Les données du formulaire sont invalides.');
        }

        // définir l'heure selon la période choisie
        // toute la journée
        if ($input['criteriaPeriod'] === '*') {
            $_SESSION['playerSelectionCriteria']['hour'] = "*";
        } 
        // le matin
        if ($input['criteriaPeriod'] === 'morning') {
            if (isset($input['criteriaHourAM']) && $input['criteriaHourAM'] !== '') {
                $_SESSION['playerSelectionCriteria']['hour'] = $input['criteriaHourAM'];
            }
            else {
                throw new Exception('Les données du formulaire sont invalides.');
            }
        }
        // l'après-midi
        if ($input['criteriaPeriod'] === 'afternoon') {
            if (isset($input['criteriaHourPM']) && $input['criteriaHourPM'] !== '') {
                $_SESSION['playerSelectionCriteria']['hour'] = $input['criteriaHourAM'];
            }
            else {
                throw new Exception('Les données du formulaire sont invalides.');
            }
        }

        // prévenir que le formulaire est rempli        
        $_SESSION['playerSelectionCriteria']['choice'] = "1";
        header("Location: index.php?action=playersPage");
        exit(); 
    }
    else {
        throw new Exception("Ce n'est pas une requête POST");
    }
}