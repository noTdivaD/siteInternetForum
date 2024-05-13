document.addEventListener("DOMContentLoaded", function() {
    // Récupération des éléments DOM
    var menus = document.querySelectorAll('.menu');
    var prevBtn = document.getElementById('prevBtn');
    var nextBtn = document.getElementById('nextBtn');

    var currentMenuIndex = 0; // Indice du menu actuellement affiché

    // Fonction pour afficher le menu suivant
    function showNextMenu() {
        menus[currentMenuIndex].style.display = 'none';
        currentMenuIndex = (currentMenuIndex + 1) % menus.length;
        menus[currentMenuIndex].style.display = 'block';
    }

    // Fonction pour afficher le menu précédent
    function showPrevMenu() {
        menus[currentMenuIndex].style.display = 'none';
        currentMenuIndex = (currentMenuIndex - 1 + menus.length) % menus.length;
        menus[currentMenuIndex].style.display = 'block';
    }

    // Ajout des écouteurs d'événements sur les boutons
    prevBtn.addEventListener('click', showPrevMenu);
    nextBtn.addEventListener('click', showNextMenu);

    // Cacher tous les menus sauf le premier au chargement de la page
    for (var i = 1; i < menus.length; i++) {
        menus[i].style.display = 'none';
    }
});

// Wait for the DOM content to be fully loaded
document.addEventListener("DOMContentLoaded", function() {
    // Select all iframe elements on the page
    var frames = document.querySelectorAll('iframe');

    // Loop through each iframe
    frames.forEach(function(frame) {
        // Set the onload event handler for each frame
        frame.onload = function () {
            // Inside this function, the frame content is fully loaded
            var body = frame.contentWindow.document.querySelector('body');
            if (body) {
                body.style.color = 'black';
                body.style.fontSize = '20px';
                body.style.lineHeight = '20px';
                body.style.fontFamily = 'Georgia, serif';
            } else {
                console.error("Body element not found in iframe.");
            }
        };
    });
});
