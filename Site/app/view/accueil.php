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
                <p>description</p>
                <a href="#">En savoir plus</a>
            </div>
            <div class="menu menu2">
                <h2>Annuaire des associations</h2>
                <p>description</p>
                <a href="#">En savoir plus</a>
            </div>
            <div class="menu menu3">
                <h2>Rencontres associatives</h2>
                <p>description</p>
                <a href="#">En savoir plus</a>
            </div>
            <div class="menu menu4">
                <h2>Conférences</h2>
                <p>description</p>
                <a href="#">En savoir plus</a>
            </div>
            <div class="menu menu5">
                <h2>Site internet et Facebook</h2>
                <p>description</p>
                <a href="#">En savoir plus</a>
            </div>
            <div class="menu menu6">
                <h2>Manifestations ponctuelles, sorties associatives</h2>
                <p>description</p>
                <a href="#">En savoir plus</a>
            </div>
            <div class="menu menu7">
                <h2>Annuaire des Associations</h2>
                <p>description</p>
                <a href="#">En savoir plus</a>
            </div>
            <div class="menu menu8">
                <h2>Collège d'experts</h2>
                <div class="content">
                    <img src="../../public/images/FacebookLogo.png" alt="Facebook">
                    <iframe src="../../public/assets/texte_accueil/college_expert.txt" frameborder="0" width="100%"></iframe>
                </div>
                <a href="#">En savoir plus</a>
            </div>

            <button id="prevBtn">&lt;</button>
            <button id="nextBtn">&gt;</button>
        </div>
    </div>

    <div class="inside-container">
        <h1>Qui sommes-nous?</h1>
        <p>FORUM est une association grassoise, du type loi de 1901, créée en 1984. Son objet est de promouvoir la vie associative par toutes initiatives concourant a l'amélioration de la communication entre les associations elles-mêmes d'une part et les associations et le public d'autre part. Conformément à ses statuts rénovés du 28 mars 2012, elle est ouverte à toutes les associations ayant un but culturel, sportif, social, humanitaire, éducatif, touristique, de loisirs ou d'animations, reconnues sans but lucratif, politique ou confessionnel exclusivement. L'activité de ces associations devant s'exercer sur la commune de Grasse ou sur des communes du Pays de Grasse.</p>
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
