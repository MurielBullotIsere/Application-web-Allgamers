<div class="streamAndNews">
        <div class="title">
            <img src="templates\assets\pictures\icons8-vidéo-en-direct-30.png" alt="icône d'une caméra"/>
            <h2>Stream et Actu</h2>
        </div>

        <div class="stream">
            <?php    
                // Inclusion des stream en cours ou explication
                // require 'templates/streams/streamInProgress.php';
            ?>
        </div>

        <div class="new">
            <?php    
                // Inclusion des titres des nouvelles actualités disponibles ou explication
                // require 'templates/new/newTitle.php';
            ?>
        </div>
        <div class="new">
            <p class="normalText">Cette section est dédiée aux diffusions en direct et aux replays des joueurs de la communauté. 
                Regardez, commentez et partagez vos moments préférés en direct. 
            </p>
        </div>

        <div class="new">
            <p class="normalText">Retrouvez aussi toutes les dernières informations
                 et mises à jour de la communauté.</p>
        </div>
        <div class="new">
            <p class="boldText">L'heure du Ragnarök a sonné</p>
            <p class="normalText">Rejoignez Kratos et Atreus dans leur aventure à travers...</p>
        </div>

        <div>
            <!--********************************* bouton pour aller à la page de gestion des stream et des actus *******************************-->
            <form action="/jeuxVideoMuriel/index.php?action=streamNewsPage" method="post">   
                <button class="streamNewButton" type="submit">voir plus</button><br><br>
            </form> 
        </div>
    </div>
