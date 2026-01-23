<!--************************ affichage de l'entête *************-->
<div class="headband <?=$headerColor?>">
    <div class="time">
        <!-- afficher l'heure en cours -->
        <?php 
        $date = new DateTime();
        echo $date->format("H:i"); ?>
    </div>
    <!-- affichage des icônes -->
    <div class="icons <?=$headerColor?>">
        <img src="templates\assets\pictures\icons8-signal-50.png" alt="connexion forte"/>
        <img src="templates\assets\pictures\icons8-wifi-50.png" alt="wifi activé"/>
        <img src="templates\assets\pictures\icons8-batterie-pleine-64.png" alt="batterie pleine"/>
    </div>
</div>
