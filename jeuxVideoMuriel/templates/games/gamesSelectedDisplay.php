<!--
/**
 * Displays a list of selected games with their details.
 *
 * The data is dynamically generated from the $listOfGamesSelected array 
 * and includes an image for each game.
 * A JavaScript script updates the page title based on the number of selected games.
 *
 * PHP Variables:
 * @var array $listOfGamesSelected An array containing selected games data.
 *    Each game entry includes:
 *      - 'nameGame' (string): The name of the game.
 *      - 'platformGame' (string): The platform of the game.
 *      - 'favoriteGame' (bool): Whether the game is marked as a favorite.
 *      - 'levelGame' (string): The skill level required for the game ('beginner', 'confirmed', 'expert', 'master').
 *      - 'urlPictureGame' (string): The URL of the game's image.
 */
-->
<h3 class="gamesSelected"></h3>

<?php
    foreach ($listOfGamesSelected as $game) {
        $favorite = $game['favoriteGame'] ? "oui" : "non";
        $level = match ($game['levelGame']) {
            "beginner" => "débutant",
            "confirmed" => "confirmé",
            "expert" => "expert",
            "master" => "maître",
            default => "débutant",
        };
?>

        <div class="dataGamesSelected">
            <div class="text">
                <?= htmlspecialchars($game['nameGame']) ?>
                (<?= htmlspecialchars($game['platformGame']) ?>)
                   <br /> Niveau : <?= $level ?> 
                   <br /> Favori : <?=$favorite?>
            </div>
            <div class="picture">
                <img src="<?= htmlspecialchars($game['urlPictureGame'])?>" 
                    alt="Illustration du jeu <?= htmlspecialchars($game['nameGame']) ?>"/>
            </div>
        </div>
<?php 
    }
?>
<script>
    let amount = <?php echo json_encode($listOfGamesSelected); ?>;                              // json_encode : générer une chaîne JSON valide pour transmettre des données à JavaScript
    let titleGamesSelected = document.querySelector(".gamesSelected");
    if(amount.length > 0){
        titleGamesSelected.textContent =  "<?php echo "Jeux déjà sélectionnés : "; ?>";
    }
</script>

