<!--/** Displays the player's friends list. 
 * called in templates\pages\playersPage.php, in <section class="friends">
 *
 * Checks that the friends list is not empty.
 * Displays the alias and age range of each friend.
 * Dynamically updates the title according to the number of friends.
 *
 * Variables used :
 * @var array $listOfFriends List of player's friends given in src\controllers\pages\playersPageCtrl.php
 */
-->
<h3 class="friendSelected"></h3>

<?php
    if(!empty($listOfFriends)) {
        foreach ($listOfFriends as $player) {
            $age = match ($player['ageRangeUser']) {
                "range0" => "non donné",
                "range1" => "18-29 ans",
                "range2" => "30-44 ans",
                "range3" => "45-59 ans",
                "range4" => "60 ans et plus", 
                default => "non donné",
            };
    ?>
            <div class="dataGamesSelected">
                <div class="text">
                    Joueur  <?= htmlspecialchars($player['alias']) ?>
                    - Age :  <?= $age ?> <br />
                </div>
            </div>
    <?php 
        }
    }
?>

<script>
    let amount = <?php echo json_encode($listOfFriends); ?>;                 // json_encode : générer une chaîne JSON valide pour transmettre des données à JavaScript
    let titlefriendSelected = document.querySelector(".friendSelected");
    if(amount.length > 0){
        titlefriendSelected.textContent =  "<?php echo "Liste de vos amis : "; ?>";
    } else {
        titlefriendSelected.textContent =  "<?php echo "Aucun ami pour le moment"; ?>";
    }
</script>
