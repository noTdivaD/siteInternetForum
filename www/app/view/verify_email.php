<?php
require_once BASE_PATH . '/init.php';
require_once BASE_PATH . '/app/model/UserModel.php';

// Vérifier si le token est présent dans l'URL
if(isset($_GET['token'])) {
    $token = $_GET['token'];

    // Instancier le modèle utilisateur
    $userModel = new UserModel();

    // Vérifier si le token existe dans la base de données
    if($userModel->verifyEmailVerificationToken($token)) {
        // Token valide, le compte est vérifié avec succès
        // Rediriger vers la page "email_verified.php"
        header('Location: /app/email_verified');
        exit();
    } else {
        // Token invalide ou expiré, gérer l'erreur
        // Rediriger vers une page d'erreur ou afficher un message d'erreur
        header('Location: /app/email_verification_failed');
        exit();
    }
} else {
    // Token non trouvé dans l'URL, gérer l'erreur
    // Rediriger vers une page d'erreur ou afficher un message d'erreur
    header('Location: /app/email_verification_failed');
    exit();
}
?>
