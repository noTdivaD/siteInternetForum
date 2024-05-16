document.addEventListener("DOMContentLoaded", function() {
    // Délégation d'événements pour la suppression et l'édition
    document.querySelector('.article-section').addEventListener('click', function(event) {
        if (event.target.classList.contains('delete-article-btn')) {
            event.preventDefault();
            const articleElement = event.target.closest('.article');
            const articleId = articleElement.getAttribute('data-article-id');
            if (articleId) {
                deleteArticle(articleId, articleElement);
            } else {
                console.error('Erreur: ID de l\'article non trouvé.');
            }
        }
        if (event.target.classList.contains('edit-article-btn')) {
            event.preventDefault();
            const articleElement = event.target.closest('.article');
            const articleId = articleElement.getAttribute('data-article-id');
            console.log('Édition de l\'article: ' + articleId);
            // Afficher un formulaire d'édition ou rediriger vers une page d'édition
        }
    });

    document.getElementById("addArticleForm").addEventListener("submit", function(event) {
        event.preventDefault();

        var formData = new FormData(this);

        console.log('Envoi du formulaire...');

        fetch('/app/accueil_upgrade/addArticle', {
            method: 'POST',
            body: formData
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                console.log('Article ajouté avec succès', data.article);
                var newArticleHtml = `
                    <div class="article" data-article-id="${data.article.id}">
                        <h2>${data.article.title}</h2>
                        <div class="article-content">${data.article.content}</div>
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
                modal.style.display = "none";
            } else {
                console.log('Erreur lors de l\'ajout de l\'article:', data.error);
                document.getElementById('error_message').textContent = data.error || 'Erreur inconnue.';
            }
        })
        .catch(error => {
            console.error('Erreur lors du parsing JSON ou lors de la requête AJAX:', error);
        });
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

function deleteArticle(articleId, articleElement) {
    fetch('/app/accueil_upgrade/deleteArticle', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: 'article_id=' + encodeURIComponent(articleId)
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            console.log('Article supprimé avec succès');
            articleElement.remove();
        } else {
            console.log('Erreur lors de la suppression de l\'article:', data.error);
        }
    })
    .catch(error => {
        console.error('Erreur lors de la requête AJAX de suppression:', error);
    });
}

// Gestion de la modale d'ajout d'article
var modal = document.getElementById("addArticleModal");
var btn = document.querySelector(".add-article-btn");
var span = document.getElementsByClassName("close")[0];

btn.onclick = function() {
    modal.style.display = "flex";
}

span.onclick = function() {
    modal.style.display = "none";
}

window.onclick = function(event) {
    if (event.target == modal) {
        modal.style.display = "none";
    }
}
