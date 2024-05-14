<?php
require_once '../../init.php'; 

// Supposons que vous avez une classe ou une fonction qui gère l'accès aux données utilisateur
require_once('../model/UserModel.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Récupération des données du formulaire
    $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);;
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_FULL_SPECIAL_CHARS);;
    $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS);;


    if(!empty($firstname) && !empty($lastname) && !empty($email) && !empty($subject) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)){
        
        $userModel = new UserModel();
        $sendMail = $userModel -> sendMailtoForum($firstname,$lastname,$email,$subject,$message);

        // Envoi du mail
        if ($sendMail) {
            $successPage = "../view/forum_email_envoye.php"; // Chemin vers la page de succès
            header("Location: $successPage?email=" . urlencode($email));
            exit();
        } else {
            $error = "Une erreur s'est produite lors de l'envoi du message.";
            header("Location: ../view/contacter.php?error="  . urlencode($error));
            exit();
        }
    } else {
        $error = "Champs du formulaire de contact invalides.";
        header("Location: ../view/contacter.php?error="  . urlencode($error));
        exit();
    }
    
} else {
    // Redirection si le formulaire n'est pas soumis
    header("Location: ../view/contacter.php");
    exit;
}
?>
