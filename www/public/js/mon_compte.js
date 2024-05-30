document.addEventListener('DOMContentLoaded', function() {
    const formAccount = document.getElementById('formAccount');
    const editButton = document.getElementById('edit-button');
    const saveButton = document.getElementById('save-button');
    const profilePhotoInput = document.getElementById('profile-photo-input');
    const profilePhoto = document.getElementById('profile-photo');
    const addPhotoIcon = document.getElementById('add-photo-icon');
    const errorMessageDiv = document.getElementById("error_message");

    // Rendre les champs éditables et activer l'overlay de la photo de profil
    editButton.addEventListener('click', function() {
        const inputs = document.querySelectorAll('.account-info input:not(#email):not(#user_type)');
        inputs.forEach(input => {
            input.removeAttribute('readonly');
            input.style.backgroundColor = '#fff';
            input.style.pointerEvents = 'auto';
            input.style.color = '#333'; // Changer la couleur du texte
        });

        // Activer l'overlay de la photo de profil
        document.querySelector('.profile-photo-container').classList.add('editable');

        // Cacher le bouton "Modifier" et afficher le bouton "Enregistrer"
        editButton.style.display = 'none';
        saveButton.style.display = 'block';
    });

    // Ouvrir le sélecteur de fichiers pour changer la photo de profil
    addPhotoIcon.addEventListener('click', function() {
        profilePhotoInput.click();
    });

    // Afficher la nouvelle photo de profil sélectionnée
    profilePhotoInput.addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                profilePhoto.src = e.target.result;
            };
            reader.readAsDataURL(file);
        }
    });

    // Valider les champs et soumettre le formulaire via AJAX
    formAccount.addEventListener('submit', function(event) {
        event.preventDefault();  // Prévenir la soumission du formulaire normale

        let isValid = true;
        clearErrors(); // Efface toutes les erreurs précédentes

        // Vérification des champs
        if (!validateField('firstname', "Le prénom n'est pas correct.", /^[A-Za-zàâäéèêëïîôöùûüç]+([-'\s][A-Za-zàâäéèêëïîôöùûüç]+)*$/, 2)) {
            isValid = false;
        }
        if (!validateField('lastname', "Le nom n'est pas correct.", /^[A-Za-zàâäéèêëïîôöùûüç]+([-'\s][A-Za-zàâäéèêëïîôöùûüç]+)*$/, 2)) {
            isValid = false;
        }
        if (!validateField('address', "L'adresse n'est pas correcte.", /.*/, 2)) {
            isValid = false;
        }
        if (!validateField('city', "La ville n'est pas correcte.", /.*/, 2)) {
            isValid = false;
        }
        if (!validateField('postal_code', "Le code postal n'est pas valide.", /^\d{5}$/, 5)) {
            isValid = false;
        }
        if (!validateField('country', "Le pays n'est pas correct.", /.*/, 2)) {
            isValid = false;
        }

        if (!isValid) {
            return;
        }

        const formData = new FormData(formAccount);

        fetch(formAccount.action, {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                // Mettre à jour l'interface utilisateur avec les nouvelles données
                editButton.style.display = 'block';
                saveButton.style.display = 'none';
                const inputs = document.querySelectorAll('.account-info input');
                inputs.forEach(input => {
                    input.setAttribute('readonly', true);
                    input.style.backgroundColor = '#f1f1f1';
                    input.style.pointerEvents = 'none';
                    input.style.color = '#6a6969';
                });

                // Désactiver l'overlay de la photo de profil
                document.querySelector('.profile-photo-container').classList.remove('editable');

                if (data.photo_profil_url) {
                    profilePhoto.src = data.photo_profil_url;

                    // Mettre à jour la photo de profil dans le header
                    const headerProfilePic = document.querySelector('.header-profile-pic');
                    if (headerProfilePic) {
                        headerProfilePic.src = data.photo_profil_url;
                    }
                }

                errorMessageDiv.innerText = "Mise à jour réussie.";
                errorMessageDiv.style.color = "green";
            } else {
                errorMessageDiv.innerText = data.error;
                errorMessageDiv.style.color = "red";
            }
        })
        .catch(error => {
            errorMessageDiv.innerText = "Une erreur est survenue.";
            errorMessageDiv.style.color = "red";
        });
    });

    function validateField(fieldId, message, regex, minLength = 0) {
        const input = document.getElementById(fieldId);
        const value = input.value.trim();
        if (value.length < minLength || !regex.test(value)) {
            showError(fieldId, message);
            return false;
        }
        return true;
    }

    function showError(fieldId, message) {
        const input = document.getElementById(fieldId);
        let errorDiv = document.getElementById('error-' + fieldId);
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
        const errorMessages = document.querySelectorAll('.error-message');
        errorMessages.forEach(function(error) {
            error.textContent = '';
            error.style.display = 'none';
        });
        const inputs = document.querySelectorAll('input, select');
        inputs.forEach(function(input) {
            input.style.borderColor = 'initial'; 
        });
    }
});
