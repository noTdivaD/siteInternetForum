<?php
date_default_timezone_set('Europe/Paris'); // Configure le fuseau horaire dès le début

// Définition du chemin absolu de la base du projet
define('BASE_PATH', realpath(dirname(__FILE__)));

// Autoload des classes
spl_autoload_register(function($class) {
    // Adaptez les chemins selon la structure réelle de vos répertoires
    $paths = [
        BASE_PATH . "/app/core/$class.php", // pour le core
        BASE_PATH . "/app/controller/$class.php", // pour les controllers
        BASE_PATH . "/app/model/$class.php" // pour les models
    ];
    foreach ($paths as $path) {
        echo "Tentative de chargement : $path<br>";  // Ajoutez cette ligne pour le débogage
        if (file_exists($path)) {
            require_once $path;
            return;
        }
    }
});

// Configuration de la base de données ou autres configurations initiales
require_once BASE_PATH . '/config/config.php';

// Erreurs d'affichage pour le développement
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Démarrage de la session et configuration des cookies de session
if (session_status() == PHP_SESSION_NONE) {
    session_set_cookie_params([
        'lifetime' => 0, // Le cookie expire à la fermeture du navigateur
        'secure' => true, // Le cookie est envoyé seulement sur une connexion sécurisée
        'httponly' => true, // Le cookie n'est pas accessible via JavaScript
        'samesite' => 'Strict' // Le cookie n'est envoyé que pour des requêtes initiées depuis le même site
    ]);
    session_start();
}

// Définir une limite de temps d'inactivité (par exemple 30 minutes)
$timeout_duration = 1800;

// Vérifier si la session existe et vérifier la 'last_activity'
if (isset($_SESSION['last_activity']) && (time() - $_SESSION['last_activity']) > $timeout_duration) {
    session_unset();   // Effacer les variables de session
    session_destroy(); // Détruire la session
    header("Location: ../app/view/connexion.php"); // Rediriger l'utilisateur vers la page de connexion
    exit;
}

// Mettre à jour la 'last_activity' dans la session
$_SESSION['last_activity'] = time();

// Si nécessaire, regénérer l'ID de session lors de changements importants de l'état de connexion
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id(true);
    $_SESSION['initiated'] = true;
}
