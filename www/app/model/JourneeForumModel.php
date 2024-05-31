<?php
require_once BASE_PATH . '/init.php';
require_once BASE_PATH . '/lib/phpmailer/src/Exception.php';
require_once BASE_PATH . '/lib/phpmailer/src/PHPMailer.php';
require_once BASE_PATH . '/lib/phpmailer/src/SMTP.php';

class JourneeForumModel {
    private $db;
    private $mailModel;

    public function __construct() {
        $this->db = Database::getInstance();
        $this->mailModel = SendMailModel::getInstance(); 
    }

    public function getArticleById($articleId) {
        $sql = "SELECT * FROM journee_forum WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $articleId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateArticle($articleId, $title, $content, $imageUrls) {
        $imagesJson = json_encode(array_values($imageUrls)); // Ensure it's a JSON array

        $sql = "UPDATE journee_forum SET titre = :title, contenu = :content, images = :images, date_modification = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $articleId, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':images', $imagesJson, PDO::PARAM_STR);
        return $stmt->execute();
    }

    // Fonction pour inscrire un utilisateur dans la table inscription_journee_forum
    public function registerUser($firstname, $lastname, $email, $address, $city, $postal_code) {
        $sql = "INSERT INTO inscription_journee_forum (firstname, lastname, email, address, city, postal_code, registration_date) 
                VALUES (:firstname, :lastname, :email, :address, :city, :postal_code, NOW())";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':firstname', $firstname, PDO::PARAM_STR);
        $stmt->bindParam(':lastname', $lastname, PDO::PARAM_STR);
        $stmt->bindParam(':email', $email, PDO::PARAM_STR);
        $stmt->bindParam(':address', $address, PDO::PARAM_STR);
        $stmt->bindParam(':city', $city, PDO::PARAM_STR);
        $stmt->bindParam(':postal_code', $postal_code, PDO::PARAM_STR);
        $result = $stmt->execute();

        if ($result) {
            $this->sendConfirmationEmail($firstname, $lastname, $email, $address, $city, $postal_code);
        }

        return $result;
    }

    // Fonction qui envoie un mail à contact@assoforum-paysdegrasse.com après une inscription réussie
    public function sendConfirmationEmail($firstname, $lastname, $email, $address, $city, $postal_code) {
        $subject = 'Nouvelle inscription à la Journée Forum';
        $message = "
            <html>
            <head>
                <title>Nouvelle inscription à la Journée Forum</title>
            </head>
            <body>
                <p>Une nouvelle inscription a été reçue pour la Journée Forum.</p>
                <p><strong>Prénom :</strong> $firstname</p>
                <p><strong>Nom :</strong> $lastname</p>
                <p><strong>Email :</strong> $email</p>
                <p><strong>Adresse :</strong> $address</p>
                <p><strong>Ville :</strong> $city</p>
                <p><strong>Code Postal :</strong> $postal_code</p>
            </body>
            </html>
        ";

        return $this->mailModel->sendMail('contact@assoforum-paysdegrasse.com', $subject, $message);
    }

    // Fonction pour récupérer la liste des inscrits à la journée forum
    public function getRegisteredUsers() {
        $sql = "SELECT * FROM inscription_journee_forum";
        $stmt = $this->db->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
