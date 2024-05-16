<?php
class ForgotPasswordController {
    public function index() {
        // Charge la vue de mot de passe oublié
        require_once BASE_PATH . '/app/view/mdp_oublie.php';
    }

    public function reset() {
        require_once BASE_PATH . '/init.php'; 
        require_once BASE_PATH . '/app/model/UserModel.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);

            $userModel = new UserModel();
            if ($userModel->emailExists($email)) {
                $_SESSION['email'] = $email; // Stocker l'email dans la session
                
                // Envoyer l'email de réinitialisation
                $userModel->sendPasswordResetEmail($email);
                header("Location: /app/mdp_email_envoye?email=" . urlencode($email));
                exit();
            } else {
                // L'email n'existe pas
                $error = "L'email n'appartient à aucun compte utilisateur.";
                // Renvoyer à la page de formulaire avec un message d'erreur
                header("Location: /app/mdp_oublie?error=" . urlencode($error));
                exit();
            }
        } else {
            // Redirection si le formulaire n'est pas soumis
            header("Location: /app/mdp_oublie");
            exit();
        }
    }
}
