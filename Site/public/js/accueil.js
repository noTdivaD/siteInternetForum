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

var frame = document.getElementById('myFrame');

frame.onload = function () {
    var body = frame.contentWindow.document.querySelector('body');
    body.style.color = 'red';
    body.style.fontSize = '20px';
    body.style.lineHeight = '20px';
};