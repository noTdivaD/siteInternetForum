// Fonction pour initialiser les zones de dépôt pour le téléchargement de fichiers
function initializeDropZones() {
    console.log("Initialisation des zones de dépôt...");
    document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
        const dropZoneElement = inputElement.closest(".drop-zone");

        // Fonction pour ouvrir le sélecteur de fichiers lorsque la zone de dépôt est cliquée
        const openFileSelector = function handler(e) {
            console.log("Zone de dépôt cliquée, ouverture du sélecteur de fichiers...");
            //inputElement.click();
            dropZoneElement.removeEventListener("click", handler); // Supprime l'écouteur après le premier clic
        };

        // Fonction pour mettre à jour la vignette lorsque le fichier est sélectionné
        const updateThumbnailHandler = function(e) {
            if (inputElement.files.length) {
                console.log("Fichier sélectionné :", inputElement.files[0]);
                updateThumbnail(dropZoneElement, inputElement.files[0]);
            }
        };

        // Fonction pour gérer l'état de survol du glisser-déposer
        const dragOverHandler = (e) => {
            e.preventDefault();
            dropZoneElement.classList.add("drop-zone--over");
        };

        // Fonction pour gérer le dépôt de fichier
        const dropHandler = function(e) {
            e.preventDefault();
            if (e.dataTransfer.files.length) {
                inputElement.files = e.dataTransfer.files;
                updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
            }
            dropZoneElement.classList.remove("drop-zone--over");
        };

        // Supprimer tous les écouteurs d'événements précédents avant d'ajouter de nouveaux
        dropZoneElement.removeEventListener("click", openFileSelector);
        inputElement.removeEventListener("change", updateThumbnailHandler);
        dropZoneElement.removeEventListener("dragover", dragOverHandler);
        dropZoneElement.removeEventListener("drop", dropHandler);

        // Ajouter l'écouteur d'événement de clic
        dropZoneElement.addEventListener("click", openFileSelector, { once: true });
        inputElement.addEventListener("change", updateThumbnailHandler);
        dropZoneElement.addEventListener("dragover", dragOverHandler);
        dropZoneElement.addEventListener("drop", dropHandler);

        // Événements pour gérer les états de sortie de survol
        ["dragleave", "dragend"].forEach((type) => {
            dropZoneElement.addEventListener(type, (e) => {
                dropZoneElement.classList.remove("drop-zone--over");
            });
        });
    });
}

// Fonction pour mettre à jour la vignette dans la zone de dépôt
function updateThumbnail(dropZoneElement, file) {
    console.log("Mise à jour de la vignette...");
    let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

    // Suppression de l'invite si elle existe
    if (dropZoneElement.querySelector(".drop-zone__prompt")) {
        dropZoneElement.querySelector(".drop-zone__prompt").remove();
    }

    // Création de l'élément de vignette s'il n'existe pas
    if (!thumbnailElement) {
        thumbnailElement = document.createElement("div");
        thumbnailElement.classList.add("drop-zone__thumb");
        dropZoneElement.appendChild(thumbnailElement);
    }

    // Mise à jour du texte de la vignette avec le nom du fichier
    thumbnailElement.textContent = file.name;

    // Suppression de la vignette si aucun fichier n'est présent
    if (!file) {
        thumbnailElement.remove();
        dropZoneElement.innerHTML = '<span class="drop-zone__prompt">Sélectionnez ou Déposer votre Fichier Ici</span>';
    }
}

// Fonction pour réinitialiser la zone de dépôt
function resetDropZone(dropZoneElement, activate = true) {
    console.log("Réinitialisation de la zone de dépôt...");
    dropZoneElement.innerHTML = '<span class="drop-zone__prompt">Sélectionnez ou Déposer votre Fichier Ici</span>';
    const inputElement = document.createElement("input");
    inputElement.classList.add("drop-zone__input");
    inputElement.type = "file";
    inputElement.name = "image";
    dropZoneElement.appendChild(inputElement);
    console.log("Élément d'entrée de la zone de dépôt réinitialisé");

    // Désactiver la zone de dépôt si non activée
    if (!activate) {
        inputElement.disabled = true;
    } else {
        initializeDropZoneEvents(dropZoneElement, inputElement);
    }
}

