<?php
    // Titre de la page
    $pageTitle = "Email Envoyé - Forum du Pays de Grasse";
    $currentPage = "Email Envoyé";

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
    <div class="forum-sent-email-container">
        <h2>Email envoyé avec succès !</h2>
        <div class="succes-container">
            <div class="succes-text-container">
                <img src="/public/images/succes.png" alt="Image Succès">
                <p>Votre mail a bien été pris en compte par nos services et a été envoyé à l'adresse mail : <strong>contact@assoforum-paysdegrasse.com</strong></p>
            </div>
            <div class="links">
                <a href="/app/index">Retourner à la page d'accueil</a>
            </div>
        </div>
    </div>
</div>    
<link rel="stylesheet" href="/public/css/style_forum_email_envoye.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/style_forum_email_envoye.css'); ?>">
<script src="/public/js/forum_email_envoye.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/js/forum_email_envoye.js'); ?>"></script>
<?php
    // Inclusion du footer
    include 'parts/footer.php';
?>