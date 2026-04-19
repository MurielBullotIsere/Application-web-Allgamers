<?php 

require_once 'src/models/database/tokenValidityCheck.php';

/**
 * Switch game list or store form values in $_SESSION['playerSelectionCriteria'].
 *
 * Validates the CSRF token and the HTTP method, then checks the values of
 * 'criteriaGamesSelected' and 'criteriaFavoriteGames' :
 *
 * - If one of them equals "0" (list switch request) :
 *      updates $_SESSION['playerSelectionCriteria']['list'] and redirects to the players page.
 * - Otherwise :
 *      stores the player selection criteria in $_SESSION['playerSelectionCriteria'] :
 *          - 'choice'       : "1" if the form is filled, "0" otherwise.
 *          - 'gameSelected' : "*" for all selected games,
 *                             "allFavorite" for all favorite games,
 *                             or a specific game id.
 *          - 'level'        : "*" for all levels,
 *                             or a game level (beginner, confirmed, expert, master).
 *          - 'weekday'      : "week" for all days,
 *                             or a specific day (monday, tuesday, wednesday, thursday, friday, saturday, sunday).
 *          - 'hour'         : "*" for all hours,
 *                             "allMorning" for hours between 1h and 12h,
 *                             "allAfternoon" for hours between 13h and 24h,
 *                             or a specific hour.
 *          - 'age'          : "range0" for all age ranges,
 *                             or a specific range (range1, range2, range3, range4).
 *
 * @param array $input Form data from templates/players/playersSelectedForm.php, must contain :
 *          - 'criteriaLevel'    : The game level to filter by (string).
 *          - 'criteriaWeekdays' : The availability day to filter by (string).
 *          - 'criteriaPeriod'   : The availability period (full day, morning, afternoon) (string).
 *          - 'criteriaAge'      : The age range to filter by (string).
 *      And, depending on $_SESSION['playerSelectionCriteria']['list'] :
 *          - 'criteriaGamesSelected' : game id from the user's selected games list (list = "1").
 *          - 'criteriaFavoriteGames' : game id from the user's favorite games list (list = "2").
 *      And, depending on 'criteriaPeriod' :
 *          - 'criteriaHourAM' : an hour between 1h and 12h (string).
 *          - 'criteriaHourPM' : an hour between 13h and 24h (string).
 *
 * @throws Exception If the request method is not POST.
 * @throws Exception If form data is invalid (missing or empty values).
 * @return void Redirects to index.php?action=playersPage on success,
 *              or terminates with die() if the CSRF token is invalid.
 */

function playerSelectionFormFilled(array $input){
    $rightUser = tokenValidityCheck();
    if (!$rightUser) {
        die("Invalid CSRF token");
    }
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Selected list: Games selected by the user
        if ($_SESSION['playerSelectionCriteria']['list'] === "1"){
            if (isset($input['criteriaGamesSelected']) && $input['criteriaGamesSelected'] !== '') {
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
        // Selected list: games in the user's favorites
        else if ($_SESSION['playerSelectionCriteria']['list'] === "2"){
            if (isset($input['criteriaFavoriteGames']) && $input['criteriaFavoriteGames'] !== '') {
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

        // define simple criteria
        if (isset($input['criteriaLevel'], $input['criteriaWeekdays'], $input['criteriaPeriod'], $input['criteriaAge'])
          && $input['criteriaLevel'] !== '' 
          && $input['criteriaWeekdays'] !== ''
          && $input['criteriaPeriod'] !== ''
          && $input['criteriaAge'] !== '') {
            $_SESSION['playerSelectionCriteria']['level'] = $input['criteriaLevel'];
            $_SESSION['playerSelectionCriteria']['weekday'] = $input['criteriaWeekdays'];
            $_SESSION['playerSelectionCriteria']['age'] = $input['criteriaAge'];        
        } 
        else {
            throw new Exception('Les données du formulaire sont invalides.');
        }

        // set the time according to the selected time period
        if ($input['criteriaPeriod'] === '*') {
            $_SESSION['playerSelectionCriteria']['hour'] = "*";
        } 
        if ($input['criteriaPeriod'] === 'morning') {
            if (isset($input['criteriaHourAM']) && $input['criteriaHourAM'] !== '') {
                $_SESSION['playerSelectionCriteria']['hour'] = $input['criteriaHourAM'];
            }
            else {
                throw new Exception('Les données du formulaire sont invalides.');
            }
        }
        if ($input['criteriaPeriod'] === 'afternoon') {
            if (isset($input['criteriaHourPM']) && $input['criteriaHourPM'] !== '') {
                $_SESSION['playerSelectionCriteria']['hour'] = $input['criteriaHourPM'];
            }
            else {
                throw new Exception('Les données du formulaire sont invalides.');
            }
        }

        $_SESSION['playerSelectionCriteria']['choice'] = "1";
        header("Location: index.php?action=playersPage");
        exit(); 
    }
    else {
        throw new Exception("Ce n'est pas une requête POST");
    }
}