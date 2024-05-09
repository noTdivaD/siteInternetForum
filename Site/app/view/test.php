<?php
$password = "Motdepasse123*"; // Changez ceci pour le mot de passe que vous voulez utiliser
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
echo $hashed_password;
$email = ".prank.pulse.2E2E_@free.fr.fr.fr";
if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "L'adresse email est valide.";
} else {
    echo "L'adresse email n'est pas valide.";
}
?>


<!-- TODO Régler le problème que quand un utilisateur s'inscrit, on ne puisse plus modifier les fichiers js et css, qu'il faille les renommer ou les recréer pour les modifier" -->