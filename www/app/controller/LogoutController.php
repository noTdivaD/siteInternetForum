<?php
class LogoutController {
    public function index() {
        // Déconnecter l'utilisateur
        session_start();
        session_unset();
        session_destroy();
        header("Location: /app/connexion");
        exit();
    }
}
