<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $pageTitle; ?></title>
    <link rel="stylesheet" href="public/css/header_style.css">
    <!-- Autres balises meta, lien vers les polices, etc. -->
</head>
<body>
        <!-- Bannière -->
        <header class="banner">
            <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
            <div class="banner-text">
                <p class="current-page">Connexion</p>
                <p class="titre">Forum Association de Grasse</p></div>
            <div class="logo">
                <img src="../../public/images/logo/Logo Association Forum.jpg" alt="Logo Association Forum">
            </div>
        </header>

        <!-- Menu déroulant -->
        <div id="overlay" onclick="closeMenu()"></div>
        <div id="dropdown-menu">    
            <ul>
                <li class="croix" onclick="closeMenu()">&#10006;</li>
                <li><a href="connexion.html">Se connecter/Inscription</a></li>
                <li><a href="accueil.html">Accueil</a></li>

                <!--TODO: À remplir avec les liens pour les autres pages lorsque celles-ci seront disponibles -->
                <li><a href="#">Journée Forum</a></li>
                <li><a href="#">Annuaire des Associations</a></li>
                <li><a href="#">Rencontres Associatives</a></li>
                <li><a href="#">Collège d'Experts</a></li>
                <li><a href="#">Agenda Des Associations</a></li>
                <li><a href="#">Flash Info et Informations Utiles</a></li>
            </ul>
        </div>
    </header>