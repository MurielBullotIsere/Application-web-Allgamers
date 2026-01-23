<?php 
/*==================== affichage du formulaire pour finaliser l'inscription ====================
    ces informations ne sont pas obligatoires     
*/

    $title="Formulaire pour finaliser l'inscription";
    $headerColor="palegreyColor";
    $footer = "";
    $footerColor = "footerNewUserMainPage";

    ob_start();
    require 'templates/components/headerDisplay.php';
?>
    <div class="allgamersHeader palegreyColor"> 
        <h1 class="titleAlone">Allgamers</h1>
    </div>
<?php
    $header = ob_get_clean(); 


    ob_start(); 
?>

<div class="titlePage gamesForm">
    <h2>Bienvenue
        <p class="aliasDisplay"></p>
    </h2>
</div>


<form action="/Application-web-Allgamers/index.php?action=newGameSelected" class="gamesForm" method="post">   
    <h3>Commençons par lister les jeux auxquels vous jouez :</h3><br />
    <div class="gameLabelAndSelect">
        <select id="chooseAGame" name="chooseAGame" required>
            <option value = "" disabled selected >-- Choisissez un jeu --</option>
            <!-- afficher les options dans la liste déroulante -->
            <?php 
            foreach ($listOfGamesSelectable as $value) { ?>
                <option class="menuDeroulant" value="<?= htmlspecialchars($value['id']) ?>">
                <?=htmlspecialchars($value['nameGame']) ?> (
                <?=htmlspecialchars($value['platformGame']) ?>)</option>
            <?php } ?>
        </select>  
    </div>

    <div class="gameLabelAndSelect">
        <label for="levelGame">Niveau :</label>
        <select id="levelGame" name="levelGame" >
            <option value = "beginner">débutant</option>
            <option value = "confirmed">confirmé</option>
            <option value = "expert">expert</option>
            <option value = "master">maître</option>
        </select>
    </div>

    <div class="gameLabelAndSelect">
        <label for="favoriteGame">favori :</label>
        <select id="favoriteGame" name="favoriteGame" >
            <option value = "0" >non</option>
            <option value = "1" >oui</option>
        </select>
    </div>

    <button type="submit">Enregistrer votre choix</button><br><br>
</form>


<!--********************************* bouton pour quitter la page sans enregistrer *******************************-->
<form action="/Application-web-Allgamers/index.php?action=mainPage" method="post">   
    <h3>Vous pourrez aussi le faire plus tard.</h3><br>
    <button class="navigationButton" type="submit">Quitter la page</button><br><br>
</form> 
                
<!--********************************** ajouter le surnom dans l'entête *******************************-->
<script>
    document.querySelector(".aliasDisplay").textContent =  
        "<?php echo htmlspecialchars($_SESSION['userData']['alias']); ?>";     // me permettra de mettre du CSS sur le texte ajouté
</script>

<?php 
    // Inclusion des jeux sélectionnés
    require 'templates/games/gamesSelectedDisplay.php';
    
    $content = ob_get_clean();  // $content récupère le contenu généré
    require 'templates/components/layout.php'; 
?>