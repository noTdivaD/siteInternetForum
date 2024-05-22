<?php
    // Titre de la page
    $pageTitle = "Réinitialisation - Forum du Pays de Grasse";
    $currentPage = "Récupération";

    // Vérifier si l'utilisateur a accès au site
    if (!isset($_SESSION['site_access_granted']) || $_SESSION['site_access_granted'] !== true) {
        header('Location: /app/authentification');
        exit();
    }

    // Inclusion du header
    include 'parts/header.php';
?>

<!-- Formulaire de connexion -->
<div class="main-content">
    <div class="forgotpassword-container">
        <h2>Mot de Passe Oublié</h2>
        <form action="/app/mdp_oublie/reset" method="POST" id="form-forgotpassword">
            <div id="error_message" style="text-align: center; margin-bottom: 10px; color: red;"></div>
            <div class="form-group">
                <label for="email">Adresse Email:</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="form-group">
                <button type="submit" class="forgotpassword-button">Envoyer</button>
            </div>
            <div class="links">
                <a href="/app/connexion">Se connecter</a>
            </div>
        </form>
    </div>
</div>    
<link rel="stylesheet" href="/public/css/style_mdp_oublie.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/style_mdp_oublie.css'); ?>">
<script src="/public/js/mdp_oublie.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/js/mdp_oublie.js'); ?>"></script>
<?php
    // Inclusion du footer
    include 'parts/footer.php';
?>