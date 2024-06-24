<?php
    // Titre de la page
    $pageTitle = "Inscription Confirmée - Forum du Pays de Grasse";
    $currentPage = "Inscription Confirmée";
    
    // Chemin du fichier default.php
    $defaultFilePath = __DIR__ . '/default.php';

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
    <div class="inscription-journee-forum-success-container">
        <h2>Inscription confirmée avec succès !</h2>
        <div class="succes-container">
            <div class="succes-text-container">
                <img src="/public/images/succes.png" alt="Image Succès">
                <p>Vous avez été ajouté dans la liste d'inscrits à la <strong>Journée Forum</strong></p>
            </div>
            <div class="links">
                <a href="/app/index">Retourner à la page d'acceuil</a>
            </div>
        </div>
    </div>
</div>    
<link rel="stylesheet" href="/public/css/style_inscription_journee_forum_success.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/style_inscription_journee_forum_success.css'); ?>">
<script src="/public/js/inscription_journee_forum_sucess.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/js/inscription_journee_forum_sucess.js'); ?>"></script>
<?php
    // Inclusion du footer
    include 'parts/footer.php';
?>