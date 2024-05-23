<?php
// Vérifier si l'utilisateur a accès au site
/*
if (!isset($_SESSION['site_access_granted']) || $_SESSION['site_access_granted'] !== true) {
    header('Location: /app/authentification');
    exit();
}*/

$password = "Motdepasse123*"; // Changez ceci pour le mot de passe que vous voulez utiliser
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
// echo $hashed_password;
$email = ".prank.pulse.2E2E_@free.fr.fr.fr";
// if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
//     echo "L'adresse email est valide.";
// } else {
//     echo "L'adresse email n'est pas valide.";
// }

error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "PHP is working!";

$email = "contact@assoforum-paysdegrasse.com";
$hash = md5(strtolower(trim($email)));
$gravatarUrl = "https://www.gravatar.com/avatar/$hash";
echo $gravatarUrl;

?>




<!-- TODO Régler le problème que quand un utilisateur s'inscrit, on ne puisse plus modifier les fichiers js et css, qu'il faille les renommer ou les recréer pour les modifier" -->
<!-- TODO Installation d'un serveur d'envoie de mail, Formulaire de contact, css, js et responsive" -->
<!-- TODO Faire en sorte que les caractères spéciaux (accents, etc..) soient bien affichés dans les articles de l'accueil -->


<!-- contact@assoforum-paysdegrasse.com    #Forum06130 -->