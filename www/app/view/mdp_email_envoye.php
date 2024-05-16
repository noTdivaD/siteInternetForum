<?php
    // Titre de la page
    $pageTitle = "Email Envoyé - Forum du Pays de Grasse";
    $currentPage = "Email Envoyé";
    // Inclusion du header
    include 'parts/header.php';
?>

<?php
// Assure-toi que l'email est bien en session pour éviter les erreurs
$email = isset($_SESSION['email']) ? $_SESSION['email'] : 'non spécifiée';
?>

<div class="password-sent-email-container">
    <h2>Email envoyé avec succès !</h2>
    <div class="succes-container">
        <div class="succes-text-container">
            <img src="/public/images/succes.png" alt="Image Succès">
            <p>Un email contenant un lien afin de réinitialiser votre mot de passe a été envoyé à l'adresse mail : <strong><?php echo htmlspecialchars($email); ?></strong></p>
        </div>
        <div class="links">
            <a href="/app/connexion">Retourner à la page de Connexion</a>
        </div>
    </div>
</div>
<link rel="stylesheet" href="/public/css/style_mdp_email_envoye.css">
<script src="/public/js/mdp_email_envoye.js"></script>
<?php
    // Inclusion du footer
    include 'parts/footer.php';
?>