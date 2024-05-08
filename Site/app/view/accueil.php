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
