<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Authentification</title>
    <link rel="stylesheet" href="/public/css/common_style.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/common_style.css'); ?>">
    <link rel="icon" href="/public/images/logo/logo-association-forum-onglet-t48.png" type="/png">
    <link rel="stylesheet" href="/public/css/style_password_protect.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/style_password_protect.css'); ?>"> 
</head>
<body>
    <div class="main-content">
        <h1>Site en cours de développement</h1>
        <p>Afin d'accéder au contenu du site, veuillez vous authentifier.</p>
        <form method="POST" action="/app/authentification/authentification" id="AuthentificationForm">
            <h1>Authentification</h1>
            <div id="error_message" style="text-align: center; margin-bottom: 10px; color: red;"></div>
            <input type="password" name="password" placeholder="Mot de passe à 4 chiffres" maxlength="4" required>
            <br>
            <input type="submit" value="S'authentifier">
        </form>
    </div>   
    <script src="/public/js/password_protect.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/js/password_protect.js'); ?>"></script>
</body>
</html>
