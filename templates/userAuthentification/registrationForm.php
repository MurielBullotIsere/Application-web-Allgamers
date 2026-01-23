<?php 
/*==================== affichage du formulaire d'inscription ====================*/
    $title="Formulaire d'inscription";
    $headerColor="palegreyColor";
    $footer = "";

    ob_start();
    require 'templates/components/headerDisplay.php';
?>
    <div class="allgamersHeader palegreyColor"> 
        <form action="/Application-web-Allgamers/index.php?action="  method="post">   
            <button type="submit"><img src="templates\assets\pictures\icons8-arrière-24.png" alt="retour à la page d'accueil"/></button>
        </form> 
        <h1>Allgamers</h1>
    </div>
<?php
    $header = ob_get_clean(); 
    

    ob_start(); 
?>
<div class="titlePage userForm">
    <h2>Inscription</h2>  

</div>
<form action="/Application-web-Allgamers/index.php?action=createUser" class="userForm" method="post">   
    <h5 class="tips">Tous les champs sont obligatoires.</h5>
    <!-- plusieurs membres d'une même famille (même adresse mail) peuvent se connecter -->
    <label for="firstName">Prénom :</label>
    <input type="text" id="firstName" name="firstName" required><br>  <!-- required : champ de texte doit être obligatoirement rempli -->

    <label for="lastName">Nom :</label>
    <input type="text" id="lastName" name="lastName" required><br>

    <label for="alias">Identifiant :</label>
    <input type="text" id="alias" name="alias" required><br>

    <label for="ageRange">Age :</label>
    <select id="ageRange" name="ageRange" >
        <option value = "range0">ne souhaite pas répondre</option>
        <option value = "range1">18-29 ans</option>
        <option value = "range2">30-44 ans</option>
        <option value = "range3">45-59 ans</option>
        <option value = "range4">60 ans et plus</option>
    </select><br>  

    <label for="adMail">Adresse mail :</label>
    <input type="email" id="adMail" name="adMail" required><br>

    <label for="passwordUser">Mot de Passe :</label>
    <h5 class="tips">Veuillez créer un mot de passe contenant au moins 8 caractères, 
        incluant majuscule, minuscule, chiffre et caractère spécial.</h5>
    <input type="password" autocomplete="off" id="passwordUser" name="passwordUser" required><br><br><br>
    <p id="feedback"></p>

    <button class="navigationButton" type="submit">Je valide</button><br><br><br><br><br><br><br><br><br>
</form>

<!-- vérification de la robustesse du mot de passe -->
<script>
    document.getElementById('passwordUser').addEventListener('input', function () {
        const feedback = document.getElementById('feedback');
        const password = this.value;

        // Critères de robustesse
        const minLength = 8;
        const hasUpperCase = /[A-Z]/.test(password);
        const hasLowerCase = /[a-z]/.test(password);
        const hasNumber = /[0-9]/.test(password);
        const hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);

        if (password.length < minLength) {
            feedback.textContent = "Le mot de passe doit contenir au moins " + minLength + " caractères.";
            feedback.className = "error";
        } else if (!hasUpperCase) {
            feedback.textContent = "Le mot de passe doit contenir au moins une lettre majuscule.";
            feedback.className = "error";
        } else if (!hasLowerCase) {
            feedback.textContent = "Le mot de passe doit contenir au moins une lettre minuscule.";
            feedback.className = "error";
        } else if (!hasNumber) {
            feedback.textContent = "Le mot de passe doit contenir au moins un chiffre.";
            feedback.className = "error";
        } else if (!hasSpecialChar) {
            feedback.textContent = "Le mot de passe doit contenir au moins un caractère spécial.";
            feedback.className = "error";
        } else {
            feedback.textContent = "Mot de passe robuste.";
            feedback.className = "success";
        }
    });
</script>

<?php 
    $content = ob_get_clean();  // $content récupère le contenu généré
    require 'templates/components/layout.php'; 
?>