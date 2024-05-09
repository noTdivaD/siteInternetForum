//Détecte une erreur dans l'url et l'affiche dans mon html
window.addEventListener('load', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    if (error) {
        const errorMessage = decodeURIComponent(error.replace(/\+/g, ' '));
        document.getElementById("error_message").innerText = errorMessage;
    }
});

function toggleMenu() {
    var menu = document.getElementById("dropdown-menu");
    menu.style.display = (menu.style.display === "block") ? "none" : "block";
}

function closeMenu() {
    var overlay = document.getElementById('overlay');
    var dropdownMenu = document.getElementById('dropdown-menu');
    overlay.style.display = 'none';
    dropdownMenu.style.display = 'none';
}
