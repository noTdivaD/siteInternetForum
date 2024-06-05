// Ouvrir la fenêtre modale pour modifier l'article
document.querySelector('.edit-article-btn').addEventListener('click', function(event) {
    event.preventDefault();
    console.log("Ouverture de la modal d'édition d'article...");

    // Récupérer les informations de l'article
    const articleId = 1; // Remplacez ceci par l'ID réel de l'article si nécessaire
    const articleTitle = decodeHtml(document.querySelector('.text h1').innerHTML);
    const articleContentHtml = document.querySelector('.text p').innerHTML;
    
    // Remplacer les balises <br> simples par des retours à la ligne (\n) et les doubles <br><br> par des doubles retours à la ligne (\n\n)
    const articleContent = decodeHtml(articleContentHtml.replace(/<br\s*\/?>\s*<br\s*\/?>/gm, "\n\n").replace(/<br\s*\/?>/gm, "\n"));

    existingImages = Array.from(document.querySelectorAll('.swiper-slide img')).map(img => ({
        name: img.alt, // Remplacez ceci par le nom de l'image si nécessaire
        url: img.src,
        extension: img.src.split('.').pop().toLowerCase()
    }));

    console.log("Titre de l'article:", articleTitle);
    console.log("Contenu de l'article:", articleContent);

    // Afficher les informations dans la fenêtre modale
    document.getElementById('edit-article-id').value = articleId;
    document.getElementById('edit-title').value = articleTitle;
    document.getElementById('edit-content').value = articleContent;

    const currentImagesContainer = document.getElementById('current-images');
    currentImagesContainer.innerHTML = '';

    existingImages.forEach((image, index) => {
        console.log(`Ajout de l'image existante: Nom: ${image.name}, URL: ${image.url}, Extension: ${image.extension}`);
        const imgElement = document.createElement('div');
        imgElement.classList.add('current-image');
        imgElement.innerHTML = `
            <img src="${image.url}" alt="${image.name}" data-index="${index}">
            <button type="button" class="delete-current-image-btn">
                <img src="/public/images/icones/supprimer.png" alt="Supprimer" class="delete-btn">
            </button>
        `;
        currentImagesContainer.appendChild(imgElement);
    });

    // Afficher la fenêtre modale
    const editArticleModal = document.getElementById('editArticleModal');
    editArticleModal.style.display = "flex";

    // Gérer la fermeture de la fenêtre modale
    const editCloseSpan = editArticleModal.querySelector('.close');
    editCloseSpan.onclick = function() {
        console.log("Fermeture de la modal d'édition d'article...");
        editArticleModal.style.display = "none";
    };

    window.onclick = function(event) {
        if (event.target == editArticleModal) {
            console.log("Fermeture de la modal d'édition d'article (clic en dehors)...");
            editArticleModal.style.display = "none";
        }
    };

    // Gérer la suppression des images existantes et nouvelles
    currentImagesContainer.addEventListener('click', function(event) {
        if (event.target.classList.contains('delete-current-image-btn') || event.target.parentElement.classList.contains('delete-current-image-btn')) {
            const imgDiv = event.target.closest('.current-image');
            const imgSrc = imgDiv.querySelector('img').src;
            const isNewImage = imgDiv.querySelector('img').dataset.new === 'true';

            if (isNewImage) {
                console.log(`Suppression de la nouvelle image: URL: ${imgSrc}`);
                // Supprimer l'image du tableau des nouvelles images
                newImages = newImages.filter(image => image.url !== imgSrc);
                console.log("Nouvelles images mises à jour:", newImages);
            } else {
                console.log(`Suppression de l'image existante: URL: ${imgSrc}`);
                // Supprimer l'image du tableau des images existantes
                existingImages = existingImages.filter(image => image.url !== imgSrc);
                console.log("Images existantes mises à jour:", existingImages);
            }

            imgDiv.remove();
            updateAddImageButtonState();
        }
    });

    // Gérer l'ajout de nouvelles images
    const addImageInput = document.getElementById('add-image-input');
    const addImageBtn = document.getElementById('add-image-btn');

    addImageBtn.onclick = function() {
        addImageInput.click();
    };

    addImageInput.onchange = function(event) {
        const files = Array.from(event.target.files);
        if (existingImages.length + newImages.length + files.length > 4) {
            displayErrorMessage('Vous ne pouvez ajouter que jusqu\'à 4 images.');
            return;
        }
        files.forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const uniqueName = `new_image_${index}_${Date.now()}.${file.name.split('.').pop().toLowerCase()}`;
                const newImage = {
                    name: uniqueName,
                    url: e.target.result,
                    extension: file.name.split('.').pop().toLowerCase()
                };
                newImages.push(newImage);
                console.log(`Ajout de la nouvelle image: Nom: ${newImage.name}, URL: ${newImage.url}, Extension: ${newImage.extension}`);
                console.log("Nouvelles images mises à jour:", newImages);

                // Ajouter l'image à l'affichage
                const imgElement = document.createElement('div');
                imgElement.classList.add('current-image');
                imgElement.innerHTML = `
                    <img src="${newImage.url}" alt="${newImage.name}" data-new="true">
                    <button type="button" class="delete-current-image-btn">
                        <img src="/public/images/icones/supprimer.png" alt="Supprimer" class="delete-btn">
                    </button>
                `;
                currentImagesContainer.appendChild(imgElement);
                updateAddImageButtonState();
            };
            reader.readAsDataURL(file);
        });
    };

    function updateAddImageButtonState() {
        const totalImages = existingImages.length + newImages.length;
        if (totalImages >= 4) {
            addImageBtn.style.display = "none";
            console.log("Le bouton d'ajout d'image est masqué car le nombre maximal d'images est atteint.");
        } else {
            addImageBtn.style.display = "inline-block";
            console.log("Le bouton d'ajout d'image est affiché.");
        }
    }

    updateAddImageButtonState();
});

// Gérer la soumission du formulaire
document.getElementById('editArticleForm').addEventListener('submit', function(event) {
    event.preventDefault();
    console.log("Soumission du formulaire d'édition d'article...");

    const title = document.getElementById('edit-title').value.trim();
    const contenttop = document.getElementById('edit-contenttop-top').value.trim();
    const contentbottom = document.getElementById('edit-contenttop-bottom').value.trim();

    if (!title || !contenttop || !contentbottom) {
        displayErrorMessage("Tous les champs sont obligatoires.");
        return;
    }

    // Convertir les retours à la ligne en <br> et les doubles retours à la ligne en <br><br>
    const contentHtml1 = contenttop.replace(/\n\n/g, "<br><br>").replace(/\n/g, "<br>");
    const contentHtml2 = contentbottom.replace(/\n\n/g, "<br><br>").replace(/\n/g, "<br>");

    const formData = new FormData();
    formData.append('article_id', document.getElementById('edit-article-id').value);
    formData.append('title', title);
    formData.append('contenttop', contentHtml1);
    formData.append('contentbottom', contentHtml2);

    console.log("Données envoyées :");
    console.log("ID de l'article :", document.getElementById('edit-article-id').value);
    console.log("Titre :", title);
    console.log("Contenu top :", contentHtml1);
    console.log("Contenu bottom :", contentHtml2);


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
            // Mise à jour des informations sur la page principale après la soumission réussie
            document.querySelector('.text h1').innerText = title;
            document.querySelector('.text p').innerHTML = contentHtml1;
            document.querySelector('.text p').innerHTML = contentHtml2;

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
