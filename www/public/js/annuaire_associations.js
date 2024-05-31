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
});
