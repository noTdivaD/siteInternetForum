<?php
    // Titre de la page
    $pageTitle = "Annuaire des associations - Forum du Pays de Grasse";
    $currentPage = "Annuaire des associations";
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
    </div>
</div>    

<link rel="stylesheet" href="../../public/css/annuaire_style.css">
<script src="../../public/js/annuaire.js"></script>
<?php
    // Inclusion du footer
    include 'parts/footer.php';
?>