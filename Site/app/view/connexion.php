<?php
    // Titre de la page
    $pageTitle = "Connexion - Forum du Pays de Grasse";
    $currentPage = "Connexion";
    // Inclusion du header
    include 'parts/header.php';
?>

<!-- Formulaire de connexion -->
<div class="login-container">
    <h2>Connexion</h2>
    <form action="../controller/LoginController.php" method="POST" id="form-login">
        <div id="error_message" style="text-align: center; margin-bottom: 10px; color: red;"></div>
        <div class="form-group">
            <label for="email">Adresse Email:</label>
            <input type="email" id="email" name="email" required>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe:</label>
            <input type="password" id="password" name="password" required>
        </div>
        <div class="form-group">
            <button type="submit" class="login-button">Se connecter</button>
        </div>
        <div class="links">
            <a href="inscription.php">Pas Encore Membre ? Créer un compte</a>
            <a href="motdepasse-oublie.html">Mot de passe oublié ?</a>
        </div>
    </form>
</div>
<link rel="stylesheet" href="../../public/css/style_connexion.css">
<script src="../../public/js/connexion.js"></script>
<?php
    // Inclusion du footer
    include 'parts/footer.php';
?>