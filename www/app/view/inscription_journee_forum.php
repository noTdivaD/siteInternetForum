<?php
    // Titre de la page
    $pageTitle = "Inscription Journée Forum - Forum du Pays de Grasse";
    $currentPage = "Bulletin d'Inscriptions";

    // Chemin du fichier default.php
    $defaultFilePath = __DIR__ . '/default.php';

    // Vérifiez si default.php existe
    if (file_exists($defaultFilePath)) {
        // Vérifier si l'utilisateur a accès au site
        if (!isset($_SESSION['site_access_granted']) || $_SESSION['site_access_granted'] !== true) {
            header('Location: /app/authentification');
            exit();
        }
    }

    // Vérifier si l'utilisateur est connecté et récupérer ses informations
    $user = isset($_SESSION['user']) ? $_SESSION['user'] : [];
    $isAdmin = isset($_SESSION['user_logged_in']) && $_SESSION['user_type'] == 'administrateur';

    // Inclusion du header
    include 'parts/header.php';
?>

<div class="main-content">
    <div class="inscription-form-container">
        <h1>Bulletin d'Inscriptions</h1>
        <form action="/app/inscription_journee_forum/register" method="POST" id="formInscription">

            <div id="error_message" style="text-align: center; margin-bottom: 10px; color: red;"></div>

            <div class="form-group">
                <label for="firstname">Prénom :</label>
                <input type="text" id="firstname" name="firstname" value="<?php echo $user['prenom'] ?? ''; ?>" required>
                <div class="error-message" id="error-firstname"></div>
            </div>

            <div class="form-group">
                <label for="lastname">Nom :</label>
                <input type="text" id="lastname" name="lastname" value="<?php echo $user['nom'] ?? ''; ?>" required>
                <div class="error-message" id="error-lastname"></div>
            </div>

            <div class="form-group">
                <label for="email">Email :</label>
                <input type="email" id="email" name="email" value="<?php echo $user['email'] ?? ''; ?>" required>
                <div class="error-message" id="error-email"></div>
            </div>

            <div class="form-group">
                <label for="address">Adresse :</label>
                <input type="text" id="address" name="address" value="<?php echo $user['adresse'] ?? ''; ?>" required>
                <div class="error-message" id="error-address"></div>
            </div>

            <div class="form-group">
                <label for="city">Ville :</label>
                <input type="text" id="city" name="city" value="<?php echo $user['ville'] ?? ''; ?>" required>
                <div class="error-message" id="error-city"></div>
            </div>

            <div class="form-group">
                <label for="postal_code">Code Postal :</label>
                <input type="text" id="postal_code" name="postal_code" value="<?php echo $user['code_postal'] ?? ''; ?>" required>
                <div class="error-message" id="error-postal_code"></div>
            </div>

            <div class="form-buttons">
                <button type="submit" class="submit-button">Participer</button>
                <?php if ($isAdmin): ?>
                    <a href="/app/liste_journee_forum" class="admin-button">Voir liste des inscrits</a>
                <?php endif; ?>
            </div>
        </form>
    </div>
</div>   

<link rel="stylesheet" href="/public/css/inscription_journee_forum_style.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/inscription_journee_forum_style.css'); ?>">
<script src="/public/js/inscription_journee_forum.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/js/inscription_journee_forum.js'); ?>"></script>
<?php
    // Inclusion du footer
    include 'parts/footer.php';
?>
