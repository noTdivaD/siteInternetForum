document.addEventListener('DOMContentLoaded', function() {
    const form = document.getElementById('search-form');
    const input = document.getElementById('search-input');
    const associations = document.querySelectorAll('.association-item');

    form.addEventListener('submit', function(event) {
        event.preventDefault();
        const searchTerm = input.value.toLowerCase().trim();

        associations.forEach(function(association) {
            const nameElement = association.querySelector('h2');
            const addressElement = association.querySelector('.address');

            if (nameElement && addressElement) {
                const name = nameElement.innerText.toLowerCase();
                const address = addressElement.innerText.toLowerCase();

                if (name.includes(searchTerm) || address.includes(searchTerm)) {
                    association.style.display = 'flex'; // Afficher l'élément
                } else {
                    association.style.display = 'none'; // Masquer l'élément
                }
            }
        });
    });
});
