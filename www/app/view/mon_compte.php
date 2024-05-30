<?php
    // Titre de la page
    $pageTitle = "Mon Compte - Forum du Pays de Grasse";
    $currentPage = "Mon Compte";

    // Vérifier si l'utilisateur a accès au site
    if (!isset($_SESSION['site_access_granted']) || $_SESSION['site_access_granted'] !== true) {
        header('Location: /app/authentification');
        exit();
    }

    // Vérifier si l'utilisateur est connecté
    if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
        header('Location: /app/connexion');
        exit();
    }

    // Inclusion du header
    include 'parts/header.php';

    // Récupérer les informations de l'utilisateur depuis la session
    $user = $_SESSION['user'];
?>

<div class="main-content">
    <div class="account-info-container">
        <form id="formAccount" action="/app/mon_compte/update_account" method="POST" enctype="multipart/form-data">
            <h1>Mon Compte</h1>
            <div id="error_message" style="color: red; text-align: center;"></div>
                <div class="account-info">
                    <div class="form-group">
                        <label for="firstname">Prénom :</label>
                        <input type="text" id="firstname" name="firstname" value="<?php echo $user['prenom']; ?>" readonly>
                        <div class="error-message" id="error-firstname"></div>
                    </div>

                    <div class="form-group">
                        <label for="lastname">Nom :</label>
                        <input type="text" id="lastname" name="lastname" value="<?php echo $user['nom']; ?>" readonly>
                        <div class="error-message" id="error-lastname"></div>
                    </div>

                    <div class="form-group">
                        <label for="address">Adresse :</label>
                        <input type="text" id="address" name="address" value="<?php echo $user['adresse']; ?>" readonly>
                        <div class="error-message" id="error-address"></div>
                    </div>

                    <div class="form-group">
                        <label for="city">Ville :</label>
                        <input type="text" id="city" name="city" value="<?php echo $user['ville']; ?>" readonly>
                        <div class="error-message" id="error-city"></div>
                    </div>

                    <div class="form-group">
                        <label for="postal_code">Code Postal :</label>
                        <input type="text" id="postal_code" name="postal_code" value="<?php echo $user['code_postal']; ?>" readonly>
                        <div class="error-message" id="error-postal_code"></div>
                    </div>

                    <div class="form-group">
                        <label for="country">Pays :</label>
                        <input type="text" id="country" name="country" value="<?php echo $user['pays']; ?>" readonly>
                        <div class="error-message" id="error-country"></div>
                    </div>

                    <div class="form-group">
                        <label for="email">Email :</label>
                        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" readonly>
                    </div>

                    <div class="form-group">
                        <label for="user_type">Type d'utilisateur :</label>
                        <input type="text" id="user_type" name="user_type" value="<?php echo $user['type']; ?>" readonly>
                    </div>
                </div>
                <div class="profile-photo-container">
                    <img src="<?php echo $user['photo_profil']; ?>" alt="Photo de Profil" class="profile-photo" id="profile-photo">
                    <div class="profile-photo-overlay">
                        <input type="file" id="profile-photo-input" name="profile_photo" accept="image/*" style="display: none;">
                        <img src="/public/images/icones/plus.png" alt="Ajouter" class="add-photo-icon" id="add-photo-icon">
                    </div>
                </div>
                <div class="form-group wide">
                    <button type="button" id="edit-button" class="edit-button">Modifier mes informations</button>
                    <button type="submit" id="save-button" class="save-button" style="display: none;">Enregistrer les modifications</button>
                </div>
        </form>       
    </div>
</div>

<link rel="stylesheet" href="/public/css/mon_compte_style.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/mon_compte_style.css'); ?>">
<script src="/public/js/mon_compte.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/js/mon_compte.js'); ?>"></script>
<?php
    // Inclusion du footer
    include 'parts/footer.php';
?>
