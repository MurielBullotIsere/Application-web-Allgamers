<?php 
/*==================== affichage du formulaire de connection ====================*/
    $title="Formulaire de connexion";
    $headerColor="palegreyColor";
    $footer = "";

    ob_start();
    require 'templates/components/headerDisplay.php';
?>
    <div class="allgamersHeader palegreyColor"> 
        <form action="/jeuxVideoMuriel/index.php?action="  method="post">   
            <button type="submit"><img src="templates\assets\pictures\icons8-arrière-24.png" alt="retour à la page d'accueil"/></button>
        </form> 
        <h1>Allgamers</h1>
    </div>
<?php
    $header = ob_get_clean(); 
    

    ob_start();     // “memorizes” all the HTML output that follows.
?>

<div class="titlePage userForm">
    <h2>Connexion</h2>
</div>

<form action="/jeuxVideoMuriel/index.php?action=getUserData" class="userForm" method="post">   
    <label for="alias">Surnom :</label>
    <input type="text" id="alias" name="alias" required><br /><br />

    <label for="passwordUser">Mot de Passe :</label>
    <input type="password" autocomplete="off" id="passwordUser" name="passwordUser" required><br /><br />

    <button class="passwordForgotten" type="button" onclick="location.href='/jeuxVideoMuriel/index.php?action=passwordForgotten'">
        J'ai oublié mon mot de passe.
    </button><br /><br />

    <button class="navigationButton" type="submit">Je me connecte</button><br /><br /><br />
</form>

<h4>Pas encore de compte ? </h4>
<form action="/jeuxVideoMuriel/index.php?action=inscription"  class="userForm" method="post">   
    <button  class="navigationButton" type="submit">Je m'inscris</button>
</form> 


<?php 
    $content = ob_get_clean();  // $content retrieves the generated content
    require 'templates/components/layout.php'; 
?>