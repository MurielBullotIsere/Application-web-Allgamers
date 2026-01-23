<?php
/**
 * Generates a unique user ID.
 * 
 * The function connects to the database,
 * generates an ID,
 * checks if the generated ID is unique, 
 * and repeats the process until a unique ID is found.
 *
 * @throws Exception If there is an error in query preparation.
 * @throws Exception If there is an error in execution.
 * @return string A unique user ID.
 */
require_once 'src/models/database/databaseConnection.php';

function createUniqueId() {
    $connection = bddConnect();

    $sql = "SELECT id FROM user WHERE id = ?";
    $statement = $connection->prepare($sql);    
    if (!$statement) {
    error_log("Erreur de préparation de la requête : " . $connection->error);
    throw new Exception("Échec de la préparation de la requête : ");
    }

    $idIsUnique = false;
    $id = '';

    while(!$idIsUnique){
        $id = uniqid();         // Generate a unique ID

        $statement->bind_param("s", $id);
        if (!$statement->execute()) {
            error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
            throw new Exception("Erreur lors de l'exécution de la requête : ");
        }
        $result = $statement->get_result();
    
        // If no record is found, the ID is unique
        $idIsUnique = ($result->num_rows === 0);
    }

    // Free result and close connections to prevent memory leaks    
    $result->free();
    $statement->close();
    $connection->close();
    
    return $id;
}