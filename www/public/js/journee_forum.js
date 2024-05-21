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

    // Get the modal
    var modal = document.getElementById('editArticleModal');

    // Get the button that opens the modal
    var btn = document.getElementById('manageRegistrationsBtn');

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName('close')[0];

    // When the user clicks the button, open the modal 
    btn.onclick = function() {
        modal.style.display = 'block';
    }

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
        modal.style.display = 'none';
    }

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = 'none';
        }
    }
});