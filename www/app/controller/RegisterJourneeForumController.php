<?php
class RegisterJourneeForumController {

    public function index() {
        // Charge la vue de contact
        require_once BASE_PATH . '/app/view/inscription_journee_forum.php';
    }

    public function register() {
        require_once BASE_PATH . '/init.php'; 
        require_once BASE_PATH . '/app/model/JourneeForumModel.php';
    
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Récupération des données du formulaire
            $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
            $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $postal_code = filter_input(INPUT_POST, 'postal_code', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
            // Vérification des champs obligatoires
            if (!empty($firstname) && !empty($lastname) && !empty($email) && !empty($address) && !empty($city) && !empty($postal_code) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
                // Création de l'objet modèle
                $journeeForumModel = new JourneeForumModel();
                
                // Inscription de l'utilisateur
                $isRegistered = $journeeForumModel->registerUser($firstname, $lastname, $email, $address, $city, $postal_code);
                
                if ($isRegistered) {
                    // Envoi d'un email de confirmation
                    $mailSent = $journeeForumModel->sendConfirmationEmail($firstname, $lastname, $email, $address, $city, $postal_code);
                    if ($mailSent) {
                        header("Location: /app/inscription_journee_forum_success");
                        exit();
                    } else {
                        header("Location: /app/inscription_journee_forum?error=" . urlencode("Inscription réussie, mais l'email de confirmation n'a pas pu être envoyé."));
                        exit();
                    }
                } else {
                    header("Location: /app/inscription_journee_forum?error=" . urlencode("Erreur lors de l'inscription."));
                    exit();
                }
            } else {
                header("Location: /app/inscription_journee_forum?error=" . urlencode("Veuillez remplir tous les champs correctement."));
                exit();
            }
        } else {
            header("Location: /app/inscription_journee_forum?error=" . urlencode("Méthode de requête non valide."));
            exit();
        }
    }
}
?>
