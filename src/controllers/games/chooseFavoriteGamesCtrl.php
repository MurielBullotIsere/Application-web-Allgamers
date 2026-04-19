<?php 

require_once 'src/models/database/tokenValidityCheck.php';

/**
 * Save the player's selection criteria: favorite games.
 *
 * Validates the CSRF token and the HTTP method before saving
 * the player's selection criteria in the session.
 * Sets $_SESSION['playerSelectionCriteria']['list'] to "2",
 * which corresponds to the "favorite games" filter.
 *
 * @throws Exception If the request method is not POST.
 * @return void Redirects to index.php?action=playersPage on success,
 *              or terminates with die() if the CSRF token is invalid.
 */
function chooseFavoriteGames(): void {
    $rightUser = tokenValidityCheck();
    if (!$rightUser) {
        die("Invalid CSRF token");
    }

    if ($_SERVER["REQUEST_METHOD"] !== "POST") {
        throw new Exception("Ce n'est pas une requête POST");
    }

    $_SESSION['playerSelectionCriteria']['list'] = "2";
    
    header("Location: index.php?action=playersPage");
    exit(); 
}
