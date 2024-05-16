document.addEventListener("DOMContentLoaded", function() {
    var swiper = new Swiper(".mySwiper", {
        pagination: {
            el: ".swiper-pagination",
        },
        autoplay: {
            delay: 5000, // Défilement automatique toutes les 5 secondes (5000ms)
            disableOnInteraction: false, // Activer le défilement automatique même lorsqu'un utilisateur interagit avec le carrousel
        },
    });

    var paginationBullets = document.querySelectorAll('.swiper-pagination-bullet');
    paginationBullets.forEach(function(bullet) {
        bullet.style.backgroundColor = "white";
    });
});
