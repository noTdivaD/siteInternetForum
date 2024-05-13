<?php
    // Titre de la page
    $pageTitle = "Accueil - Forum du Pays de Grasse";
    $currentPage = "Accueil";
    // Inclusion du header
    include 'parts/header.php';
?>

<div class="outside-container">
    <div class="inside-container" id="discover-container">      
        <h1>Découvrez-nous</h1>
        <div class="menus">
            <div class="menu menu1">
                <h2>Journée FORUM</h2>
                <div class="content">
                    <img src="../../public/images/FacebookLogo.png" alt="Facebook">
                    <iframe src="../../public/assets/texte_accueil/journee_forum.txt" frameborder="0" width="100%"></iframe>
                </div>
                <a href="#">En savoir plus</a>
            </div>
            <div class="menu menu2">
                <h2>Annuaire des associations</h2>
                <div class="content">
                    <img src="../../public/images/FacebookLogo.png" alt="Facebook">
                    <iframe src="../../public/assets/texte_accueil/annuaire_associations.txt" frameborder="0" width="100%"></iframe>
                </div>
                <a href="#">En savoir plus</a>
            </div>
            <div class="menu menu3">
                <h2>Rencontres associatives</h2>
                <div class="content">
                    <img src="../../public/images/FacebookLogo.png" alt="Facebook">
                    <iframe src="../../public/assets/texte_accueil/rencontres_associatives.txt" frameborder="0" width="100%"></iframe>
                </div>
                <a href="#">En savoir plus</a>
            </div>
            <div class="menu menu4">
                <h2>Conférences</h2>
                <div class="content">
                    <img src="../../public/images/FacebookLogo.png" alt="Facebook">
                    <iframe src="../../public/assets/texte_accueil/conferences.txt" frameborder="0" width="100%"></iframe>
                </div>
                <a href="#">En savoir plus</a>
            </div>
            <div class="menu menu5">
                <h2>Site internet et Facebook</h2>
                <div class="content">
                    <img src="../../public/images/FacebookLogo.png" alt="Facebook">
                    <iframe src="../../public/assets/texte_accueil/site_facebook.txt" frameborder="0" width="100%"></iframe>
                </div>
                <a href="#">En savoir plus</a>
            </div>
            <div class="menu menu6">
                <h2>Manifestations ponctuelles, sorties associatives</h2>
                <div class="content">
                    <img src="../../public/images/FacebookLogo.png" alt="Facebook">
                    <iframe src="../../public/assets/texte_accueil/manifestations_sorties.txt" frameborder="0" width="100%"></iframe>
                </div>
                <a href="#">En savoir plus</a>
            </div>
            <div class="menu menu7">
                <h2>Annuaire des associations</h2>
                <div class="content">
                    <img src="../../public/images/FacebookLogo.png" alt="Facebook">
                    <iframe src="../../public/assets/texte_accueil/annuaire_associations.txt" frameborder="0" width="100%"></iframe>
                </div>
                <a href="#">En savoir plus</a>
            </div>
            <div class="menu menu8">
                <h2>Collège d'experts</h2>
                <div class="content">
                    <img src="../../public/images/FacebookLogo.png" alt="Facebook">
                    <iframe src="../../public/assets/texte_accueil/college_experts.txt" frameborder="0" width="100%"></iframe>
                </div>
                <a href="#">En savoir plus</a>
            </div>

            <button id="prevBtn">&lt;</button>
            <button id="nextBtn">&gt;</button>
        </div>
    </div>

    <div class="inside-container">
        <h1>Qui sommes-nous?</h1>
        <iframe src="../../public/assets/texte_accueil/qui_sommes_nous.txt" frameborder="0" width="100%" height="500"></iframe>
    </div>

    <div class="inside-container">
        <h1>Mot du Président</h1>
        <iframe src="../../public/assets/texte_accueil/mot_president.txt" frameborder="0" width="100%" height="500"></iframe>
    </div>
</div>

<link rel="stylesheet" href="../../public/css/style_accueil.css">
<script src="../../public/js/accueil.js"></script>
<?php
    // Inclusion du footer
    include 'parts/footer.php';
?>