// Fonction pour réinitialiser les événements de la zone de dépôt
function initializeDropZoneEvents(dropZoneElement, inputElement) {
    console.log("Réinitialisation des événements de la zone de dépôt...");
    
    // Fonction pour ouvrir le sélecteur de fichiers lorsque la zone de dépôt est cliquée
    const openFileSelector = function handler(e) {
        console.log("Zone de dépôt cliquée, ouverture du sélecteur de fichiers...");
        //inputElement.click();
        dropZoneElement.removeEventListener("click", handler); // Supprime l'écouteur après le premier clic
    };

    // Fonction pour mettre à jour la vignette lorsque le fichier est sélectionné
    const updateThumbnailHandler = function(e) {
        if (inputElement.files.length) {
            console.log("Fichier sélectionné :", inputElement.files[0]);
            updateThumbnail(dropZoneElement, inputElement.files[0]);
        }
    };

    // Fonction pour gérer l'état de survol du glisser-déposer
    const dragOverHandler = (e) => {
        e.preventDefault();
        dropZoneElement.classList.add("drop-zone--over");
    };

    // Fonction pour gérer le dépôt de fichier
    const dropHandler = function(e) {
        e.preventDefault();
        if (e.dataTransfer.files.length) {
            inputElement.files = e.dataTransfer.files;
            updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
        }
        dropZoneElement.classList.remove("drop-zone--over");
    };

    // Ajouter les écouteurs d'événements de la zone de dépôt
    dropZoneElement.addEventListener("click", openFileSelector, { once: true });
    inputElement.addEventListener("change", updateThumbnailHandler);
    dropZoneElement.addEventListener("dragover", dragOverHandler);
    dropZoneElement.addEventListener("drop", dropHandler);

    // Événements pour gérer les états de sortie de survol
    ["dragleave", "dragend"].forEach((type) => {
        dropZoneElement.addEventListener(type, (e) => {
            dropZoneElement.classList.remove("drop-zone--over");
        });
    });
}

// Initialisation des zones de dépôt au chargement de la page
document.addEventListener("DOMContentLoaded", function() {
    initializeDropZones();

    // Gestion des clics sur les boutons de la section des articles
    document.querySelector('.article-section').addEventListener('click', function(event) {
        if (event.target.classList.contains('delete-article-btn')) {
            event.preventDefault();
            const articleElement = event.target.closest('.article');
            const articleId = articleElement.getAttribute('data-article-id');
            if (articleId) {
                console.log("Suppression de l'article avec ID :", articleId);
                deleteArticle(articleId, articleElement);
            } else {
                console.error('Erreur : ID de l\'article non trouvé.');
            }
        }
        if (event.target.classList.contains('edit-article-btn')) {
            event.preventDefault();
            const articleElement = event.target.closest('.article');
            const articleId = articleElement.getAttribute('data-article-id');
            if (articleId) {
                const articleTitle = articleElement.querySelector('h2').innerText;
                const articleContent = articleElement.querySelector('.article-content').innerText;
                const articleImage = articleElement.querySelector('img') ? articleElement.querySelector('img').src : null;
                console.log("Édition de l'article avec ID :", articleId);
                openEditModal(articleId, articleTitle, articleContent, articleImage);
            } else {
                console.error('Erreur : ID de l\'article non trouvé.');
            }
        }
    });

    // Gestion des modales d'ajout et d'édition d'articles
    var addArticleModal = document.getElementById("addArticleModal");
    var editArticleModal = document.getElementById("editArticleModal");
    var btn = document.querySelector(".add-article-btn");
    var addCloseSpan = addArticleModal.getElementsByClassName("close")[0];
    var editCloseSpan = editArticleModal.getElementsByClassName("close")[0];

    btn.onclick = function() {
        console.log("Ouverture de la modal d'ajout d'article...");
        addArticleModal.style.display = "flex";
    }

    addCloseSpan.onclick = function() {
        addArticleModal.style.display = "none";
    }

    editCloseSpan.onclick = function() {
        editArticleModal.style.display = "none";
    }

    // Fermeture des modales lorsqu'on clique en dehors de celles-ci
    window.onclick = function(event) {
        if (event.target == addArticleModal) {
            addArticleModal.style.display = "none";
        } else if (event.target == editArticleModal) {
            editArticleModal.style.display = "none";
        }
    }
});

