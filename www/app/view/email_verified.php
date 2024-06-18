<?php
    // Titre de la page
    $pageTitle = "Email Confirmé - Forum du Pays de Grasse";
    $currentPage = "Email Confirmé";

    // Chemin du fichier default.php
    $defaultFilePath = __DIR__ . '/view/default.php';

    // Vérifiez si default.php existe
    if (file_exists($defaultFilePath)) {
        // Vérifier si l'utilisateur a accès au site
        if (!isset($_SESSION['site_access_granted']) || $_SESSION['site_access_granted'] !== true) {
            header('Location: /app/authentification');
            exit();
        }
    }
    
    // Inclusion du header
    include 'parts/header.php';
?>

<div class="main-content">
    <div class="forum-sent-email-container center-content">
        <h2>Email confirmé avec succès !</h2>
        <div class="success-container">
            <div class="success-text-container">
                <img src="/public/images/succes.png" alt="Image Succès" width="70px">
                <p>Votre adresse e-mail a été confirmée avec succès.</p>
            </div>
            <div class="links">
                <a href="/app/connexion">Retourner à la page de Connexion</a>
            </div>
        </div>
    </div>
</div>    

<link rel="stylesheet" href="/public/css/style_forum_email_envoye.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/style_forum_email_envoye.css'); ?>">
<script src="/public/js/style_forum_email_envoye.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/js/style_forum_email_envoye.js'); ?>"></script>

<?php
    // Inclusion du footer
    include 'parts/footer.php';
?>