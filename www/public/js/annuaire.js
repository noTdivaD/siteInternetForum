function redirectToLink(url) {
    window.location.href = url;
}

/*

function initializeDropZones() {
    console.log("Initialisation des zones de dépôt...");
    document.querySelectorAll(".drop-zone__input").forEach((inputElement) => {
        const dropZoneElement = inputElement.closest(".drop-zone");

        const openFileSelector = function handler(e) {
            console.log("Zone de dépôt cliquée, ouverture du sélecteur de fichiers...");
            inputElement.click();
            dropZoneElement.removeEventListener("click", handler);
        };

        const updateThumbnailHandler = function(e) {
            if (inputElement.files.length) {
                console.log("Fichier sélectionné :", inputElement.files[0]);
                updateThumbnail(dropZoneElement, inputElement.files[0]);
                document.getElementById("themeColor").disabled = false;
                document.getElementById("pipetteButton").disabled = false;
                loadImageToCanvas(inputElement.files[0]);
            }
        };

        const dragOverHandler = (e) => {
            e.preventDefault();
            dropZoneElement.classList.add("drop-zone--over");
        };

        const dropHandler = function(e) {
            e.preventDefault();
            if (e.dataTransfer.files.length) {
                inputElement.files = e.dataTransfer.files;
                updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
                document.getElementById("themeColor").disabled = false;
                document.getElementById("pipetteButton").disabled = false;
                loadImageToCanvas(e.dataTransfer.files[0]);
            }
            dropZoneElement.classList.remove("drop-zone--over");
        };

        dropZoneElement.removeEventListener("click", openFileSelector);
        inputElement.removeEventListener("change", updateThumbnailHandler);
        dropZoneElement.removeEventListener("dragover", dragOverHandler);
        dropZoneElement.removeEventListener("drop", dropHandler);

        dropZoneElement.addEventListener("click", openFileSelector, { once: true });
        inputElement.addEventListener("change", updateThumbnailHandler);
        dropZoneElement.addEventListener("dragover", dragOverHandler);
        dropZoneElement.addEventListener("drop", dropHandler);

        ["dragleave", "dragend"].forEach((type) => {
            dropZoneElement.addEventListener(type, (e) => {
                dropZoneElement.classList.remove("drop-zone--over");
            });
        });
    });
}

function updateThumbnail(dropZoneElement, file) {
    console.log("Mise à jour de la vignette...");
    let thumbnailElement = dropZoneElement.querySelector(".drop-zone__thumb");

    if (dropZoneElement.querySelector(".drop-zone__prompt")) {
        dropZoneElement.querySelector(".drop-zone__prompt").remove();
    }

    if (!thumbnailElement) {
        thumbnailElement = document.createElement("div");
        thumbnailElement.classList.add("drop-zone__thumb");
        dropZoneElement.appendChild(thumbnailElement);
    }

    thumbnailElement.textContent = file.name;

    if (!file) {
        thumbnailElement.remove();
        dropZoneElement.innerHTML = '<span class="drop-zone__prompt">Sélectionnez ou Déposez votre Fichier Ici</span>';
    }
}

function loadImageToCanvas(file) {
    const canvas = document.getElementById('imageCanvas');
    const ctx = canvas.getContext('2d');
    const img = new Image();

    const reader = new FileReader();
    reader.onload = function(e) {
        img.src = e.target.result;
    };

    img.onload = function() {
        const maxWidth = 600;
        const maxHeight = 400;
        let width = img.width;
        let height = img.height;

        if (width > maxWidth) {
            height = Math.round((height *= maxWidth / width));
            width = maxWidth;
        }
        if (height > maxHeight) {
            width = Math.round((width *= maxHeight / height));
            height = maxHeight;
        }

        canvas.width = width;
        canvas.height = height;
        ctx.drawImage(img, 0, 0, width, height);
    };

    reader.readAsDataURL(file);
}

function activatePipette() {
    const canvas = document.getElementById('imageCanvas');
    const ctx = canvas.getContext('2d');

    if (canvas.style.display === 'none') {
        canvas.style.display = 'block';
    } else {
        canvas.style.display = 'none';
        return;
    }

    canvas.addEventListener('click', function handler(e) {
        const rect = canvas.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        const pixel = ctx.getImageData(x, y, 1, 1).data;
        const hexColor = rgbToHex(pixel[0], pixel[1], pixel[2]);

        if (hexColor) {
            document.getElementById('themeColor').value = hexColor;
            document.getElementById('themeColor').style.backgroundColor = hexColor;
        } else {
            console.log("Couleur hexadécimale invalide :", hexColor);
        }

        canvas.style.display = 'none';
        canvas.removeEventListener('click', handler);
    });
}

function rgbToHex(r, g, b) {
    return "#" + ((1 << 24) + (r << 16) + (g << 8) + b).toString(16).slice(1).toUpperCase();
}

function hexToRgb(hex) {
    var bigint = parseInt(hex.slice(1), 16);
    var r = (bigint >> 16) & 255;
    var g = (bigint >> 8) & 255;
    var b = (bigint & 255);
    return [r, g, b];
}

function rgbToString(r, g, b) {
    return `rgb(${r}, ${g}, ${b})`;
}

function decodeHtml(html) {
    var txt = document.createElement("textarea");
    txt.innerHTML = html;
    return txt.value;
}

function addHoverStyle(slug, colorR, colorG, colorB) {
    const style = document.createElement('style');
    style.innerHTML = `
        .${slug}:hover::after {
            background-color: rgba(${colorR}, ${colorG}, ${colorB}, 0.2);
        }
    `;
    document.head.appendChild(style);
}

document.addEventListener("DOMContentLoaded", function() {
    initializeDropZones();

    const addThemeModal = document.getElementById('addThemeModal');
    const closeBtn = document.querySelector('.modal .close');

    window.openAddThemeModal = function() {
        addThemeModal.style.display = 'flex';
    };

    window.closeAddThemeModal = function() {
        addThemeModal.style.display = 'none';
    };

    window.onclick = function(event) {
        if (event.target === addThemeModal) {
            addThemeModal.style.display = 'none';
        }
    };

    document.getElementById('pipetteButton').addEventListener('click', activatePipette);

    document.getElementById("addThemeForm").addEventListener("submit", function(event) {
        event.preventDefault();

        const themeTitle = document.getElementById("themeTitle").value.trim();
        const themeColor = document.getElementById("themeColor").value.trim();
        const themeImage = document.getElementById("themeImage").files[0];

        if (!themeTitle || !themeColor || !themeImage) {
            document.getElementById('error_message').textContent = 'Les champs titre, couleur et image sont obligatoires.';
            return;
        }

        const hexMatch = themeColor.match(/^#([0-9A-F]{6})$/i);
        if (!hexMatch) {
            document.getElementById('error_message').textContent = 'La couleur doit être au format #RRGGBB.';
            return;
        }

        const [r, g, b] = hexToRgb(themeColor);

        const formData = new FormData(this);
        formData.append('color_r', r);
        formData.append('color_g', g);
        formData.append('color_b', b);

        console.log("Formulaire avant envoi : ");
        for (var pair of formData.entries()) {
            console.log(pair[0] + ': ' + pair[1]);
        }

        console.log('Envoi du formulaire d\'ajout de thème...');

        fetch('/app/annuaire_associations/addTheme', {
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
            console.log("Formulaire après envoi : ", formData);
            console.log(document.getElementById("addThemeForm"));

            if (data.success) {
                console.log('Thème ajouté avec succès', data.theme);
                var newThemeHtml = `
                    <div class="thematique ${data.theme.slug}" style="background-image: url('${data.theme.image_url}'); background-color: rgb(${data.theme.color_r}, ${data.theme.color_g}, ${data.theme.color_b});" onclick="redirectToLink('/app/associations_${data.theme.slug}')">
                        <h2>${decodeHtml(data.theme.title)}</h2>
                    </div>`;
                var annuaireContainer = document.querySelector('.annuaire-container');
                var addButton = annuaireContainer.querySelector('.add-theme-button-container');
                addButton.insertAdjacentHTML('beforebegin', newThemeHtml);

                // Add hover style dynamically
                addHoverStyle(data.theme.slug, data.theme.color_r, data.theme.color_g, data.theme.color_b);

                // Convertir la couleur en hexadécimal avant de réinitialiser le formulaire
                const hexColor = rgbToHex(data.theme.color_r, data.theme.color_g, data.theme.color_b);
                document.getElementById("themeColor").value = hexColor;
                document.getElementById("themeColor").style.backgroundColor = hexColor;

                document.getElementById("addThemeForm").reset();

                resetDropZone(document.getElementById("drop-zone-theme"));
                addThemeModal.style.display = "none";
            } else {
                console.log('Erreur lors de l\'ajout du thème :', data.error);
                document.getElementById('error_message').textContent = data.error || 'Erreur inconnue.';
            }
        })
        .catch(error => {
            console.error('Erreur lors du parsing JSON ou de la requête AJAX :', error);
            document.getElementById('error_message').textContent = 'Erreur lors de l\'ajout du thème.';
        });
    });

    const themeColorInput = document.getElementById("themeColor");
    themeColorInput.addEventListener("input", function() {
        console.log("Changement de couleur détecté :", themeColorInput.value);
        const hexColor = themeColorInput.value;
        const [r, g, b] = hexToRgb(hexColor);
        const rgbColor = rgbToString(r, g, b);
        themeColorInput.style.backgroundColor = rgbColor;
        console.log("Couleur RGB :", rgbColor);
    });
});

function resetDropZone(dropZoneElement, activate = true) {
    console.log("Réinitialisation de la zone de dépôt...");
    dropZoneElement.innerHTML = '<span class="drop-zone__prompt">Sélectionnez ou Déposez votre Fichier Ici</span>';
    const inputElement = document.createElement("input");
    inputElement.classList.add("drop-zone__input");
    inputElement.type = "file";
    inputElement.name = "themeImage";
    dropZoneElement.appendChild(inputElement);
    console.log("Élément d'entrée de la zone de dépôt réinitialisé");

    if (activate) {
        initializeDropZoneEvents(dropZoneElement, inputElement);
    }
}

function initializeDropZoneEvents(dropZoneElement, inputElement) {
    console.log("Réinitialisation des événements de la zone de dépôt...");

    const openFileSelector = function handler(e) {
        console.log("Zone de dépôt cliquée, ouverture du sélecteur de fichiers...");
        inputElement.click();
        dropZoneElement.removeEventListener("click", handler);
    };

    const updateThumbnailHandler = function(e) {
        if (inputElement.files.length) {
            console.log("Fichier sélectionné :", inputElement.files[0]);
            updateThumbnail(dropZoneElement, inputElement.files[0]);
            document.getElementById("themeColor").disabled = false;
        }
    };

    const dragOverHandler = (e) => {
        e.preventDefault();
        dropZoneElement.classList.add("drop-zone--over");
    };

    const dropHandler = function(e) {
        e.preventDefault();
        if (e.dataTransfer.files.length) {
            inputElement.files = e.dataTransfer.files;
            updateThumbnail(dropZoneElement, e.dataTransfer.files[0]);
            document.getElementById("themeColor").disabled = false;
        }
        dropZoneElement.classList.remove("drop-zone--over");
    };

    dropZoneElement.addEventListener("click", openFileSelector, { once: true });
    inputElement.addEventListener("change", updateThumbnailHandler);
    dropZoneElement.addEventListener("dragover", dragOverHandler);
    dropZoneElement.addEventListener("drop", dropHandler);

    ["dragleave", "dragend"].forEach((type) => {
        dropZoneElement.addEventListener(type, (e) => {
            dropZoneElement.classList.remove("drop-zone--over");
        });
    });
}

*/