// Fonction pour ouvrir la modal d'édition d'article
function openEditModal(articleId, title, content, imageUrl) {
    console.log("Ouverture de la modal d'édition pour l'article ID :", articleId);
    document.getElementById('edit-article-id').value = articleId;
    document.getElementById('edit-title').value = title;
    document.getElementById('edit-content').value = content;
    const deleteImageCheckbox = document.getElementById('delete-image');
    const deleteImageContainer = document.getElementById('delete-image-container');
    const imageInput = document.getElementById('edit-image');
    const dropZoneElement = document.getElementById("drop-zone-edit");

    // Activer le champ de téléchargement de l'image
    if (imageInput) {
        imageInput.disabled = false;
    }

    // Si l'article a une image
    if (imageUrl) {
        deleteImageContainer.style.display = 'block';
        deleteImageCheckbox.checked = false;

        // Afficher le nom de l'image actuelle
        dropZoneElement.innerHTML = `<span class="drop-zone__thumb">${imageUrl.split('/').pop()}</span>`;

        // Désactiver le drop zone
        if (imageInput) {
            imageInput.disabled = true;
        }

        // Gérer les changements de l'état de la case à cocher de suppression d'image
        deleteImageCheckbox.addEventListener('change', function() {
            if (this.checked) {
                resetDropZone(dropZoneElement, true);
                //initializeDropZoneEvents(dropZoneElement, imageInput); // Réinitialiser les événements après réinitialisation
            } else {
                resetDropZone(dropZoneElement, false);
                dropZoneElement.innerHTML = `<span class="drop-zone__thumb">${imageUrl.split('/').pop()}</span>`;
                if (imageInput) {
                    imageInput.disabled = true;
                }
            }
        });
    } else {
        deleteImageContainer.style.display = 'none';
        resetDropZone(dropZoneElement, true);
        //initializeDropZoneEvents(dropZoneElement, imageInput); // Réinitialiser les événements après réinitialisation
    }
    editArticleModal.style.display = "flex";
}

// Gestion de la soumission du formulaire d'ajout d'article
document.getElementById("addArticleForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const title = document.getElementById("title").value.trim();
    const content = document.getElementById("content").value.trim();

    if (!title || !content) {
        document.getElementById('error_message').textContent = 'Les champs titre et contenu sont obligatoires.';
        return;
    }

    console.log("Titre avant envoi : ", title);
    console.log("Contenu avant envoi : ", content);

    const formData = new FormData(this);

    console.log('Envoi du formulaire...');

    fetch('/app/accueil_upgrade/addArticle', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('La réponse du réseau n\'était pas correcte');
        }
        return response.json();
    })
    .then(data => {
        console.log("Réponse du serveur :", data);
        if (data.success) {
            console.log('Article ajouté avec succès', data.article);
            var newArticleHtml = `
                <div class="article" data-article-id="${data.article.id}">
                    <h2>${decodeHtml(data.article.title)}</h2>
                    <div class="article-content">${decodeHtml(data.article.content)}</div>
                    ${data.article.image_url ? `<img src="${data.article.image_url}" alt="Image de l'article">` : ''}
                    <div class="article-controls">
                        <button class="edit-article-btn">Éditer</button>
                        <button class="delete-article-btn">Supprimer</button>
                    </div>
                </div>`;
            var articleSection = document.querySelector('.article-section');
            var addButton = articleSection.querySelector('.add-article-btn').parentElement;
            addButton.insertAdjacentHTML('beforebegin', newArticleHtml);
            document.getElementById("addArticleForm").reset();
            resetDropZone(document.getElementById("drop-zone-add"));
            //initializeDropZoneEvents(document.getElementById("drop-zone-add"), document.querySelector("#drop-zone-add input[type='file']")); // Réinitialiser les événements après réinitialisation
            addArticleModal.style.display = "none";
        } else {
            console.log('Erreur lors de l\'ajout de l\'article :', data.error);
            document.getElementById('error_message').textContent = data.error || 'Erreur inconnue.';
        }
    })
    .catch(error => {
        console.error('Erreur lors du parsing JSON ou de la requête AJAX :', error);
        document.getElementById('error_message').textContent = 'Erreur lors de l\'ajout de l\'article.';
    });

    var swiper = new Swiper('.swiper-container', {
        // Optional parameters
        direction: 'horizontal',
        loop: true,
        slidesPerView: 1,
        slidesPerGroup: 1,
    
        // If you need pagination
        pagination: {
          el: '.swiper-pagination',
        },
    
        // Navigation arrows
        navigation: {
          nextEl: '.swiper-button-next',
          prevEl: '.swiper-button-prev',
        },
      });

});

