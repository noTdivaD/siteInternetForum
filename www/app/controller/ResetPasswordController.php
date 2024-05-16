<?php
class ResetPasswordController {
    public function index() {
        // Charge la vue de réinitialisation de mot de passe
        require_once BASE_PATH . '/app/view/mdp_reinitialise.php';
    }

    public function reset() {
        require_once BASE_PATH . '/init.php'; 
        require_once BASE_PATH . '/app/model/UserModel.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $token = $_POST['token'];
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
            $confirm_password = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_SPECIAL_CHARS);

            // Vérifie que les deux mots de passe sont identiques et que l'email est valide
            if ($password !== $confirm_password || empty($password) || empty($confirm_password) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Données invalides";
                header("Location: /app/mdp_reinitialise?email=$email&token=$token&error=" . urlencode($error));
                exit();
            } else {
                // Connexion à la base de données
                $userModel = new UserModel();
                // Valide le token et met à jour le mot de passe
                if ($userModel->validateResetToken($email, $token)) {
                    // Vérifie si le nouveau mot de passe est identique à l'actuel
                    if (!$userModel->isCurrentPasswordByEmail($email, $password)) { // Condition inversée ici
                        if ($userModel->updateUserPassword($email, $password)) {
                            // Redirige ou informe l'utilisateur du succès
                            header("Location: /app/connexion");
                            exit();
                        } else {
                            $error = "Erreur lors de la mise à jour du mot de passe.";
                            header("Location: /app/mdp_reinitialise?email=$email&token=$token&error=" . urlencode($error));
                            exit();
                        }
                    } else {
                        $error = "Vous ne pouvez pas utiliser votre ancien mot de passe.";
                        header("Location: /app/mdp_reinitialise?email=$email&token=$token&error=" . urlencode($error));
                        exit();
                    }    
                } else {
                    $error = "Lien de réinitialisation non valide ou expiré.";
                    header("Location: /app/mdp_reinitialise?email=$email&token=$token&error=" . urlencode($error));
                    exit();
                }
            }
        }
    }
}
