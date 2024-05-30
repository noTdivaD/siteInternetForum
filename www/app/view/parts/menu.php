<!-- Menu déroulant -->
<?php require_once BASE_PATH . '/init.php'; ?>
<div id="overlay" onclick="closeMenu()"></div>
        <div id="dropdown-menu">    
            <div class="croix" onclick="closeMenu()">&#10006;</div>
            <ul>
                <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']): ?>
                    <li><a href="/app/deconnexion">Se déconnecter</a></li>
                <?php else: ?>
                    <li><a href="/app/connexion">Se connecter / S'inscrire</a></li>
                <?php endif; ?>
                <li><a href="/app/accueil_upgrade">Accueil</a></li>

                <!--TODO: À remplir avec les liens pour les autres pages lorsque celles-ci seront disponibles -->
                <li><a href="/app/journee_forum">Journée Forum</a></li>
                <li><a href="/app/annuaire_associations">Annuaire des Associations</a></li>
                <li><a href="#">Rencontres Associatives</a></li>
                <li><a href="#">Collège d'Experts</a></li>
                <li><a href="#">Agenda Des Associations</a></li>
                <li><a href="#">Flash Info et Informations Utiles</a></li>
                <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']): ?>
                    <li><a href="/app/mon_compte">Mon Compte</a></li>
                <?php endif; ?>
            </ul>
        </div>
</div>          
