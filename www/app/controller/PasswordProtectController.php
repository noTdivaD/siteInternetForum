<?php

class PasswordProtectController {
    public function index() {
        // Charge la vue de connexion
        require_once BASE_PATH . '/app/view/password_protect.php';
    }

    public function authentification() {
        require_once BASE_PATH . '/init.php'; 

        // Définir le mot de passe correct
        $correct_password = '2217';

        // Vérifier si le mot de passe a été soumis
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_SPECIAL_CHARS);

            if (isset($_POST['password']) && $_POST['password'] === $correct_password) {
                $_SESSION['site_access_granted'] = true;
                header('Location: /app/accueil_upgrade');
                exit();
            } else {
                header("Location: /app/authentification?error=" . urlencode("Mot de passe incorrect."));
                exit();
            }
        }

        // Si l'utilisateur est déjà authentifié pour l'accès au site, rediriger vers la page principale
        if (isset($_SESSION['site_access_granted']) && $_SESSION['site_access_granted'] === true) {
            header('Location: /app/accueil_upgrade');
            exit();
        }
    }
}
