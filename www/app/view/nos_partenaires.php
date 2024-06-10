<?php
// Titre de la page
$pageTitle = "Nos Partenaires - Forum du Pays de Grasse";
$currentPage = "Nos Partenaires";

// Vérifier si l'utilisateur a accès au site
if (!isset($_SESSION['site_access_granted']) || $_SESSION['site_access_granted'] !== true) {
    header('Location: /app/authentification');
    exit();
}

//Vérifier si l'utilisateur est connecté ou administrateur.
$isAdmin = isset($_SESSION['user_logged_in']) && $_SESSION['user_type'] == 'administrateur';

// Inclusion du header
include 'parts/header.php';

?>

<div class="main-content">
</div>

<link rel="stylesheet" href="/public/css/nos_partenaires_style.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/nos_partenaires_style.css'); ?>">
<script src="/public/js/nos_partenaires.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/js/nos_partenaires.js'); ?>"></script>
<?php
// Inclusion du footer
include 'parts/footer.php';
?>
