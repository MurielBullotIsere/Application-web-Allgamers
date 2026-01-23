<?php

/**
 * Vérifie le token de l'utilisateur
 * 
 * compare le token stocké en session avec celui de la base de données.
 *
 * @return bool true si le token est valide, false sinon 
 * @throws Exception Si une erreur survient lors de la préparation de la requête.
 * @throws Exception Si une erreur survient lors de l'exécution de la requête.
 */
require_once 'src/models/database/databaseConnection.php';

function tokenValidityCheck() {
    $connection = bddConnect();
    $idUser = $_SESSION['userData']['id'] ?? null;
    $tokenOfSession = $_SESSION['userData']['csrf_token'] ?? null;

    // Validation des données de la session
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

    // Libération des ressources
    $result->free();
    $statement->close();
    $connection->close();
    
    // comparaison des 2 tokens, celui enregistré dans bdd et celui enregistré dans la session
    // Utilisation de hash_equals pour éviter les attaques par timing.
    return hash_equals($tokenOfSession, $tokenOfDatabase); 
}
    
