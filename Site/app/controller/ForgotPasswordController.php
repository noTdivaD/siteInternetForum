<?php
require_once '../../init.php'; 

// Supposons que vous avez une classe ou une fonction qui gère l'accès aux données utilisateur
require_once('../model/UserModel.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

    $userModel = new UserModel();
    if ($userModel->emailExists($email)) {
        $_SESSION['email'] = $email; // Stocker l'email dans la session
        // L'email existe, envoyer l'email de réinitialisation
        $resetLink = $userModel->sendPasswordResetEmail($email);
        echo "Suivez ce lien pour réinitialiser votre mot de passe : <a href='" . $resetLink . "'>" . $resetLink . "</a>";
        echo date('Y-m-d H:i:s'); // Heure du serveur PHP
        

        //Temporairement
        /*
        $successPage = "../view/mdp_email_envoye.php"; // Chemin vers la page de succès
        header("Location: $successPage?email=" . urlencode($email));
        */
        exit();
    } else {
        // L'email n'existe pas
        $error = "L'email n'appartient à aucun compte utilisateur.";
        // Renvoyer à la page de formulaire avec un message d'erreur
        header("Location: ../view/mdp_oublie.php?error=" . urlencode($error));
        exit();
    }


}
?>