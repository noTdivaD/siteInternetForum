//Détecte une erreur dans l'url et l'affiche dans mon html
window.addEventListener('load', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    if (error) {
        const errorMessage = decodeURIComponent(error.replace(/\+/g, ' '));
        document.getElementById("error_message").innerText = errorMessage;
    }
});