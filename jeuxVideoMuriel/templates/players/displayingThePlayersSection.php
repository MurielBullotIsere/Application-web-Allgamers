<!-- displaying the players section in the main page

This page displays
    - section title (Joueurs)
    - players who have responded to your friend request
    - pending requests
    - players who have friend requests
    - friend list
    - new friend proposal
    - button to go to the player management page

Included components:
    
 -->


<!-- 
nouvelle fonction : mettre dans des tableaux les données de la table friendrequest : friendRequestsToArrays 

nouvelle fonction : recherche d'ami compatible avec l'utilisateur dans la table ... :  
    ...
        mettre dans le tableau "propositions"

-->
<div class="gamers">
    <!-- section title -->
    <div class="title">
        <img src="templates\assets\pictures\icons8-manette-50.png" alt="icône d'une manette de jeux"/>
        <h2>Joueurs</h2>
    </div>

    <!-- players who have responded to your friend request -->
    <div>
        <!-- 
        afficher le tableau "yes"
            guest a accepté votre demande en vert
        afficher le tableau "no"
            guest a refusé votre demande en rouge
        -->
    </div>

    <!-- pending requests -->
    <div>
        <p>En attente d'une réponse de la part de :</p>
        <!-- 
        afficher le tableau "wait"
        -->
    </div>

    <!-- players who have friend requests -->
    <div class="gamersList">
        <p>Vous avez reçu une demande d'ami de :</p>
        <!-- 
        afficher le tableau "guests"
        -->

    </div>

    <!-- friend list -->
    <div>
        <p>Liste de vos amis :</p>
        <!-- 
        afficher le tableau "friends"
        -->

    </div>

    <!-- new friend proposition -->
    <div>
        <p>Propositions de nouveaux amis :</p>
        <!-- 
        afficher le tableau "propositions"
        -->

    </div>

    <!--button to go to the player management page -->
    <div>
        <form action="/jeuxVideoMuriel/index.php?action=playersPage" method="post">   
            <button class="gamerButton" type="submit">voir plus</button><br><br>
        </form> 
    </div>
</div>