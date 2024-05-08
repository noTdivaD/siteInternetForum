<?php
    // Titre de la page
    $pageTitle = "Connexion - Forum du Pays de Grasse";
    // Inclusion du header
    include 'header.php';
?>

<!-- Formulaire de connexion -->
<div class="login-container">
    <h2>Connexion</h2>
    <form action="../controller/LoginController.php" method="POST">
        <div id="error_message" style="color: red;"></div>
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
            <a href="inscription.html">Déja Membre ? Créer un compte</a>
            <a href="motdepasse-oublie.html">Mot de passe oublié ?</a>
        </div>
    </form>
</div>

<?php
    // Inclusion du footer
    include 'footer.php';
?>