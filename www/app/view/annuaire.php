<?php
    // Titre de la page
    $pageTitle = "Annuaire des associations - Forum du Pays de Grasse";
    $currentPage = "Annuaire des associations";

    // Vérifier si l'utilisateur a accès au site
    if (!isset($_SESSION['site_access_granted']) || $_SESSION['site_access_granted'] !== true) {
        header('Location: /app/authentification');
        exit();
    }
    
    // Inclusion du header
    include 'parts/header.php';
?>

<div class="main-content">
    <div class="annuaire-container">   
            <h1>Annuaire des associations</h1>
            <div class="thematique sports" onclick="redirectToLink('/app/associations_sports')">
                <h2>Sports</h2>
            </div>
            <div class="thematique animationsloisirs"  onclick="redirectToLink('/app/associations_animationsloisirs')">
                <h2>Animations et loisirs</h2>
            </div>
            <div class="thematique artsculture"  onclick="redirectToLink('/app/associations_artsculture')">
                <h2>Arts et culture</h2>
            </div>
            <div class="thematique bienetre"  onclick="redirectToLink('/app/associations_bienetre')">
                <h2>Bien être</h2>
            </div>
            <div class="thematique humanitaire"  onclick="redirectToLink('/app/associations_humanitaires')">
                <h2>Humanitaire, social, civique, et environnement</h2>
            </div>
            <div class="thematique ecologie"  onclick="redirectToLink('/app/associations_ecologiques')">
                <h2>Écologie et environnement</h2>
            </div>
            <div class="thematique combattant"  onclick="redirectToLink('/app/associations_combattants')">
                <h2>Anciens combattants et assimilés</h2>
            </div>
            <div class="thematique economie"  onclick="redirectToLink('/app/associations_economie')">
                <h2>Économie et développement</h2>
            </div>
    </div>
</div>    

<link rel="stylesheet" href="/public/css/annuaire_style.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/annuaire_style.css'); ?>">
<script src="/public/js/annuaire.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/js/annuaire.js'); ?>"></script>
<?php
    // Inclusion du footer
    include 'parts/footer.php';
?>