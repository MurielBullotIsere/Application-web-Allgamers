<?php 
/**
 * Récupère et valide les données de connexion d'un utilisateur.
 * 
 * Cette fonction traite les données du formulaire de connexion, 
 *                vérifie l'existence de l'utilisateur en appelant la fonction `userExistence`, 
 *                met les données de l'utilisateur dans $_SESSION['userData'] et 
 *                gère la redirection vers la page principale en cas de succès,
 *                ou le chargement d'un formulaire pré rempli en cas d'échec.
 * 
 * $_SESSION['userData']['id',
 *                       'firstname',
 *                       'lastname',
 *                       'alias',
 *                       'passwordUser',
 *                       'email',
 *                       'ageRangeUser',
 *                       'csrf_token']
 *  
 * @param array $input Données provenant du formulaire de connexion `templates/userAuthentification/loginForm.php'
 *                                    ou du formulaire de connexion 'templates/userAuthentification/loginFormForCorrection.php'
 *                     Le tableau doit contenir les clés suivantes :
 *                     - 'alias' : Identifiant ou alias de l'utilisateur (string).
 *                     - 'passwordUser' : Mot de passe de l'utilisateur (string).
 * 
 * @throws Exception Si la requête n'est pas une requête POST.
 * @throws Exception Si les données du formulaire sont invalides (absence ou contenu vide des champs obligatoires).
 * 
 * @return void Redirige vers le controleur qui gère la page principale en cas de succès : 'src/controllers/pages/mainPageCtrl.php', 
 *           ou charge la page du formulaire pré rempli de connexion en cas d'échec : 'templates/userAuthentification/loginFormForCorrection.php'.
 */

require_once 'src/models/users/userExistence.php';

// récupère les données du formulaire qui vient de loginForm.php
function getUserData(array $input){
    // vérifie si la requête est une requête POST
    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($input['alias'], $input['passwordUser'])
                && $input['alias'] !== '' 
                && $input['passwordUser'] !== '') {
            $success = userExistence($input);  
            // vérifie que la lecture de l'enregistrement a été possible  
            if($success){
                $_SESSION['userData'] = $success;  // Stocker les données dans la session
                header("Location: index.php?action=mainPage");
                exit(); 
            }
            else {
                require 'templates/userAuthentification/loginFormForCorrection.php';
            }
        } else {
            throw new Exception('Les données du formulaire sont invalides.');
        }
    }
    else {
        throw new Exception("Ce n'est pas une requête POST");
    }
}

