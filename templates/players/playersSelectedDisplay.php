<!--==================== affichage des joueurs sélectionnés ====================-->
<h3 class="playersSelected"></h3>

<?php
    foreach ($listOfPlayersSelected as $player) {
        $age = match ($player['ageRangeUser']) {
            "range0" => "ne souhaite pas répondre",
            "range1" => "18-29 ans",
            "range2" => "30-44 ans",
            "range3" => "45-59 ans",
            "range4" => "60 ans et plus", 
            default => "ne souhaite pas répondre",
        };
        $level = match ($player['levelGame']) {
            "beginner" => "débutant",
            "confirmed" => "confirmé",
            "expert" => "expert",
            "master" => "maître",
            default => "débutant",
        };
?>
        <div class="dataGamesSelected">
            <div class="text">
               Joueur  <?= htmlspecialchars($player['alias']) ?>
                , Age :  <?= $age ?> <br />
                jeu : <?= htmlspecialchars($player['nameGame']) ?>
                (<?= htmlspecialchars($player['platformGame']) ?>)
                   <br /> Niveau : <?= $level ?> <br />
            </div>
        </div>
<?php 
    }
?>
<script>
    let amount = <?php echo json_encode($listOfplayersSelected); ?>;                 // json_encode : générer une chaîne JSON valide pour transmettre des données à JavaScript
    let titleplayersSelected = document.querySelector(".playersSelected");
    if(amount.length > 0){
        titleplayersSelected.textContent =  "<?php echo "Joueurs qui correspondent aux critères de sélection : "; ?>";
    } else {
        titleplayersSelected.textContent =  "<?php echo "Aucun joueur trouvé selon vos critères de sélection"; ?>";
    }
</script>

