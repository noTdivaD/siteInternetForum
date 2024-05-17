<?php
    // Titre de la page
    $pageTitle = "Annuaire - Forum du Pays de Grasse";
    $currentPage = "Annuaire";
    // Inclusion du header
    include 'parts/header.php';
?>

<div class="main-content">
    <div class="annuaire-container">   
            <h1>Annuaire</h1>
            <div class="thematique" onclick="redirectToLink('annuaire/sport.php')">
                <a href="annuaire/sport.php" class="facebook-logo">
                    <img src="../../public/images/FacebookLogo.png" alt="Facebook">
                </a>
                <h2>Sports</h2>
            </div>
            <div class="thematique"  onclick="redirectToLink('annuaire/animations.php')">
                <a href="annuaire/animations" class="facebook-logo">
                    <img src="../../public/images/FacebookLogo.png" alt="Facebook">
                </a>
                <h2>Animations et loisirs</h2>
            </div>
            <div class="thematique"  onclick="redirectToLink('annuaire/arts.php')">
                <a href="annuaire/arts.php" class="facebook-logo">
                    <img src="../../public/images/FacebookLogo.png" alt="Facebook">
                </a>
                <h2>Arts et culture</h2>
            </div>
            <div class="thematique"  onclick="redirectToLink('bienetre/sport.php')">
                <a href="annuaire/bienetre.php" class="facebook-logo">
                    <img src="../../public/images/FacebookLogo.png" alt="Facebook">
                </a>
                <h2>Bien être</h2>
            </div>
            <div class="thematique"  onclick="redirectToLink('annuaire/humanitaire.php')">
                <a href="annuaire/humanitaire.php" class="facebook-logo">
                    <img src="../../public/images/FacebookLogo.png" alt="Facebook">
                </a>
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