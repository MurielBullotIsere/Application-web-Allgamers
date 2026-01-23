<?php 
/*==================== affichage du formulaire de connection pré-rempli====================*/
    $title="Formulaire de connexion";
    $headerColor="palegreyColor";
    $footer = "";

    ob_start();
    require 'templates/components/headerDisplay.php';
?>
    <div class="allgamersHeader palegreyColor"> 
        <form action="/Application-web-Allgamers/index.php?action="  method="post">   
            <button type="submit"><img src="templates\assets\pictures\icons8-arrière-24.png" alt="retour à la page d'accueil"/></button>
        </form> 
        <h1>Allgamers</h1>
    </div>
<?php
    $header = ob_get_clean(); 
    

    ob_start();     // "mémorise" toute la sortie HTML qui suit.
?>

<div class="titlePage userForm">
    <h2>Connexion</h2>
</div>

<form action="/Application-web-Allgamers/index.php?action=getUserData" class="userForm" method="post">   
    <p class="retry"></p>
    <label for="alias">Surnom :</label>
    <input type="text" id="alias" name="alias" value="<?php echo htmlspecialchars($input['alias']); ?>" required autofocus/><br><br>

    <label for="passwordUser">Mot de Passe :</label>
    <input type="password" autocomplete="off" id="passwordUser" name="passwordUser" value="<?php echo htmlspecialchars($input['passwordUser']); ?>" required/><br><br>

    <button class="passwordForgotten" type="button" onclick="location.href='/Application-web-Allgamers/index.php?action=passwordForgotten'">
        J'ai oublié mon mot de passe.
    </button><br /><br />

    <button class="navigationButton" type="submit">Je me connecte</button><br /><br /><br />
</form>

<h4>Pas encore de compte ? </h4>
<form action="/Application-web-Allgamers/index.php?action=inscription"  class="userForm" method="post">   
    <button  class="navigationButton" type="submit">Je m'inscris</button>
</form> 

<script>
    // afficher un message d'erreur
    let errorRetry = document.querySelector(".retry");               // selectionne l'élément class="retry" de ce document
    errorRetry.textContent = "Surnom ou mot de passe incorrect";     // me permettra de mettre du CSS sur le texte ajouté

    // mettre le curseur à la fin de la valeur se trouvant dans le champs 'alias'
    // window.onload : garantit que le script s'exécute après que la page a été entièrement chargée.
    window.onload = function() {
        const aliasInput = document.getElementById('alias');
        if (aliasInput) {
            aliasInput.focus();                             // Met le focus sur le champ
            const length = aliasInput.value.length;         // Longueur du texte
            aliasInput.setSelectionRange(length, length);   // Place le curseur à la fin
        }
    };

</script>

<?php 
    $content = ob_get_clean();  // $content récupère le contenu généré
    require 'templates/components/layout.php'; 
?>