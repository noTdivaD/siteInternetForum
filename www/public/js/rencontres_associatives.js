document.addEventListener('DOMContentLoaded', function () {
    const editArticleButton = document.querySelector('.edit-article-btn');
    if (editArticleButton) {
        editArticleButton.addEventListener('click', function (event) {
            event.preventDefault();
            console.log("Ouverture de la modal d'édition d'article...");

            // Récupérer les données de l'article
            const articleId = 1; // Remplacez ceci par l'ID réel de l'article si nécessaire
            const articleTitle = decodeHtml(document.querySelector('.title').innerText);
            const articleContentTop = decodeHtml(document.querySelector('.content-top').innerText);
            const articleContentBottom = decodeHtml(document.querySelector('.content-bottom').innerText);

            // Remplir les champs du formulaire avec les données de l'article
            document.getElementById('edit-article-id').value = articleId;
            document.getElementById('edit-title').value = articleTitle;
            document.getElementById('edit-content-top').value = articleContentTop;
            document.getElementById('edit-content-bottom').value = articleContentBottom;

            // Afficher la fenêtre modale
            const editArticleModal = document.getElementById('editArticleModal');
            editArticleModal.style.display = "flex";

            // Gérer la fermeture de la fenêtre modale
            const editCloseSpan = editArticleModal.querySelector('.close');
            editCloseSpan.onclick = function () {
                console.log("Fermeture de la modal d'édition d'article...");
                editArticleModal.style.display = "none";
            };

            window.onclick = function (event) {
                if (event.target == editArticleModal) {
                    console.log("Fermeture de la modal d'édition d'article (clic en dehors)...");
                    editArticleModal.style.display = "none";
                }
            };
        });
    }

    const editAssociationButton = document.querySelector('.edit-association-btn');
    if (editAssociationButton) {
        editAssociationButton.addEventListener('click', function (event) {
            event.preventDefault();
            console.log("Ouverture de la modal d'édition d'association...");
            
            // Récupérer le nom de l'association souhaité
            const associationNom = "Nom de l'association souhaité";

            // Parcourir toutes les options du select
            const select = document.getElementById('association-select');
            for (let i = 0; i < select.options.length; i++) {
                // Vérifier si le nom de l'association correspond à l'option actuelle
                if (select.options[i].text === associationNom) {
                    // Sélectionner cette option
                    select.selectedIndex = i;
                    break; // Sortir de la boucle une fois que l'option est trouvée
                }
            }

            // Afficher la fenêtre modale
            const editAssociationModal = document.getElementById('editAssociationModal');
            editAssociationModal.style.display = "flex";

            // Gérer la fermeture de la fenêtre modale
            const editCloseSpan = editAssociationModal.querySelector('.close');
            editCloseSpan.onclick = function () {
                console.log("Fermeture de la modal d'édition d'association...");
                editAssociationModal.style.display = "none";
            };

            window.onclick = function (event) {
                if (event.target == editAssociationModal) {
                    console.log("Fermeture de la modal d'édition d'association (clic en dehors)...");
                    editAssociationModal.style.display = "none";
                }
            };
        });
    }

    document.getElementById('editArticleForm').addEventListener('submit', function (event) {
        event.preventDefault();
        console.log("Soumission du formulaire d'édition d'article...");

        // Récupérer les valeurs des champs du formulaire
        const articleId = document.getElementById('edit-article-id').value;
        const title = document.getElementById('edit-title').value.trim();
        const contentTop = document.getElementById('edit-content-top').value.trim();
        const contentBottom = document.getElementById('edit-content-bottom').value.trim();

        // Valider les champs du formulaire
        if (!title || !contentTop || !contentBottom) {
            displayErrorMessage("Tous les champs sont obligatoires.");
            return;
        }

        // Créer un objet FormData et y ajouter les données du formulaire
        const formData = new FormData();
        formData.append('article_id', articleId);
        formData.append('title', title);
        formData.append('content_top', contentTop);
        formData.append('content_bottom', contentBottom);

        console.log("Données envoyées :");
        console.log("ID de l'article :", articleId);
        console.log("Titre :", title);
        console.log("Contenu top :", contentTop);
        console.log("Contenu bottom :", contentBottom);

        // Effectuer une requête Fetch pour soumettre les données du formulaire
        fetch('/app/rencontres_associatives/updateArticle', {
            method: 'POST',
            body: formData
        })
        .then(response => {
            console.log("Raw Response: ", response);
            return response.text();
        })
        .then(text => {
            console.log("Response Text: ", text);
            return JSON.parse(text);
        })
        .then(data => {
            if (data.success) {
                // Mettre à jour l'affichage avec les nouvelles données
                document.querySelector('.text h1').innerText = title;
                document.querySelector('.text .content-top').innerHTML = contentTop;
                document.querySelector('.text .content-bottom').innerHTML = contentBottom;

                // Fermer la fenêtre modale et afficher un message de succès
                document.getElementById('editArticleModal').style.display = 'none';
                displayErrorMessage('');
                console.log('Contenu mis à jour avec succès.');
            } else {
                // Afficher un message d'erreur en cas d'échec
                displayErrorMessage(data.error || 'Erreur lors de la mise à jour du contenu.');
            }
        })
        .catch(error => {
            // Gérer les erreurs de requête
            console.error('Erreur:', error);
            displayErrorMessage('Erreur lors de la mise à jour du contenu.');
        });
    });

    document.getElementById('editAssociationForm').addEventListener('submit', function (event) {
        event.preventDefault();
        console.log("Soumission du formulaire d'édition d'association...");

        // Récupérer les valeurs des champs du formulaire
        const association = document.getElementById('association-select').value;

        // Valider les champs du formulaire
        if (!association) {
            displayErrorMessage("Tous les champs sont obligatoires.");
            return;
        }

        // Créer un objet FormData et y ajouter les données du formulaire
        const formData = new FormData();
        formData.append('association_id', association);

        console.log("Association :", association);

        // Effectuer une requête Fetch pour soumettre les données du formulaire
        fetch('/app/rencontres_associatives/updateAssociation', {
            method: 'POST',
            body: formData
        })
        .then(data => {
            if (data.success) {
                // Mettre à jour l'affichage avec les nouvelles données
                console.log('Contenu mis à jour avec succès.');
                
            } else {
                // Afficher un message d'erreur en cas d'échec
                displayErrorMessage(data.error || 'Erreur lors de la mise à jour du contenu.');
            }
        })
        .catch(error => {
            // Gérer les erreurs de requête
            console.error('Erreur:', error);
            displayErrorMessage('Erreur lors de la mise à jour du contenu.');
        });

        location.reload(true);
    });
});

// Fonction pour décoder les entités HTML
function decodeHtml(html) {
    const txt = document.createElement('textarea');
    txt.innerHTML = html;
    return txt.value;
}

// Fonction pour afficher les messages d'erreur
function displayErrorMessage(message) {
    document.getElementById('edit_error_message').textContent = message;
}
