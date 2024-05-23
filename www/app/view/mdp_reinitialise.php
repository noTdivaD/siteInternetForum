<?php
/*
// Vérifier si l'utilisateur a accès au site
if (!isset($_SESSION['site_access_granted']) || $_SESSION['site_access_granted'] !== true) {
    header('Location: /app/authentification');
    exit();
} */
?>

<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Réinitialisation Du Mot de Passe</title>
    <link rel="stylesheet" href="/public/css/common_style.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/common_style.css'); ?>">
    <link rel="icon" href="/public/images/logo/logo-association-forum-onglet-t48.png" type="/png">
    <link rel="stylesheet" href="/public/css/style_mdp_reinitialise.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/style_mdp_reinitialise.css'); ?>"> 
</head>
<body>
    <div class="main-content">
        <div class="reset-container">
            <h2>Réinitialisation du mot de passe</h2>
            <form action="/app/mdp_reinitialise/reset" method="POST" id="resetPasswordForm">

                <div id="error_message" style="text-align: center; margin-bottom: 10px; color: red;"></div>

                <input type="hidden" name="email" value="<?php echo $_GET['email']; ?>">
                <input type="hidden" name="token" value="<?php echo $_GET['token']; ?>">

                <div class="form-group">
                    <label for="password">Nouveau mot de passe:</label>
                    <input type="password" id="password" name="password" required>
                    <div class="error-message" id="error-password"></div>
                </div>

                <div class="form-group">
                    <label for="confirm_password">Confirmer mot de passe:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                    <div class="error-message" id="error-confirm_password"></div>
                </div>

                <p id="format_mdp">Attention, le mot de passe doit contenir au moins 8 caractères, incluant au moins une majuscule, un chiffre et un caractère spécial parmis ceux présentés ici : @ $ ! % * ? & #.</p>

                <button type="submit">Réinitialiser le mot de passe</button>
            </form>
        </div>
    </div>   
    <script src="/public/js/mdp_reinitialise.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/js/mdp_reinitialise.js'); ?>"></script>
</body>
</html>
