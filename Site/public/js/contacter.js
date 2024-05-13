//Détecte une erreur dans l'url et l'affiche dans mon html
window.addEventListener('load', function() {
    const urlParams = new URLSearchParams(window.location.search);
    const error = urlParams.get('error');
    if (error) {
        const errorMessage = decodeURIComponent(error.replace(/\+/g, ' '));
        document.getElementById("error_message").innerText = errorMessage;
        console.log(errorMessage)
    }
});



document.getElementById('registrationForm').addEventListener('submit', function(event) {
    event.preventDefault();  // Prévenir la soumission du formulaire pour la démonstration
    var isValid = true;

    clearErrors(); // Efface toutes les erreurs précédentes

     // Vérification du prénom
     if (document.getElementById('firstname').value.trim().length < 2 || !/^[A-Za-zàâäéèêëïîôöùûüç]+([-'][A-Za-zàâäéèêëïîôöùûüç]+)*$/.test(document.getElementById('firstname').value.trim())) {
        showError('firstname', "Le nom n'est pas correct.");
        isValid = false;
    }

    // Vérification du nom
    if (document.getElementById('lastname').value.trim().length < 2 || !/^[A-Za-zàâäéèêëïîôöùûüç]+([-'][A-Za-zàâäéèêëïîôöùûüç]+)*$/.test(document.getElementById('lastname').value.trim())) {
        showError('lastname', "Le prénom n'est pas correct.");
        isValid = false;
    }

    // Vérification de l'email
    var email = document.getElementById('email').value;
    var emailRegex = /^(?!.*\.\.)(?!.*\.$)(?!^\.)[A-Za-z0-9_.-]+@[A-Za-z0-9-]+\.[A-Za-z0-9.-]+$/;
    if (!emailRegex.test(email)) {
        showError('email', "L'adresse email n'est pas valide.");
        isValid = false;
    }


    // Vérification de l'objet
    if (document.getElementById('subject').value.trim().length < 2) {
        showError('subject', "L'object n'est pas correct.");
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