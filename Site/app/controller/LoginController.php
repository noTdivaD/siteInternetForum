<?php
session_start(); // Commencez une nouvelle session ou reprenez une existante

// Supposons que vous avez une classe ou une fonction qui gère l'accès aux données utilisateur
require_once('../model/UserModel.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

    // Vérifiez que les champs ne sont pas vides
    if (!empty($email) && !empty($password) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $userModel = new UserModel();
        $isValid = $userModel->validateUser($email, $password);
        
        if ($isValid) {
            $_SESSION['user_email'] = $email; // Stockez l'email dans la session
            $userModel->updateLastLogin($email); // Mise à jour de la dernière connexion
            header("Location: ../view/accueil.html"); // Redirigez vers la page d'accueil
            exit();
        } else {
            // Les identifiants ne correspondent pas, redirigez vers la page de connexion avec un message d'erreur
            header("Location: ../view/connexion.html?error=" . urlencode("Identifiants invalides, veuillez réessayer."));
            exit();
        }
    } else {
        // Les champs sont vides, redirigez vers la page de connexion avec un message d'erreur
        header("Location: ../view/connexion.html?error=" . urlencode("Email invalide ou champs vides, veuillez réessayer."));
        exit();
    }
}
?>
