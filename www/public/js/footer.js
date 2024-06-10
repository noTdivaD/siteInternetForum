// Vérifier l'état du mode sombre lors du chargement de la page
document.addEventListener('DOMContentLoaded', function() {
    if (localStorage.getItem('darkMode') === 'enabled') {
        document.body.classList.add('dark-mode');
        document.getElementById('darkModeToggle').textContent = 'Mode Clair';
    }
});


document.getElementById('printView').addEventListener('click', function(event) {
    event.preventDefault();
    window.print();
});

document.getElementById('darkModeToggle').addEventListener('click', function(event) {
    event.preventDefault();
    document.body.classList.toggle('dark-mode');

    if (document.body.classList.contains('dark-mode')) {
        localStorage.setItem('darkMode', 'enabled');
        event.target.textContent = 'Mode Clair';
    } else {
        localStorage.setItem('darkMode', 'disabled');
        event.target.textContent = 'Mode Sombre';
    }
});

