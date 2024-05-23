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

    fetch('/app/journee_forum/updateArticle', {
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