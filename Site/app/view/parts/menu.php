<!-- Menu déroulant -->
<?php require_once '../../init.php'; ?>
<div id="overlay" onclick="closeMenu()"></div>
        <div id="dropdown-menu">    
            <div class="croix" onclick="closeMenu()">&#10006;</div>
            <ul>
                <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']): ?>
                    <li><a href="deconnexion.php">Se déconnecter</a></li>
                <?php else: ?>
                    <li><a href="connexion.php">Se connecter / S'inscrire</a></li>
                <?php endif; ?>
                <li><a href="accueil.php">Accueil</a></li>

                <!--TODO: À remplir avec les liens pour les autres pages lorsque celles-ci seront disponibles -->
                <li><a href="#">Journée Forum</a></li>
                <li><a href="annuaire.php">Annuaire des Associations</a></li>
                <li><a href="#">Rencontres Associatives</a></li>
                <li><a href="#">Collège d'Experts</a></li>
                <li><a href="#">Agenda Des Associations</a></li>
                <li><a href="#">Flash Info et Informations Utiles</a></li>
            </ul>
        </div>
</div>          
