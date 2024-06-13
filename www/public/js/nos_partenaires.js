document.addEventListener('DOMContentLoaded', function () {
    var swiper = new Swiper('.swiper-container', {
        slidesPerView: 1,
        spaceBetween: 0, // No space between slides
        loop: true,
        pagination: {
            el: '.swiper-pagination',
            clickable: true,
        },
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
    });

    // JavaScript pour gérer les modales
    var addPartenaireModal = document.getElementById('addPartenaireModal');
    var editParagraphModal = document.getElementById('editParagraphModal');
    var editPartenaireModal = document.getElementById('editPartenaireModal');
    var closeButtons = document.querySelectorAll('.close');
    var addPartenaireButton = document.querySelector('.btn-add-association');
    var modifyParagraphButton = document.querySelector('.btn-modify-paragraph');
    var modifyPartenaireButtons = document.querySelectorAll('.btn-modify');

    // Ouvrir la modale d'ajout de partenaire
    if (addPartenaireButton) {
        addPartenaireButton.addEventListener('click', function() {
            addPartenaireModal.style.display = 'flex';
        });
    }

    // Ouvrir la modale d'édition du paragraphe
    if (modifyParagraphButton) {
        modifyParagraphButton.addEventListener('click', function() {
            editParagraphModal.style.display = 'flex';

            // Utiliser AJAX pour récupérer le paragraphe actuel
            fetch('/app/nos_partenaires/getParagraphAjax')
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit-content').value = data.content_value;
                    document.getElementById('edit-content').innerHTML = data.content_value;
                })
                .catch(error => {
                    displayErrorMessage('editParagraphModal', 'Une erreur est survenue lors de la récupération du paragraphe.');
                    console.error('Error:', error);
                });
        });
    }

    // Ouvrir la modale d'édition de partenaire
    modifyPartenaireButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            editPartenaireModal.style.display = 'flex';
            var partenaireId = button.getAttribute('data-id');

            // Utiliser AJAX pour récupérer les détails du partenaire à partir de l'ID
            fetch(`/app/nos_partenaires/getPartenaireByIdAjax?id=${partenaireId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit-title').value = data.titre;
                    document.getElementById('edit-nom').value = data.nom;
                    document.getElementById('edit-description').value = data.description;
                    var dropZone = document.getElementById('drop-zone-edit');
                    var dropZonePrompt = dropZone.querySelector('.drop-zone__prompt');
                    var deleteImageCheckbox = document.getElementById('delete-image');
                    var deleteImageContainer = document.getElementById('delete-image-container');

                    if (data.image_url) {
                        dropZonePrompt.textContent = data.image_url.split('/').pop();
                        deleteImageContainer.style.display = 'block';
                        dropZone.querySelector('.drop-zone__input').disabled = true;
                    } else {
                        dropZonePrompt.textContent = 'Sélectionnez ou Déposer votre Fichier Ici';
                        deleteImageContainer.style.display = 'none';
                        dropZone.querySelector('.drop-zone__input').disabled = false;
                    }

                    // Activer/désactiver la zone de dépôt en fonction de la case à cocher
                    deleteImageCheckbox.addEventListener('change', function() {
                        if (deleteImageCheckbox.checked) {
                            dropZone.querySelector('.drop-zone__input').disabled = false;
                            dropZonePrompt.textContent = 'Sélectionnez ou Déposer votre Fichier Ici';
                        } else {
                            dropZone.querySelector('.drop-zone__input').disabled = true;
                            dropZonePrompt.textContent = data.image_url.split('/').pop();
                        }
                    });

                    document.getElementById('editPartenaireForm').dataset.id = partenaireId; // Stocker l'ID pour l'envoi du formulaire
                })
                .catch(error => {
                    displayErrorMessage('editPartenaireModal', 'Une erreur est survenue lors de la récupération des détails du partenaire.');
                    console.error('Error:', error);
                });
        });
    });

    // Mettre à jour le texte de la zone de dépôt lors de la sélection d'un fichier
    var dropZones = document.querySelectorAll('.drop-zone');
    dropZones.forEach(function(dropZone) {
        var input = dropZone.querySelector('.drop-zone__input');
        var prompt = dropZone.querySelector('.drop-zone__prompt');

        input.addEventListener('change', function() {
            if (input.files.length) {
                prompt.textContent = input.files[0].name;
            } else {
                prompt.textContent = 'Sélectionnez ou Déposer votre Fichier Ici';
            }
        });
    });

    // Fermer les modales
    closeButtons.forEach(function(button) {
        button.addEventListener('click', function() {
            button.closest('.modal').style.display = 'none';
            clearErrorMessage(button.closest('.modal').id);
        });
    });

    // Fermer les modales lorsque l'utilisateur clique à l'extérieur
    window.addEventListener('click', function(event) {
        if (event.target === addPartenaireModal) {
            addPartenaireModal.style.display = 'none';
        } else if (event.target === editParagraphModal) {
            editParagraphModal.style.display = 'none';
        } else if (event.target === editPartenaireModal) {
            editPartenaireModal.style.display = 'none';
        }
        clearErrorMessage(event.target.id);
    });

    // Gestion de l'ajout de partenaire
    document.getElementById('addPartenaireForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this);

        fetch('/app/nos_partenaires/addPartenaireAjax', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                addPartenaireToDOM(data.partenaire);
                addPartenaireModal.style.display = 'none';
                clearErrorMessage('addPartenaireModal');
            } else {
                displayErrorMessage('addPartenaireModal', data.message || 'Une erreur est survenue lors de l\'ajout du partenaire.');
            }
        })
        .catch(error => {
            displayErrorMessage('addPartenaireModal', 'Une erreur est survenue lors de l\'ajout du partenaire.');
            console.error('Error:', error);
        });
    });

    // Gestion de la modification de partenaire
    document.getElementById('editPartenaireForm').addEventListener('submit', function(event) {
        event.preventDefault();

        var deleteImageCheckbox = document.getElementById('delete-image');
        var imageInput = document.querySelector('#drop-zone-edit .drop-zone__input');
        
        // Vérifier si l'image doit être supprimée mais qu'aucune nouvelle image n'est fournie
        if (deleteImageCheckbox.checked && imageInput.files.length === 0) {
            displayErrorMessage('editPartenaireModal', 'Vous devez ajouter une nouvelle image si vous supprimez l\'image existante.');
            return;
        }

        var formData = new FormData(this);
        formData.append('id', this.dataset.id);

        fetch('/app/nos_partenaires/updatePartenaireAjax', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                updatePartenaireInDOM(data.partenaire);
                editPartenaireModal.style.display = 'none';
                clearErrorMessage('editPartenaireModal');
            } else {
                displayErrorMessage('editPartenaireModal', data.message || 'Une erreur est survenue lors de la modification du partenaire.');
            }
        })
        .catch(error => {
            displayErrorMessage('editPartenaireModal', 'Une erreur est survenue lors de la modification du partenaire.');
            console.error('Error:', error);
        });
    });

    function addPartenaireToDOM(partenaire) {
        var swiperWrapper = document.querySelector('.swiper-wrapper');
        var newSlide = document.createElement('div');
        newSlide.classList.add('swiper-slide');
        newSlide.innerHTML = `
            <div class="partner-item">
                <h2>${partenaire.titre}</h2>
                <img src="${partenaire.image_url}" alt="${partenaire.nom}">
                <p>${partenaire.nom}</p>
                <p class="description">${partenaire.description}</p>
                <button class="btn-modify" data-id="${partenaire.id}">Modifier</button>
                <button class="btn-delete" data-id="${partenaire.id}">Supprimer</button>
            </div>
        `;
        swiperWrapper.appendChild(newSlide);
        swiper.update(); // Mettre à jour le swiper

        // Réattacher les événements aux nouveaux boutons
        attachModifyButtonEvent(newSlide.querySelector('.btn-modify'));
        attachDeleteButtonEvent(newSlide.querySelector('.btn-delete'));
    }

    function updatePartenaireInDOM(partenaire) {
        var slide = document.querySelector(`.swiper-slide .btn-modify[data-id='${partenaire.id}']`).closest('.swiper-slide');
        slide.querySelector('h2').textContent = partenaire.titre;
        slide.querySelector('img').src = partenaire.image_url;
        slide.querySelector('img').alt = partenaire.nom;
        slide.querySelector('p').textContent = partenaire.nom;
        slide.querySelector('.description').textContent = partenaire.description;
    }

    function attachModifyButtonEvent(button) {
        button.addEventListener('click', function() {
            editPartenaireModal.style.display = 'flex';
            var partenaireId = button.getAttribute('data-id');

            fetch(`/app/nos_partenaires/getPartenaireByIdAjax?id=${partenaireId}`)
                .then(response => response.json())
                .then(data => {
                    document.getElementById('edit-title').value = data.titre;
                    document.getElementById('edit-nom').value = data.nom;
                    document.getElementById('edit-description').value = data.description;
                    var dropZone = document.getElementById('drop-zone-edit');
                    var dropZonePrompt = dropZone.querySelector('.drop-zone__prompt');
                    var deleteImageCheckbox = document.getElementById('delete-image');
                    var deleteImageContainer = document.getElementById('delete-image-container');

                    if (data.image_url) {
                        dropZonePrompt.textContent = data.image_url.split('/').pop();
                        deleteImageContainer.style.display = 'block';
                        dropZone.querySelector('.drop-zone__input').disabled = true;
                    } else {
                        dropZonePrompt.textContent = 'Sélectionnez ou Déposer votre Fichier Ici';
                        deleteImageContainer.style.display = 'none';
                        dropZone.querySelector('.drop-zone__input').disabled = false;
                    }

                    // Activer/désactiver la zone de dépôt en fonction de la case à cocher
                    deleteImageCheckbox.addEventListener('change', function() {
                        if (deleteImageCheckbox.checked) {
                            dropZone.querySelector('.drop-zone__input').disabled = false;
                            dropZonePrompt.textContent = 'Sélectionnez ou Déposer votre Fichier Ici';
                        } else {
                            dropZone.querySelector('.drop-zone__input').disabled = true;
                            dropZonePrompt.textContent = data.image_url.split('/').pop();
                        }
                    });

                    document.getElementById('editPartenaireForm').dataset.id = partenaireId;
                })
                .catch(error => {
                    displayErrorMessage('editPartenaireModal', 'Une erreur est survenue lors de la récupération des détails du partenaire.');
                    console.error('Error:', error);
                });
        });
    }

    modifyPartenaireButtons.forEach(attachModifyButtonEvent);

    // Attacher les événements de suppression aux boutons
    var deletePartenaireButtons = document.querySelectorAll('.btn-delete');

    function attachDeleteButtonEvent(button) {
        button.addEventListener('click', function() {
            var partenaireId = button.getAttribute('data-id');
            
            // Utiliser AJAX pour supprimer le partenaire à partir de l'ID
            fetch(`/app/nos_partenaires/deletePartenaireAjax?id=${partenaireId}`, {
                method: 'POST'
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Supprimer le partenaire du DOM
                    var slide = button.closest('.swiper-slide');
                    slide.remove();
                    swiper.update(); // Mettre à jour le swiper
                } else {
                    displayErrorMessage('deletePartenaireModal', data.message || 'Une erreur est survenue lors de la suppression du partenaire.');
                }
            })
            .catch(error => {
                displayErrorMessage('deletePartenaireModal', 'Une erreur est survenue lors de la suppression du partenaire.');
                console.error('Error:', error);
            });
        });
    }

    // Attacher l'événement de suppression aux boutons existants
    deletePartenaireButtons.forEach(attachDeleteButtonEvent);

    // Gestion de la modification du paragraphe
    document.getElementById('editParagraphForm').addEventListener('submit', function(event) {
        event.preventDefault();
        var formData = new FormData(this);

        fetch('/app/nos_partenaires/updateParagraphAjax', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                updateParagraphInDOM(data.paragraph);
                editParagraphModal.style.display = 'none';
                clearErrorMessage('editParagraphModal');
            } else {
                displayErrorMessage('editParagraphModal', data.message || 'Une erreur est survenue lors de la modification du paragraphe.');
            }
        })
        .catch(error => {
            displayErrorMessage('editParagraphModal', 'Une erreur est survenue lors de la modification du paragraphe.');
            console.error('Error:', error);
        });
    });

    function updateParagraphInDOM(paragraph) {
        document.querySelector('.text-section').innerHTML = paragraph;
    }

    function displayErrorMessage(modalId, message) {
        var modal = document.getElementById(modalId);
        var errorMessageDiv = modal.querySelector('#error_message');
        errorMessageDiv.textContent = message;
    }

    function clearErrorMessage(modalId) {
        var modal = document.getElementById(modalId);
        var errorMessageDiv = modal.querySelector('#error_message');
        errorMessageDiv.textContent = '';
    }
});
