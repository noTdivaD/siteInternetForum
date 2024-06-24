document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('search-form');
    const input = document.getElementById('search-input');
    const associations = document.querySelectorAll('.association-item');
    const noResultsMessage = document.createElement('div');
    noResultsMessage.id = 'no-results-message';
    noResultsMessage.innerText = 'Aucune association trouvée';
    noResultsMessage.style.display = 'none'; // Masqué par défaut
    document.querySelector('.association-container').appendChild(noResultsMessage);

    function filterAssociations(searchTerm) {
        let anyVisible = false;
        associations.forEach(function(association) {
            const nameElement = association.querySelector('h2');
            const addressElement = association.querySelector('.address');

            if (nameElement && addressElement) {
                const name = nameElement.innerText.toLowerCase();
                const address = addressElement.innerText.toLowerCase();

                if (name.includes(searchTerm) || address.includes(searchTerm)) {
                    association.style.display = 'flex'; // Afficher l'association
                    anyVisible = true;
                } else {
                    association.style.display = 'none'; // Masquer l'association
                }
            }
        });
        // Afficher le message si aucune association n'est visible
        noResultsMessage.style.display = anyVisible ? 'none' : 'block';
    }

    input.addEventListener('input', function(event) {
        const searchTerm = event.target.value.toLowerCase().trim();
        filterAssociations(searchTerm);
    });

    filterAssociations('');

    // Gestion du modal d'ajout
    var addModal = document.getElementById("addAssociationModal");
    var addBtn = document.getElementById("add-association-btn");
    var addClose = addModal ? addModal.getElementsByClassName("close")[0] : null;

    if (addBtn && addModal && addClose) {
        addBtn.onclick = function() {
            addModal.style.display = "flex"; // Utiliser "flex" au lieu de "block"
        }

        addClose.onclick = function() {
            addModal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == addModal) {
                addModal.style.display = "none";
            }
        }
    } else {
        console.error('Add modal elements are missing');
    }

    // Gestion du modal d'édition
    var editModal = document.getElementById("editAssociationModal");
    var editClose = editModal ? editModal.getElementsByClassName("close")[0] : null;

    if (editModal && editClose) {
        document.querySelectorAll('.edit-button').forEach(button => {
            button.onclick = function() {
                var id = this.getAttribute('data-id');
                // Récupérer les données de l'association et les remplir dans le formulaire
                // Vous devrez implémenter cela pour charger les données de l'association dans le formulaire
                editModal.style.display = "flex"; // Utiliser "flex" au lieu de "block"
            }
        });

        editClose.onclick = function() {
            editModal.style.display = "none";
        }

        window.onclick = function(event) {
            if (event.target == editModal) {
                editModal.style.display = "none";
            }
        }
    } else {
        console.error('Edit modal elements are missing');
    }

    // Gestion de la soumission des formulaires
    var addAssociationForm = document.getElementById('addAssociationForm');
    var editAssociationForm = document.getElementById('editAssociationForm');

    if (addAssociationForm) {
        addAssociationForm.onsubmit = function(event) {
            event.preventDefault();
            // Implémentez la logique pour ajouter une association ici
        }
    } else {
        console.error('Add association form is missing');
    }

    if (editAssociationForm) {
        editAssociationForm.onsubmit = function(event) {
            event.preventDefault();
            // Implémentez la logique pour éditer une association ici
        }
    } else {
        console.error('Edit association form is missing');
    }
});
