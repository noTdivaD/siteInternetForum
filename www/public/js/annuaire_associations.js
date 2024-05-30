document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('search-form');
    const input = document.getElementById('search-input');
    const associations = document.querySelectorAll('.association-item');

    // Fonction pour filtrer les associations en fonction du terme de recherche
    function filterAssociations(searchTerm) {
        associations.forEach(function(association) {
            const nameElement = association.querySelector('h2');
            const addressElement = association.querySelector('.address');

            if (nameElement && addressElement) {
                const name = nameElement.innerText.toLowerCase();
                const address = addressElement.innerText.toLowerCase();

                if (name.includes(searchTerm) || address.includes(searchTerm)) {
                    association.style.display = 'flex'; // Afficher l'association
                } else {
                    association.style.display = 'none'; // Masquer l'association
                }
            }
        });
    }

    // Écouter l'événement input sur la barre de recherche
    input.addEventListener('input', function(event) {
        const searchTerm = event.target.value.toLowerCase().trim();
        filterAssociations(searchTerm); // Filtrer les associations avec le terme de recherche
    });

    // Filtrer les associations lors de l'initialisation de la page avec une chaîne vide
    filterAssociations('');
});