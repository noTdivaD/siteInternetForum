<?php
// Définition du chemin absolu de la base du projet
define('BASE_PATH', realpath(dirname(__FILE__) . '/..'));

// Autoload des classes
spl_autoload_register(function($class) {
    // Cherche dans les dossiers core, controller, et model
    foreach (['core', 'controller', 'model'] as $directory) {
        if (file_exists(BASE_PATH . "/$directory/$class.php")) {
            require_once BASE_PATH . "/$directory/$class.php";
            return;
        }
    }
});

// Configuration de la base de données ou autres configurations initiales
require_once BASE_PATH . '/config/config.php';
