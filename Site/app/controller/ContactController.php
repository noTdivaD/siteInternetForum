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

    // Adresse e-mail du destinataire
    $to = "monarka.yanno@gmail.com";

    // Construction du corps du message
    $body = "Prénom: $firstname\n";
    $body .= "Nom: $lastname\n";
    $body .= "Email: $email\n\n";
    $body .= "Message:\n$message";

    // En-têtes du mail
    $headers = "From: $email";

    // Envoi du mail
    if (mail($to, $subject, $body, $headers)) {
        echo "Votre message a été envoyé avec succès.";
    } else {
        echo "Une erreur s'est produite lors de l'envoi du message.";
    }
} else {
    // Redirection si le formulaire n'est pas soumis
    header("Location: ../view/contacter.php");
    exit;
}
?>
