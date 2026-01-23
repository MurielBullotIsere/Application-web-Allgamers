<?php 
/*==================== affichage du formulaire d'inscription pré-rempli
                                          et demande de changer l'alias ====================
*/
    $title="Formulaire d'inscription";
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
    

    ob_start();  
?>

<div class="titlePage userForm">
    <h2>Inscription</h2>
</div>
<form action="/Application-web-Allgamers/index.php?action=createUser" class="userForm" method="post">   
    <h5 class="tips">Tous les champs sont obligatoires.</h5>
    <label for="firstName">Prénom :</label>
    <input type="text" id="firstName" name="firstName" value="<?php echo htmlspecialchars($input['firstName']); ?>" required/><br><br> 

    <label for="lastName">Nom :</label>
    <input type="text" id="lastName" name="lastName" value="<?php echo htmlspecialchars($input['lastName']); ?>" required/><br><br>

    <p class="retry"></p>
    <label for="alias">Surnom :</label>
    <input type="text" id="alias" name="alias" value="<?php echo htmlspecialchars($input['alias']); ?>" required autofocus/><br><br>

    <label for="ageRange">Age :</label>
    <select id="ageRange" name="ageRange" >
        <option value = "range1"<?php if ($input['ageRange'] == "range1") {echo "selected";} ?>>18-29 ans</option>
        <option value = "range2" <?php if ($input['ageRange'] == "range2") {echo "selected";} ?>>30-44 ans</option>
        <option value = "range3" <?php if ($input['ageRange'] == "range3") {echo "selected";} ?>>45-59 ans</option>
        <option value = "range4" <?php if ($input['ageRange'] == "range4") {echo "selected";} ?>>60 ans et plus</option>
    </select><br><br>  

    <label for="adMail">Adresse mail :</label>
    <input type="email" id="adMail" name="adMail" value="<?php echo htmlspecialchars($input['adMail']); ?>" required/><br><br>

    <label for="passwordUser">Mot de Passe :</label>
    <input type="password" autocomplete="off" id="passwordUser" name="passwordUser" value="<?php echo htmlspecialchars($input['passwordUser']); ?>" required/><br><br>

    <button class="navigationButton" type="submit">Je valide</button><br><br><br><br><br><br><br><br><br>
</form>


<!-- mettre le curseur à la fin de la valeur se trouvant dans le champ -->
<script>
    // afficher un message d'erreur
    let errorRetry = document.querySelector(".retry");      // selectionne l'élément class="retry" de ce document
    errorRetry.textContent = "Ce surnom est déjà pris, veuillez en changer s'il vous plait.";

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