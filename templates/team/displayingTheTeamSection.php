<div class="team">
        <div class="title">
            <img src="templates\assets\pictures\icons8-équipe-50.png" alt="icône d'un groupe"/>
            <h2>Groupes</h2>
        </div>

        <div>
            <p class="normalText">Ici, vous pouvez vous inscrire et rejoindre des groupes 
                en fonction de vos centres d'intérêt.</p>
        </div>

        
        <div class="namesTeam">
            <?php    
                // Inclusion des noms des groupes ou explication
                // require 'templates/teams/nameTeams.php';
            ?>
        </div>

        <div class="onLineTeam">
            <?php    
                // Inclusion des noms des personnes faisant parti des groupes en ligne ou explication
                // require 'templates/teams/teammates.php';
            ?>
        </div>
        
        <div class="proposalTeam">
            <?php    
                // Inclusion des noms des personnes à faire parti du groupe
                // require 'templates/teams/proposals.php';
            ?>
        </div>

        <div>
            <!--********************************* bouton pour aller à la page de gestion des groupes *******************************-->
            <form action="/Application-web-Allgamers/index.php?action=teamPage" method="post">   
                <button class="teamButton" type="submit">voir plus</button><br><br>
            </form> 
        </div>
    </div>
