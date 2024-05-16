<?php
class RegisterController {
    public function index() {
        // Charge la vue d'inscription
        require_once BASE_PATH . '/app/view/inscription.php';
    }

    public function register() {
        require_once BASE_PATH . '/init.php'; 
        require_once BASE_PATH . '/app/model/UserModel.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $nom = filter_input(INPUT_POST, 'nom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $prenom = filter_input(INPUT_POST, 'prenom', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $date_naissance = filter_input(INPUT_POST, 'date_naissance', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $date_naissance = date('Y-m-d', strtotime($date_naissance)); // Reformate la date
            $adresse = filter_input(INPUT_POST, 'adresse', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $ville = filter_input(INPUT_POST, 'ville', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $code_postal = filter_input(INPUT_POST, 'code_postal', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $pays = filter_input(INPUT_POST, 'pays', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);
            $confirm_password = filter_input(INPUT_POST, 'confirm_password', FILTER_SANITIZE_SPECIAL_CHARS);

            $userModel = new UserModel(); // Création de l'utilisateur

            // Validation côté serveur
            if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Adresse email non valide.";
            } elseif ($password !== $confirm_password) {
                $error = "Les mots de passe ne correspondent pas.";
            } elseif (strlen($password) < 8 || !preg_match('/(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/', $password)) {
                $error = "Le mot de passe doit contenir au moins 8 caractères, incluant une majuscule, un chiffre et un caractère spécial.";
            } elseif ($userModel->emailExists($email)) {
                $error = "Email déjà utilisé par un autre compte.";
            } else {
                // Insertion dans la base de données
                if ($userModel->createUser($nom, $prenom, $email, $password, $date_naissance, $adresse, $ville, $code_postal, $pays)) {
                    $_SESSION['user_id'] = $userModel->getLastInsertId(); // ou une autre méthode pour récupérer l'ID utilisateur
                    header('Location: /app/connexion'); // Redirigez vers une page de succès ou de bienvenue
                    exit();
                } else {
                    $error = "Inscription Erreur. Utilisateur peut-être déjà existant ou problème avec la base de données.";
                }
            }

            if (isset($error)) {
                // Afficher le message d'erreur sur la page d'inscription
                header('Location: /app/inscription?error=' . urlencode($error));
                exit();
            }
        }
    }
}
