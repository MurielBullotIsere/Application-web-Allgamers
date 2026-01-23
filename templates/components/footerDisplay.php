<!--************************ affichage du bas de page *************-->
<div class="bottomBand <?=$headerColor?>">
    <!-- si la chaîne 'mainPage' est dans le tableau $visibleButtons, la valeur vraie est utilisée (représenté par ??), 
         sinon un tableau vide est utilisé à la place (représenté par []) -->
    <?php if (in_array('comeBack', $visibleButtons ?? [])): ?>
        <div class="mainpageFooterButton">
            <form action="/Application-web-Allgamers/index.php?action=mainPage"  method="post">   
                <button type="submit"><img src="templates\assets\pictures\icons8-home-50.png" alt="retour à la page principale"/></button>
            </form> 
        </div>
    <?php endif; ?>

    <?php if (in_array('gamersPage', $visibleButtons ?? [])): ?>
        <div class="gamerFooterButton">
            <form action="/Application-web-Allgamers/index.php?action=playersPage"  method="post">   
                <button type="submit"><img src="templates\assets\pictures\icons8-manette-50.png" alt="icône d'une manette de jeux"/></button>
            </form> 
        </div>
    <?php endif; ?>

    <?php if (in_array('streamNewsPage', $visibleButtons ?? [])): ?>
        <div class="streamAndNewFooterButton">
            <form action="/Application-web-Allgamers/index.php?action=streamNewsPage"  method="post">   
                <button type="submit">
                    <img src="templates\assets\pictures\icons8-vidéo-en-direct-30.png" 
                         alt="icône d'une caméra"/></button>
            </form> 
        </div>
    <?php endif; ?>

    <?php if (in_array('eventsPage', $visibleButtons ?? [])): ?>
        <div class="eventFooterButton">
            <form action="/Application-web-Allgamers/index.php?action=eventPage"  method="post">   
                <button type="submit">
                    <img src="templates\assets\pictures\icons8-calendrier-48.png" 
                         alt="icône d'un calendrier"/></button>
            </form> 
        </div>
    <?php endif; ?>

    <?php if (in_array('teamsPage', $visibleButtons ?? [])): ?>
        <div class="teamFooterButton">
            <form action="/Application-web-Allgamers/index.php?action=teamPage"  method="post">   
                <button type="submit">
                    <img src="templates\assets\pictures\icons8-équipe-50.png" 
                         alt="icône d'un groupe"/></button>
            </form> 
        </div>
    <?php endif; ?>

</div>
