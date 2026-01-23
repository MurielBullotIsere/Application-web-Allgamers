<?php
/**
 * Crée un utilisateur dans la table user si l'alias n'existe pas encore.
 *
 * @param array $input Données d'entrée provenant du formulaire registrationForm.
 * @return array Données utilisateur insérées ou tableau vide si l'alias existe déjà.
 * @throws Exception Si une erreur survient lors de la préparation de la requête.
 * @throws Exception Si une erreur survient lors de l'exécution de la requête.
 */

require_once 'src/models/database/databaseConnection.php';
require_once 'src/models/users/getAlias.php'; 
require_once 'src/models/users/createUniqueId.php';

function createUserData(array $input) {
    $aliasExist = getAlias($input['alias']);

    if($aliasExist){ return [];}

    $id = createUniqueId();
    $hashedPassword = password_hash($input['passwordUser'], PASSWORD_DEFAULT);
    $token = bin2hex(random_bytes(32)); 
    $data = [
        'id' => $id,
        'firstname' => $input['firstName'],
        'lastname' => $input['lastName'],
        'alias' =>  $input['alias'],
        'passwordUser' => $hashedPassword,
        'email' => $input['adMail'],
        'ageRangeUser' => $input['ageRange'],
        'csrf_token' => $token,
    ];

    $connection = bddConnect();

    $sql = "INSERT INTO user(id, firstname, lastname, alias, passwordUser, email, ageRangeUser, token) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
    $statement = $connection->prepare($sql);
    if (!$statement) {
        error_log("Erreur de préparation de la requête : " . $connection->error);
        throw new Exception("Échec de la préparation de la requête : ");
    }
    $statement->bind_param("ssssssss", 
                            $id, $data['firstname'], 
                            $data['lastname'], 
                            $data['alias'], 
                            $hashedPassword, 
                            $data['email'], 
                            $data['ageRangeUser'],
                            $token);
    if (!$statement->execute()) {
        error_log("Erreur lors de l'exécution de la requête : " . $statement->error);
        throw new Exception("Erreur lors de l'exécution de la requête : ");
    }

    // Libération des ressources
    $statement->close();
    $connection->close();
    
    return $data;
}

