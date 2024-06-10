//Détecte une erreur dans l'url et l'affiche dans mon html
window.addEventListener('load', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    if (error) {
        const errorMessage = decodeURIComponent(error.replace(/\+/g, ' '));
        document.getElementById("error_message").innerText = errorMessage;
    }
});


document.getElementById('resetPasswordForm').addEventListener('submit', function(event) {
    event.preventDefault();  // Prévenir la soumission du formulaire pour la démonstration
    var isValid = true;

    clearErrors(); // Efface toutes les erreurs précédentes

    //Vérification du mot de passe
    var password = document.getElementById('password').value;
    if (!password.match(/^(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&#])[A-Za-z\d@$!%*?&#]{8,}$/)) {
        showError('password', "Format du mot de passe incorrect.");
        isValid = false;
    }

    // Vérification des mots de passe
    var confirm_password = document.getElementById('confirm_password').value;
    if (password !== confirm_password) {
        showError('confirm_password', "Les mots de passe ne correspondent pas.");
        isValid = false;
    }
    

    if (!isValid) {
        event.preventDefault(); // Empêche la soumission du formulaire si invalide
    } else {
        this.submit(); // Soumet le formulaire si tout est valide
    }
});

function showError(fieldId, message) {
    var input = document.getElementById(fieldId);
    var errorDiv = document.getElementById('error-' + fieldId);
    if (!errorDiv) {
        errorDiv = document.createElement('div');
        errorDiv.id = 'error-' + fieldId;
        errorDiv.classList.add('error-message');
        input.parentNode.insertBefore(errorDiv, input.nextSibling);
    }
    errorDiv.textContent = message;
    errorDiv.style.display = 'block';
    input.style.borderColor = 'red';
}

function clearErrors() {
    var errorMessages = document.querySelectorAll('.error-message');
    errorMessages.forEach(function(error) {
        error.textContent = '';
        error.style.display = 'none';
    });
    var inputs = document.querySelectorAll('input, select');
    inputs.forEach(function(input) {
        input.style.borderColor = 'initial'; 
    });
}