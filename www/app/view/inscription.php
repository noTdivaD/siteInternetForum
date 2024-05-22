<?php
    // Titre de la page
    $pageTitle = "Inscription - Forum du Pays de Grasse";
    $currentPage = "Inscription";

    // Vérifier si l'utilisateur a accès au site
    if (!isset($_SESSION['site_access_granted']) || $_SESSION['site_access_granted'] !== true) {
        header('Location: /app/authentification');
        exit();
    }

    // Inclusion du header
    include 'parts/header.php';
?>

<div class="main-content">
    <!-- Formulaire d'inscription -->
    <div class="register-container">
        <h2>Inscription</h2>
        <form action="/app/inscription/register" method="POST" id="registrationForm">

            <div id="error_message" style="color: red;"></div>

            <div class="error-message" id="error-form"></div>

            <div class="scrollable-content">

                <div class="form-group-informations">
                    <label for="nom">Nom:</label>
                    <input type="text" id="nom" name="nom" required>
                    <div class="error-message" id="error-nom"></div> 
                </div>              
                    
                <div class="form-group-informations">
                    <label for="prenom">Prénom:</label>
                    <input type="text" id="prenom" name="prenom" required>
                    <div class="error-message" id="error-prenom"></div>
                </div>    

                <div class="form-group-informations">
                    <label for="date_naissance">Date de naissance:</label>
                    <input type="date" id="date_naissance" name="date_naissance" required>
                </div>

                <div class="form-group-informations">
                    <label for="adresse">Adresse:</label>
                    <input type="text" id="adresse" name="adresse" required>
                    <div class="error-message" id="error-adresse"></div>
                </div>    

                <div class="form-group-informations">
                    <label for="ville">Ville:</label>
                    <input type="text" id="ville" name="ville" required>
                    <div class="error-message" id="error-ville"></div>
                </div>          

                <div class="form-group-informations">
                    <label for="codePostal">Code Postal:</label>
                    <input type="text" id="codePostal" name="codePostal" required>
                    <div class="error-message" id="error-codePostal"></div>
                </div>      

                <div class="form-group-informations">
                    <label for="pays">Pays:</label>
                    <select id="pays" name="pays" required>
                        <option value="">Sélectionnez un pays</option>
                            <!-- Liste Générée dynamiquement via une API-->
                        </select>
                </div>    

                <div class="form-group-informations">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                    <div class="error-message" id="error-email"></div>
                </div>    
                    
                <div class="form-group-informations">
                    <label for="password">Mot de passe:</label>
                    <input type="password" id="password" name="password" required>
                    <div class="error-message" id="error-password"></div>
                </div>
                    

                <div class="form-group-informations">
                    <label for="confirm_password">Confirmez le mot de passe:</label>
                    <input type="password" id="confirm_password" name="confirm_password" required>
                    <div class="error-message" id="error-confirm_password"></div>
                </div>

                <p id="format_mdp">Attention, le mot de passe doit contenir au moins 8 caractères, incluant au moins une majuscule, un chiffre et un caractère spécial parmis ceux présentés ici : @ $ ! % * ? & #.</p>

            </div>    

            <div class="form-group-submit">
                <button type="submit" class="register-button">S'inscrire</button>
            </div>

            <div class="links">
                <a href="/app/connexion">Déja Membre ? Se connecter</a>
            </div>

        </form>    
    </div>
</div>        
<link rel="stylesheet" href="/public/css/inscription_style.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/inscription_style.css'); ?>">     
<script src="/public/js/inscription.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/js/inscription.js'); ?>"></script>

<?php
    // Inclusion du footer
    include 'parts/footer.php'
?>