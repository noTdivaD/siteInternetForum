<?php
class ContactController {
    public function index() {
        // Charge la vue de contact
        require_once BASE_PATH . '/app/view/contacter.php';
    }

    public function send() {
        require_once BASE_PATH . '/init.php'; 
        require_once BASE_PATH . '/app/model/UserModel.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupération des données du formulaire
            $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $message = filter_input(INPUT_POST, 'message', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            if (!empty($firstname) && !empty($lastname) && !empty($email) && !empty($subject) && !empty($message) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                
                $userModel = new UserModel();
                $sendMail = $userModel->sendMailtoForum($firstname, $lastname, $email, $subject, $message);

                // Envoi du mail
                if ($sendMail) {
                    header("Location: /app/forum_email_envoye?email=" . urlencode($email));
                    exit();
                } else {
                    $error = "Une erreur s'est produite lors de l'envoi du message.";
                    header("Location: /app/contacter?error=" . urlencode($error));
                    exit();
                }
            } else {
                $error = "Champs du formulaire de contact invalides.";
                header("Location: /app/contacter?error=" . urlencode($error));
                exit();
            }
            
        } else {
            // Redirection si le formulaire n'est pas soumis
            header("Location: /app/contacter");
            exit();
        }
    }
}
