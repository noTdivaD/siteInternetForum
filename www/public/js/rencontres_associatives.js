document.addEventListener('DOMContentLoaded', function () {
    const editArticleButton = document.querySelector('.edit-article-btn');
    if (editArticleButton) {
        editArticleButton.addEventListener('click', function (event) {
            event.preventDefault();
            console.log("Ouverture de la modal d'édition d'article...");

            const articleId = 1; // Remplacez ceci par l'ID réel de l'article si nécessaire
            const articleTitle = decodeHtml(document.querySelector('.title').innerText);
            const articleContentHtml = document.querySelector('.content-top').innerText;
            const articleContentBottomHtml = document.querySelector('.content-bottom').innerText;
  
            const articleContentTop = decodeHtml(articleContentHtml.replace(/<br\s*\/?>\s*<br\s*\/?>/gm, "\n\n").replace(/<br\s*\/?>/gm, "\n"));
            const articleContentBottom = decodeHtml(articleContentBottomHtml.replace(/<br\s*\/?>\s*<br\s*\/?>/gm, "\n\n").replace(/<br\s*\/?>/gm, "\n"));

            console.log("Titre de l'article:", articleTitle);
            console.log("Contenu de l'article (haut):", articleContentTop);
            console.log("Contenu de l'article (bas):", articleContentBottom);

            document.getElementById('edit-article-id').value = articleId;
            document.getElementById('edit-title').value = articleTitle;
            document.getElementById('edit-content-top').value = articleContentTop;
            document.getElementById('edit-content-bottom').value = articleContentBottom;

            const editArticleModal = document.getElementById('editArticleModal');
            editArticleModal.style.display = "flex";

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

    document.getElementById('editArticleForm').addEventListener('submit', function (event) {
        event.preventDefault();
        console.log("Soumission du formulaire d'édition d'article...");

        const title = document.getElementById('edit-title').value.trim();
        const contentTop = document.getElementById('edit-content-top').value.trim();
        const contentBottom = document.getElementById('edit-content-bottom').value.trim();
        

        if (!title || !contentTop || !contentBottom) {
            displayErrorMessage("Tous les champs sont obligatoires.");
            return;
        }

        const contentHtmlTop = contentTop.replace(/\n\n/g, "<br><br>").replace(/\n/g, "<br>");
        const contentHtmlBottom = contentBottom.replace(/\n\n/g, "<br><br>").replace(/\n/g, "<br>");

        const formData = new FormData();
        formData.append('article_id', document.getElementById('edit-article-id').value);
        formData.append('title', title);
        formData.append('content_top', contentHtmlTop);
        formData.append('content_bottom', contentHtmlBottom);

        console.log("Données envoyées :");
        console.log("ID de l'article :", document.getElementById('edit-article-id').value);
        console.log("Titre :", title);
        console.log("Contenu top :", contentHtmlTop);
        console.log("Contenu bottom :", contentHtmlBottom);

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
                    document.querySelector('.text h1').innerText = title;
                    document.querySelector('.text .content-top').innerHTML = contentHtmlTop;
                    document.querySelector('.text .content-bottom').innerHTML = contentHtmlBottom;

                    document.getElementById('editArticleModal').style.display = 'none';
                    displayErrorMessage(''); // Clear any existing error messages

                    console.log('Contenu mis à jour avec succès.');
                } else {
                    displayErrorMessage(data.error || 'Erreur lors de la mise à jour du contenu.');
                }
            })
            .catch(error => {
                console.error('Erreur:', error);
                displayErrorMessage('Erreur lors de la mise à jour du contenu.');
            });
    });
});

function decodeHtml(html) {
    const txt = document.createElement('textarea');
    txt.innerHTML = html;
    return txt.value;
}

function displayErrorMessage(message) {
    document.getElementById('edit_error_message').textContent = message;
}
