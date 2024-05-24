//Détecte une erreur dans l'url et l'affiche dans mon html
window.addEventListener('load', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    if (error) {
        const errorMessage = decodeURIComponent(error.replace(/\+/g, ' '));
        document.getElementById("error_message").innerText = errorMessage;
    }

    const success = urlParams.get('success');
    if (success) {
        const successMessage = decodeURIComponent(success.replace(/\+/g, ' '));
        document.getElementById("success_message").innerText = 'Un e-mail de vérification a été envoyé à votre adresse. Veuillez vérifier votre boîte de réception pour activer votre compte. Le lien expire dans 24 heures.';
    }
});