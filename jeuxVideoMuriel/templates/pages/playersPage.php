<?php 
/** Displays the players page.
 *
 * Before call up the layout page, this script dynamically generates :
 *     the players page, including its header, 
 *     the player selection form, 
 *     the players selected if the form has been completed, 
 *     the friends (matchmaking) section, 
 *     the footer with navigation buttons.
 *
 * Included components:
 *       headerDisplay.php : Displays the page header.
 *       playersSelectedForm.php : Player selection form.
 *       playersSelectedDisplay.php  (if selection criteria is 1): Displays selected players.
 *       matchmakingDisplay.php : Displays the matchmaking (friends) section.
 *       footerDisplay.php : Displays the footer with navigation buttons.
 *       layout.php : Manages the overall page layout.
 *
 * Variables used:
 *       $footerColor : Defines the footer color.
 *       $title : Page title.
 *       $headerColor : Header color.
 *       $header : Dynamically generated header content.
 *       $content : Dynamically generated page content.
 *       $footer : Dynamically generated footer content.
 */

// the players page, including its header
    $footerColor = "footerMainPage";
    $title="page des joueurs";
    $headerColor="palegreyColor";

    ob_start();
    require 'templates/components/headerDisplay.php';
?>
    <div class="allgamersHeader palegreyColor"> 
        <h1 class="titleAlone">Allgamers</h1>
    </div>
<?php
    $header = ob_get_clean(); 

// the player selection form
    ob_start(); 
?>
<div class="titlePage blueGamesForm">
    <h2>Joueurs </h2>
</div>

<div class="gamersPage">
    <section class="selectionCriteria">
        <?php 
        require 'templates\players\playersSelectedForm.php'; 

// the players selected if the form has been completed
        if($_SESSION['playerSelectionCriteria']['choice'] === "1"){
            require 'templates\players\playersSelectedDisplay.php';
        }
        ?>
    </section>

<!-- the friends (matchmaking) section -->
    <section class="friends">
        <?php 
        require 'templates\players\matchmakingDisplay.php'; 
        ?>
    </section>
</div>

<?php 
    $content = ob_get_clean();  // $content récupère le contenu généré


// the footer with navigation buttons
ob_start();
    $visibleButtons = ['teamsPage', 'eventsPage', 'streamNewsPage', 'comeBack']; // Boutons à afficher
    require 'templates/components/footerDisplay.php';
    $footer = ob_get_clean(); 

// ******************************* call up the layout page ****************************
    require 'templates/components/layout.php'; 
?>