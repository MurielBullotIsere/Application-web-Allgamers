<?php
/**
 * Rechercher les données dans la table `user`.
 *
 * @param array Données d'entrée provenant du formulaire.
 * @return array|null Tableau des données si trouvé, sinon null.
 */
require_once 'src/models/users/getAlias.php';
require_once 'src/models/database/updateToken.php';

// $input contient les deux champs du loginForm ($_POST)
function userExistence(array $input) {
    $aliasExist = getAlias($input['alias']);
    $data = [];
    if($aliasExist){
        $hashedPassword = $aliasExist['passwordUser'];
        if(password_verify($input['passwordUser'], $hashedPassword)){
            $token = bin2hex(random_bytes(32));  
            $data = [
                'id' => $aliasExist['id'],
                'firstname' => $aliasExist['firstname'],
                'lastname' => $aliasExist['lastname'],
                'alias' =>  $aliasExist['alias'],
                'passwordUser' => $aliasExist['passwordUser'],
                'email' => $aliasExist['email'],
                'ageRangeUser' => $aliasExist['ageRangeUser'],
                'csrf_token' => $token,
            ];

            updateToken($token, $aliasExist['id']);
        }
    }
    return $data;
}
    
