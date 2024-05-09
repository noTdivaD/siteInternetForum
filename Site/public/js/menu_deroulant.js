function toggleMenu() {
    var overlay = document.getElementById('overlay');
    var dropdownMenu = document.getElementById('dropdown-menu');
    overlay.style.display = 'block';
    dropdownMenu.style.display = 'block';
}

function closeMenu() {
    var overlay = document.getElementById('overlay');
    var dropdownMenu = document.getElementById('dropdown-menu');
    overlay.style.display = 'none';
    dropdownMenu.style.display = 'none';
}
