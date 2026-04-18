<?php 
/**
 * Enregistrement des données de l'utilisateur. 
 *
 * Cette fonction effectue la vérification de validité de la robustesse du mot de passe via la fonction 'checkPasswordStrength' et 
 *                redirige l'utilisateur vers la page de connexion pré remplie si la vérification est un échec,
 *                vérifie que la création du joueur dans la base de données a été possible via la fonction 'createUserData' et
 *                redirige l'utilisateur vers la page de connexion pré remplie si la création de l'utilisateur est un échec,
 *                redirige l'utilisateur vers la page de première utilisation si les vérification sont un succès.
 *
 * @param array $input Données provenant du formulaire, incluant :
 *                     - 'firstName' : Prénom du joueur (string, obligatoire).
 *                     - 'lastName' : Nom du joueur (string, obligatoire).
 *                     - 'alias' : Pseudonyme unique du joueur (string, obligatoire).
 *                     - 'ageRange' : Tranche d'âge du joueur (string, obligatoire).
 *                     - 'adMail' : Adresse e-mail du joueur (string, obligatoire).
 *                     - 'passwordUser' : Mot de passe choisi par le joueur (string, obligatoire).
 * 
 * @throws Exception Si la requête n'est pas de type POST.
 * @throws Exception Si les données du formulaire sont invalides (champs manquants ou vides).
 *
 * @return void Redirige vers :
 *     - Redirige vers le controleur qui gère la page de première utilisation en cas de succès : 'src/controllers/pages/firstConnectionCtrl.php'
 *     - Charge la page du formulaire pré rempli d'enregistrement si le pseudonyme est déjà utilisé : 'templates/userAuthentification/aliasAlreadyTaken.php'
 *     - Charge la page du formulaire pré rempli d'enregistrement si le mot de passe n'est pas suffisamment robuste : 'templates/userAuthentification/passwordNotStrong.php'
 */




require_once('src/models/users/createUserData.php');
require_once('src/models/users/checkPasswordStrength.php');

// récupère les données du formulaire qui vient de registrationForm.php
function createUser(array $input){
    // vérifie que la requête est une requête POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if (isset($input['firstName'], $input['lastName'], $input['alias'],
                  $input['ageRange'], $input['adMail'], $input['passwordUser'])
                && $input['firstName'] !== '' 
                && $input['lastName'] !== '' 
                && $input['alias'] !== ''
                && $input['ageRange'] !== '' 
                && $input['adMail'] !== '' 
                && $input['passwordUser'] !== '') {
            // vérifie que le mot de passe est robuste
            if (checkPasswordStrength($input['passwordUser'])){ 
                $success = createUserData($input);
                // vérifie que les données sont bien enregistrées
                if ($success) {
                    $_SESSION['userData'] = $success;  // Stocker les données dans la session
                    header("Location: index.php?action=firstConnection");
                    exit(); 
                } 
                else {
                    require 'templates/userAuthentification/aliasAlreadyTaken.php';
                }
            }
            else {
                require 'templates/userAuthentification/passwordNotStrong.php';
            }
        } 
        else {
            throw new Exception('Les données du formulaire sont invalides.');
        }
    }
    else {
        throw new Exception("Ce n'est pas une requête POST");
    }
}

