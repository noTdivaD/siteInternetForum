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
    var firstInvalidElement = null;

    clearErrors(); // Efface toutes les erreurs précédentes

     // Vérification du nom
     if (document.getElementById('nom').value.trim().length < 2 || !/^[A-Za-zàâäéèêëïîôöùûüç]+([-'][A-Za-zàâäéèêëïîôöùûüç]+)*$/.test(document.getElementById('nom').value.trim())) {
        showError('nom', "Le nom n'est pas correct.");
        isValid = false;
        firstInvalidElement = firstInvalidElement || nom; // Stocke le premier élément invalide
    }

    // Vérification du prénom
    if (document.getElementById('prenom').value.trim().length < 2 || !/^[A-Za-zàâäéèêëïîôöùûüç]+([-'][A-Za-zàâäéèêëïîôöùûüç]+)*$/.test(document.getElementById('prenom').value.trim())) {
        showError('prenom', "Le prénom n'est pas correct.");
        isValid = false;
        firstInvalidElement = firstInvalidElement || prenom;
    }

    // Vérification de l'adresse
    if (document.getElementById('adresse').value.trim().length < 2 || !/^[A-Za-zàâäéèêëïîôöùûüç0-9]+([ '-][A-Za-zàâäéèêëïîôöùûüç0-9]+)*$/.test(document.getElementById('adresse').value.trim())) {
        showError('adresse', "L'adresse est invalide.");
        isValid = false;
        firstInvalidElement = firstInvalidElement || adresse;
    }

    // Vérification de la ville
    if (document.getElementById('ville').value.trim().length < 2 || !/^[A-Za-zàâäéèêëïîôöùûüç]+([-'][A-Za-zàâäéèêëïîôöùûüç]+)*$/.test(document.getElementById('ville').value.trim())) {
        showError('ville', "La ville est invalide.");
        isValid = false;
        firstInvalidElement = firstInvalidElement || ville;
    }

    // Vérification du code postal
    if (document.getElementById('codePostal').value.trim().length < 2 || !/^[0-9]+$/.test(document.getElementById('codePostal').value.trim())) {
        showError('codePostal', "Code Postal Invalide");
        isValid = false;
        firstInvalidElement = firstInvalidElement || codePostal;
    }

    // Vérification de l'email
    var email = document.getElementById('email').value;
    var emailRegex = /^(?!.*\.\.)(?!.*\.$)(?!^\.)[A-Za-z0-9_.-]+@[A-Za-z0-9-]+\.[A-Za-z0-9.-]+$/;
    if (!emailRegex.test(email)) {
        showError('email', "L'adresse email n'est pas valide.");
        isValid = false;
        firstInvalidElement = firstInvalidElement || email;
    }

    //Vérification du mot de passe
    var password = document.getElementById('password').value;
    if (!password.match(/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/)) {
        showError('password', "Format du mot de passe incorrect.");
        isValid = false;
        firstInvalidElement = firstInvalidElement || password;
    }

    // Vérification des mots de passe
    var confirm_password = document.getElementById('confirm_password').value;
    if (password !== confirm_password) {
        showError('confirm_password', "Les mots de passe ne correspondent pas.");
        isValid = false;
        firstInvalidElement = firstInvalidElement || confirm_password;
    }
    

    if (!isValid) {
        event.preventDefault(); // Empêche la soumission du formulaire si invalide
        document.getElementById('error-form').textContent = "Certains champs du formulaire ne sont pas valides.";
        document.getElementById('error-form').style.display = 'block'; // Affiche le message d'erreur général
        firstInvalidElement.scrollIntoView({ behavior: 'smooth', block: 'center' }); // Défile jusqu'au premier champ invalide
    } else {
        document.getElementById('error-form').style.display = 'none'; // Affiche le message d'erreur général
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

//Génère une liste de Pays via une API
window.addEventListener('load', function() {
    const select = document.getElementById('pays');

    fetch('https://restcountries.com/v3.1/all') // API pour obtenir des informations sur tous les pays
    .then(response => response.json())
    .then(data => {
        data.forEach(country => {
            const option = document.createElement('option');
            option.value = country.name.common; // Utilisez country.cca2 si vous préférez les codes pays
            option.textContent = country.name.common;
            select.appendChild(option);
        });
    })
    .catch(error => console.error('Erreur lors du chargement des pays:', error));
});


