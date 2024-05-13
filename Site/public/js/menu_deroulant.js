function toggleMenu() {
    var overlay = document.getElementById('overlay');
    var dropdownMenu = document.getElementById('dropdown-menu');
    overlay.style.display = 'block';
    dropdownMenu.style.display = 'block';
    dropdownMenu.style.animation = 'slideInFromLeft 0.5s forwards';
}

function closeMenu() {
    var overlay = document.getElementById('overlay');
    var dropdownMenu = document.getElementById('dropdown-menu');
    dropdownMenu.style.animation = 'slideOutToLeft 0.2s forwards';
    setTimeout(function() {
        overlay.style.display = 'none';
        dropdownMenu.style.display = 'none';
    }, 200);
}
