<?php
    // Titre de la page
    $pageTitle = "Contact - Forum du Pays de Grasse";
    $currentPage = "Nous Contacter";

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

    // Inclusion du header
    include 'parts/header.php';
?>

<div class="main-content">
    <div class="contact-form-container">
        <h1>Contactez-nous</h1>
        <form action="/app/contacter/send" method="POST" id="formContact">

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
                <label for="subject">Objet :</label>
                <input type="text" id="subject" name="subject" required>
                <div class="error-message" id="error-subject"></div>
            </div>

            <div class="form-group">
                <label for="message">Message :</label>
                <textarea id="message" name="message" rows="6" required></textarea>
            </div>

            <button type="submit" class="submit-button">Envoyer</button>
            
        </form>
    </div>
</div>   

<link rel="stylesheet" href="/public/css/contacter_style.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/contacter_style.css'); ?>">
<script src="/public/js/contacter.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/js/contacter.js'); ?>"></script>
<?php
    // Inclusion du footer
    include 'parts/footer.php';
?>
