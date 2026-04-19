<?php

require_once 'src/models/database/databaseConnection.php';

/**
 * Check the user's CSRF token.
 *
 * Compares the token stored in the session with the one stored in the database.
 *
 * @return bool True if the token is valid, false otherwise.
 * @throws Exception If the session data or token is missing.
 * @throws Exception If an error occurs during query preparation.
 * @throws Exception If an error occurs during query execution.
 * @throws Exception If no user or more than one user is found.
 */
function tokenValidityCheck(): bool {
    $connection = bddConnect();
    $idUser = $_SESSION['userData']['id'] ?? null;
    $tokenOfSession = $_SESSION['userData']['csrf_token'] ?? null;

    if (!$idUser || !$tokenOfSession) {
        throw new Exception("Les informations utilisateur ou le token de session sont manquants.");
    }

    $sql = "SELECT token FROM user WHERE id = ?";
    $statement = $connection->prepare($sql); 
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête : ");
    }
    $statement->bind_param("s", $idUser); 
    if (!$statement->execute()) {
        error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
        throw new Exception("Erreur lors de l'exécution de la requête : ");
    }
    $result = $statement->get_result();

    if($result->num_rows !== 1){
        throw new Exception("Aucun utilisateur trouvé ou plusieurs utilisateurs trouvés");
    }
    
    $row = $result->fetch_assoc();
    $tokenOfDatabase = $row['token'];

    $result->free();
    $statement->close();
    $connection->close();
    
    // Uses hash_equals to prevent timing attacks.
    return hash_equals($tokenOfSession, $tokenOfDatabase); 
}
    