// Gestion de la soumission du formulaire d'édition d'article
document.getElementById("editArticleForm").addEventListener("submit", function(event) {
    event.preventDefault();

    const title = document.getElementById("edit-title").value.trim();
    const content = document.getElementById("edit-content").value.trim();
    const deleteImageCheckbox = document.getElementById('delete-image');
    const imageInput = document.getElementById('edit-image');

    if (!title || !content) {
        document.getElementById('edit_error_message').textContent = 'Les champs titre et contenu sont obligatoires.';
        return;
    }

    const formData = new FormData(this);

    // Ajouter une indication pour la suppression de l'image dans les données du formulaire
    if (deleteImageCheckbox.checked && (!imageInput || !imageInput.files.length)) {
        formData.append('delete_image', '1');
    }

    console.log('Envoi du formulaire de modification...');

    fetch('/app/accueil_upgrade/updateArticle', {
        method: 'POST',
        body: formData
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('La réponse du réseau n\'était pas correcte');
        }
        return response.json();
    })
    .then(data => {
        console.log("Réponse du serveur :", data);
        if (data.success) {
            console.log('Article modifié avec succès', data.article);
            const articleElement = document.querySelector(`.article[data-article-id='${data.article.id}']`);
            articleElement.querySelector('h2').innerText = decodeHtml(data.article.title);
            articleElement.querySelector('.article-content').innerHTML = decodeHtml(data.article.content);
            if (data.article.image_url) {
                let imgElement = articleElement.querySelector('img');
                if (imgElement) {
                    imgElement.src = data.article.image_url;
                } else {
                    const articleControls = articleElement.querySelector('.article-controls');
                    const imgHtml = `<img src="${data.article.image_url}" alt="Image de l'article">`;
                    articleControls.insertAdjacentHTML('beforebegin', imgHtml);
                }
            } else {
                if (articleElement.querySelector('img')) {
                    articleElement.querySelector('img').remove();
                }
            }
            document.getElementById("editArticleForm").reset();
            resetDropZone(document.getElementById("drop-zone-edit"));
            editArticleModal.style.display = "none";
            initializeDropZones(); // Réinitialiser les zones de dépôt après réinitialisation
        } else {
            console.log('Erreur lors de la modification de l\'article :', data.error);
            document.getElementById('edit_error_message').textContent = data.error || 'Erreur inconnue.';
        }
    })
    .catch(error => {
        console.error('Erreur lors du parsing JSON ou de la requête AJAX :', error);
        document.getElementById('edit_error_message').textContent = 'Erreur lors de la modification de l\'article.';
    });
});


// Fonction pour décoder les entités HTML
function decodeHtml(html) {
    var txt = document.createElement('textarea');
    txt.innerHTML = html;
    return txt.value;
}

// Fonction pour supprimer un article
function deleteArticle(articleId, articleElement) {
    const formData = new URLSearchParams();
    formData.append('article_id', articleId);

    console.log("Envoi de la demande de suppression pour l'article ID :", articleId);

    fetch('/app/accueil_upgrade/deleteArticle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'
        },
        body: formData.toString()
    })
    .then(response => response.json())
    .then(data => {
        console.log("Réponse du serveur :", data);
        if (data.success) {
            console.log('Article supprimé avec succès');
            articleElement.remove();
        } else {
            console.log('Erreur lors de la suppression de l\'article :', data.error);
        }
    })
    .catch(error => {
        console.error('Erreur lors de la requête AJAX de suppression :', error);
    });
}
