<!--  Generates the basic structure of an HTML page with Bootstrap.

This page includes:
 - A dynamic header
 - A dynamic main content area
 - A dynamic footer with a customizable class
 - Bootstrap 5 integration for styling
 - A custom CSS stylesheet
 - A Google Fonts integration
 @param string $title       The page title
 @param string $header      The header content
 @param string $content     The main page content
 @param string $footer      The footer content
 @param string $footerColor The CSS class applied to the footer for custom styling
-->

<!DOCTYPE html>
<html lang="fr">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $title ?></title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" 
              rel="stylesheet" 
              integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" 
              crossorigin="anonymous">
        <link rel="stylesheet" href="templates/assets/style.css">
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Commissioner:wght@100..900&display=swap" rel="stylesheet">
    </head>


    <body>
        <header>
            <?= $header ?>
        </header>
        
        <main>
            <?= $content ?>
        </main>
        <footer class="<?=$footerColor?>">
            <?= $footer ?>
        </footer>  
    </body>
</html>

