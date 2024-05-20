<?php
    // Titre de la page
    $pageTitle = "Journée FORUM - Forum du Pays de Grasse";
    $currentPage = "Journée FORUM";
    // Inclusion du header
    include 'parts/header.php';
?>

<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>

<div class="container">
        <div class="text">
            <h1>Rejoignez-nous pour la Journée Forum</h1>
            <p>La <span class="date">Journée Forum</span> est un événement annuel incontournable à Grasse. Cette année, il se tiendra le <span class="date">Samedi 14 Septembre</span> à la <span class="location">Cours Honoré Cresp</span>.</p>
            <p>Venez découvrir les diverses associations locales, rencontrer les membres et participer à des activités passionnantes. C'est une occasion parfaite pour en apprendre davantage sur les initiatives locales et peut-être même rejoindre une association qui vous tient à cœur.</p>
            <a href="#" class="btn">Bulletins d'inscription</a>
        </div>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="../../public/images/imagesForum/1.JPG" alt="Image 1"></div>
                <div class="swiper-slide"><img src="../../public/images/imagesForum/2.JPG" alt="Image 2"></div>
                <div class="swiper-slide"><img src="../../public/images/imagesForum/3.JPG" alt="Image 3"></div>
            </div>  
            <div class="swiper-pagination"></div>
        </div>
</div>

<link rel="stylesheet" href="../../public/css/journee_forum_style.css">
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="../../public/js/journee_forum.js"></script>

<?php
    // Inclusion du footer
    include 'parts/footer.php';
?>
