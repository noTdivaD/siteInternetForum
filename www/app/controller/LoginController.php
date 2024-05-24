<?php
class LoginController {
    public function index() {
        // Charge la vue de connexion
        require_once BASE_PATH . '/app/view/connexion.php';
    }

    public function login() {
        require_once BASE_PATH . '/init.php'; 
        require_once BASE_PATH . '/app/model/UserModel.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

            // Vérifiez que les champs ne sont pas vides
            if (!empty($email) && !empty($password) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $userModel = new UserModel();

                // Vérifie si l'utilisateur est vérifié
                if ($userModel->isUserVerified($email)) {
                    // Utilisateur vérifié, vérifiez les identifiants
                    $isValid = $userModel->validateUser($email, $password);

                    if ($isValid) {
                        $userType = $userModel->getUserType($email);
                        $_SESSION['user_logged_in'] = true; 
                        $_SESSION['user_email'] = $email;
                        $_SESSION['user_type'] = $userType;
                        $userModel->updateLastLogin($email); // Mise à jour de la dernière connexion
                        header("Location: /app/accueil_upgrade"); // Redirigez vers la page d'accueil
                        exit();
                    } else {
                        header("Location: /app/connexion?error=" . urlencode("Identifiants invalides, veuillez réessayer."));
                        exit();
                    }
                } else {
                    // Utilisateur non vérifié, rediriger avec un message d'erreur
                    header("Location: /app/connexion?error=" . urlencode("Votre compte n'a pas encore été vérifié. Veuillez vérifier votre adresse email avant de vous connecter."));
                    exit();
                }
            } else {
                header("Location: /app/connexion?error=" . urlencode("Email invalide ou champs vides, veuillez réessayer."));
                exit();
            }
        }
    }
}
