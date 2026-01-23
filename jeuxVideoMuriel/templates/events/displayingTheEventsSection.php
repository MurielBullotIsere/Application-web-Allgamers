<div class="events">
        <div class="title">
            <img src="templates\assets\pictures\icons8-calendrier-48.png" alt="icône d'un calendrier"/>
            <h2>Evènements</h2>
        </div>
        <div class="new">
            <p class="normalText">Cette section vous permet de consulter les prochaines rencontres, 
                tournois ou sessions de jeu organisées par les joueurs. 
            </p>
        </div>

        <div class="eventsOfUser">
            <?php    
                // Inclusion des évènements de l'utilisateur prévus aujourd'hui ou explication
                // require 'templates/events/eventsOfUserToday.php';
            ?>
        </div>

        <div class="eventsOfOthers">
            <?php   
                // Inclusion des évènements des autres joueurs prévus aujourd'hui ou explication
                // require 'templates/events/eventsOfOthersToday.php';
            ?>
        </div>

        <div>
            <!--********************************* bouton pour aller à la page de gestion des évènements *******************************-->
            <form action="/jeuxVideoMuriel/index.php?action=eventPage" method="post">   
                <button class="eventButton" type="submit">voir plus</button><br><br>
            </form> 
        </div>
    </div>
