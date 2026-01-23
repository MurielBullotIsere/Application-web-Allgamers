<h3>Recherche de joueurs :</h3><br/>
    
<!-- texte rempli selon le contexte (aucune liste, une seule liste ou 2 listes-->
<label class="textWhichList"></label><br/>
<label class="textLabel"></label>

<!-- choix des listes à affichées (aucune, une seule, demande de choisir parmi deux) -->
<?php 
// si l'utilisateur a sélectionné au moins 1 jeu et si aucun choix n'est fait parmi les deux listes
if (!empty($listOfGamesSelected) && $_SESSION['playerSelectionCriteria']['list'] === "0") { 
    // si aucun jeu favori, afficher la liste des jeux sélectionnés
    if (empty($listOfFavoriteGames)) { 
        $_SESSION['playerSelectionCriteria']['list'] = "1";
    } 
    // si l'utilisateur a sélectionné au moins 1 jeu favori, afficher un choix à faire entre les 2 listes -->
    else { ?> 
        <div class="twoChoices">
            <form action="/jeuxVideoMuriel/index.php?action=chooseGamesSelected"  method="post">
                <button class="twoChoicesButton" type="submit">Choisir parmi vos jeux sélectionnés</button><br>
            </form>
            <form action="/jeuxVideoMuriel/index.php?action=chooseFavoriteGames"  method="post">
                <button class="twoChoicesButton" type="submit">Choisir parmi vos jeux favoris</button><br>
            </form>
        </div>
<?php     } 
} ?>

<!-- affichage du formulaire -->
<form action="/jeuxVideoMuriel/index.php?action=playerSelectionFormFilled"  class="gamesForm" method="post">
    <?php
    // afficher le menu déroulant des jeux sélectionnés
    if ($_SESSION['playerSelectionCriteria']['list'] === "1") {  ?>
        <select id="criteriaGamesSelected" name="criteriaGamesSelected">
            <option value="*">Tous les jeux sélectionnés</option>
            <!-- afficher l'option seulement si il existe des jeux favoris -->
            <?php if (!empty($listOfFavoriteGames)) {  ?>
            <option value="0">Changer de liste</option>
            <?php 
            }

            foreach ($listOfGamesSelected as $value) { ?>
                <option value="<?= htmlspecialchars($value['idGame']) ?>">
                <?= htmlspecialchars($value['nameGame']) ?> (
                <?= htmlspecialchars($value['platformGame']) ?>)</option>
        <?php } ?>
        </select>
    <?php
    }

    // afficher le menu déroulant des jeux favoris
    if ($_SESSION['playerSelectionCriteria']['list'] === "2") {  ?>
        <select id="criteriaFavoriteGames" name="criteriaFavoriteGames">
            <option value="allFavorite">Tous les jeux favoris</option>
            <option value="0">Changer de liste</option>
            <?php 
            foreach ($listOfFavoriteGames as $value) { ?>
                <option value="<?= htmlspecialchars($value['idGame']) ?>">
                <?= htmlspecialchars($value['nameGame']) ?> (
                <?= htmlspecialchars($value['platformGame']) ?>)</option>
        <?php } ?>
        </select>

        <?php
    }

    // afficher la suite du formulaire 
    if ($_SESSION['playerSelectionCriteria']['list'] !== "0") {  ?>

        <!-- choisir un niveau -->
        <label for="criteriaLevel">Choisissez un niveau de jeu :</label>
        <select id="criteriaLevel" name="criteriaLevel" >
            <option value = "*">Tous</option>
            <option value = "beginner">débutant</option>
            <option value = "confirmed">confirmé</option>
            <option value = "expert">expert</option>
            <option value = "master">maître</option>
        </select> 

        <!-- choisir un jour de la semaine-->
        <label for="criteriaWeekdays">Choisissez un jour de la semaine :</label>
        <select id="criteriaWeekdays" name="criteriaWeekdays" >
            <option value = "week">Tous les jours</option>
            <option value = "monday">lundi</option>
            <option value = "tuesday">mardi</option>
            <option value = "wednesday">mercredi</option>
            <option value = "thursday">jeudi</option>
            <option value = "friday">vendredi</option>
            <option value = "saturday">samedi</option>
            <option value = "sunday">dimanche</option>
        </select> 

        <!-- choisir une période -->
        <label for="criteriaPeriod">Choisissez une période :</label>
        <select id="criteriaPeriod" name="criteriaPeriod" >
            <option value="*">Journée</option>
            <option value="morning">Matin</option>
            <option value="afternoon">Après-midi</option>
        </select>

        <!-- choisir l'heure de début : ne s'affiche que si matin est choisi-->
        <label for="criteriaHourAM" id="criteriaHourAMLabel">Choisissez l'heure de début :</label>
        <select id="criteriaHourAM" name="criteriaHourAM" >                        
            <option value="allMorning">Toutes</option>
            <option value="1h">1h</option>
            <option value="2h">2h</option>
            <option value="3h">3h</option>
            <option value="4h">4h</option>
            <option value="5h">5h</option>
            <option value="6h">6h</option>
            <option value="7h">7h</option>
            <option value="8h">8h</option>
            <option value="9h">9h</option>
            <option value="10h">10h</option>
            <option value="11h">11h</option>
            <option value="12h">12h</option>
        </select>

        <!-- choisir l'heure de début : ne s'affiche que si après-midi est choisi-->
        <label for="criteriaHourPM" id="criteriaHourPMLabel">Choisissez l'heure de début :</label>
        <select id="criteriaHourPM" name="criteriaHourPM" >                        
            <option value="allAfternoon">Toutes</option>
            <option value="13h">13h</option>
            <option value="14h">14h</option>
            <option value="15h">15h</option>
            <option value="16h">16h</option>
            <option value="17h">17h</option>
            <option value="18h">18h</option>
            <option value="19h">19h</option>
            <option value="20h">20h</option>
            <option value="21h">21h</option>
            <option value="22h">22h</option>
            <option value="23h">23h</option>
            <option value="24h">24h</option>
        </select>

        <!-- choisir la tranche d'âge -->
        <label for="criteriaAge">Choisissez une tranche d'âge :</label>
        <select id="criteriaAge" name="criteriaAge" >
            <option value = "range0">Toutes</option>
            <option value = "range1">18-29 ans</option>
            <option value = "range2">30-44 ans</option>
            <option value = "range3">45-59 ans</option>
            <option value = "range4">60 ans et plus</option>
        </select>
        <button id="playerButton" type="submit">Je valide</button>
    <?php } ?>
</form>

<script>
    // gestion des textes explicatifs
    let amountSelected = <?php echo json_encode($listOfGamesSelected); ?>;                 // json_encode : générer une chaîne JSON valide pour transmettre des données à JavaScript
    let amountFavorite = <?php echo json_encode($listOfFavoriteGames); ?>; 
    const sessionList = "<?php echo $_SESSION['playerSelectionCriteria']['list']; ?>";
    let titleCriteriaFirst = document.querySelector(".textWhichList");
    let titleCriteriaSecond = document.querySelector(".textLabel");
    
    if(amountFavorite.length > 0 && sessionList === "0"){
        // s'il existe des jeux favoris et que le choix d'une des listes n'est pas déjà fait
        titleCriteriaFirst.textContent = "Où voulez-vous choisir un jeu ? :";
    } 
    if(amountFavorite.length > 0 && sessionList !== "0"){
        // s'il existe des jeux favoris et que le choix d'une des listes est fait
        titleCriteriaSecond.textContent = "Choisissez un ou tous les jeux : ";
    } 
    if(amountSelected.length > 0 && amountFavorite.length === 0){
        // s'il existe des jeux sélectionnés mais qu'il n'existe pas de jeu favori 
        titleCriteriaFirst.textContent = "Aucun de vos jeux n'est marqué comme favori. " + 
                                    "Pour l'instant, seule votre liste de jeux sélectionnés est disponible. " + 
                                    "Marquez des jeux comme favoris pour ajouter une liste dédiée. " + 
                                    "Gérez vos jeux dans la section Profil.";
        titleCriteriaSecond.textContent =  "Choisissez un ou tous les jeux :"; 
    }
    if(amountSelected.length === 0 ){
        // s'il n'existe pas de jeu sélectionné
        titleCriteriaFirst.textContent = "Pour pouvoir faire une sélection de joueurs," + 
                                     " il vous faut au préalable sélectionner des jeux." +
                                     " Pour cela, rendez-vous dans la section profil.";
    }

    // gestion de l'affichage des menus déroulants
    const criteriaPeriod = document.getElementById('criteriaPeriod');
    const criteriaHourAMLabel = document.getElementById('criteriaHourAMLabel');
    const criteriaHourPMLabel = document.getElementById('criteriaHourPMLabel');
    const criteriaHourAM = document.getElementById('criteriaHourAM');
    const criteriaHourPM = document.getElementById('criteriaHourPM');

    // Fonction pour gérer l'affichage des heures
    function toggleCriteriaHour() {
        if (criteriaPeriod.value === '*') {
            // menu des heures caché
            criteriaHourAMLabel.style.display = 'none';
            criteriaHourAM.style.display = 'none';
            criteriaHourPMLabel.style.display = 'none';
            criteriaHourPM.style.display = 'none';
        } 
        else if(criteriaPeriod.value === 'morning') {
            // Affichage des heures du matin
            criteriaHourPMLabel.style.display = 'none';
            criteriaHourPM.style.display = 'none';
            criteriaHourAMLabel.style.display = 'inline';
            criteriaHourAM.style.display = 'inline';
        }   
        else if(criteriaPeriod.value === 'afternoon') {
            // Affichage des heures de l'après midi
            criteriaHourAMLabel.style.display = 'none';
            criteriaHourAM.style.display = 'none';
            criteriaHourPMLabel.style.display = 'inline';
            criteriaHourPM.style.display = 'inline';
        }
    }
    // Ajouter un écouteur d'événement pour détecter les changements
    criteriaPeriod.addEventListener('change', toggleCriteriaHour);
    toggleCriteriaHour();
</script>

