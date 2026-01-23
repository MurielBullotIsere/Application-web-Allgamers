<?php 
/*==================== affichage de la landing page ====================*/
    $title="Accueil Allgamers"; //définir le titre de la page (url)
    $headerColor="orangeColor";
    $footer = "";
    $footerColor = "footerFirstPage";
    ob_start();                 // "mémorise" toute la sortie HTML qui suit car le contenu est trop grand pour être mis dans une variable
    require 'templates/components/headerDisplay.php';
?>

    <div class="allgamersHeader orangeColor"> 
        <h1>  </h1>
    </div>
<?php
    $header = ob_get_clean(); 


    ob_start();                 // "mémorise" toute la sortie HTML qui suit 
?>
    <div class="appliName orangeColor">
        <h1>Allgamers</h1>
    </div>
    <div class="logoArea orangeColor">
            <img src="templates\assets\pictures\manette21.jpg" class="gamepad"/>
    </div>
    <div class="buttonsArea orangeColor">
        <!-- bouton pour aller au formulaire de connection -->
        <form action="/jeuxVideoMuriel/index.php?action=connection" method="post">      <!-- envoie, par l'url, "action" avec une valeur -->
            <button type="submit" class="buttonLandingPage orangeColor">Connexion</button>
        </form>

        <!-- bouton pour aller au formulaire d'inscription -->
        <form action="/jeuxVideoMuriel/index.php?action=inscription" method="post">
            <button type="submit" class="buttonLandingPage orangeColor">Inscription</button>
        </form>
    </div>
<?php 
    $content = ob_get_clean();  // $content récupère le contenu généré 
    require 'templates/components/layout.php';       // on appelle layout qui se charge d'afficher la page 
?>

