<?php
// Démarrer la session
session_start();

// Charger les configurations et les classes initiales
require_once '../app/init.php';

// Instancier l'application principale
$app = new App();
