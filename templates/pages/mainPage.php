<?php 
/**
 * Allgamers main page
 * 
 * This page displays the header, the page body and the footer.
 * The page body contains : 
 *      - the title with dynamically generated user's name (“aliasDisplay” element)
 *      - four different sections : players, stream And News, events, team
 *            each section displays its content by calling a template  
 *      - dynamic updating of the textual content of the “aliasDisplay” element 
 * 
  * Included components:
 *       headerDisplay.php : Displays the page header.
 *       displayingThePlayersSection.php : Displays the players section
 *       displayingTheStreamAndNewsSection : Displays the stream and news section
 *       displayingTheEventsSection.php : Displays the events section
 *       displayingTheTeamSection.php : Displays the team section
 *       footerDisplay.php : Displays the page footer.
 *       layout.php : call template to display above contents
 *
 * Variables used:
 *       $footerColor : Defines the footer color.
 *       $title : Page title.
 *       $headerColor : Header color.
 *       $header : Dynamically generated header content.
 *       $content : dynamically generated page body content
 *       $footer : Dynamically generated footer content.
 * 
 * @package Allgamers
 * @author Muriel Bullot
 * @version 1.0
 */

 // Variables
    $footerColor = "footerMainPage";
    $title="page principale";
    $headerColor="palegreyColor";

// ----------------------------------------- header content (<header>)
    ob_start();
    require 'templates/components/headerDisplay.php';
?>

<div class="allgamersHeader palegreyColor"> 
    <h1 class="titleAlone">Allgamers</h1>
</div>
<?php
    $header = ob_get_clean(); 

// ------------------------------------------ page body content (<main>)
// title with dynamically generated user's name
    ob_start(); 
?>

<div class="titlePage blueGamesForm">
    <h2>Bienvenue
        <p class="aliasDisplay"></p>
    </h2>
</div>

<!-- four different sections : player, stream And News, events, team -->
<div class="mainpage">
    <!-- displaying the players section -->
    <?php    
    require 'templates\players\displayingThePlayersSection.php';
    ?>

    <!-- displaying the stream and news section -->
    <?php    
    require 'templates\streamAndNews\displayingTheStreamAndNewsSection.php';
    ?>

    <!-- displaying the events section -->
    <?php    
    require 'templates\events\displayingTheEventsSection.php';
    ?>

    <!-- displaying the team section -->
    <?php    
    require 'templates\team\displayingTheTeamSection.php';
    ?>
</div>


<!-- dynamic updating of the textual content of the “aliasDisplay” element -->
<script>
    document.querySelector(".aliasDisplay").textContent =  
        "<?php echo htmlspecialchars($_SESSION['userData']['alias']); ?>";
</script>

<?php 
    $content = ob_get_clean();  // $content récupère le contenu généré

/* ----------------------------------------- footer content (<footer class="<?=$footerColor?>">) */
ob_start();
    $visibleButtons = ['teamsPage', 'eventsPage', 'streamNewsPage', 'gamersPage']; // Boutons à afficher
// Displays the footer  
    require 'templates/components/footerDisplay.php';
    $footer = ob_get_clean(); 


/* ========================================= call template to display above contents */
    require 'templates/components/layout.php'; 
?>