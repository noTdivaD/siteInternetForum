<?php

require_once '../../init.php'; 

class UserModel {
    private $db;

    // Constructeur pour initialiser la connexion à la base de données
    public function __construct() {
        // Modifier avec vos paramètres de connexion réels
        $this->db = new PDO('mysql:host=localhost;dbname=site_forum', 'marin', 'marin');
        // Configurez PDO pour lancer des exceptions en cas d'erreur
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    // Valider les identifiants de l'utilisateur
    public function validateUser($email, $password) {
        $stmt = $this->db->prepare("SELECT password FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $hashed_password = $stmt->fetchColumn();

        // Vérifier le mot de passe avec la version hashée stockée dans la base de données
        if ($hashed_password !== false && password_verify($password, $hashed_password)) {
            return true;
        }
        return false;
    }

    // Valider le token de réinitialisation de mot de passe
    public function validateResetToken($email, $token) {
        $stmt = $this->db->prepare("SELECT * FROM reset_tokens WHERE email = ? AND token = ? AND expiry > NOW()");
        $stmt->execute([$email, $token]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);

        // Vérifie si le token existe et n'a pas expiré
        return $result !== false;
    }

    // Vérifier l'existence de l'email avant insertion
    public function emailExists($email) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
    }

    // Méthode pour mettre à jour le mot de passe de l'utilisateur
    public function updateUserPassword($email, $password) {
        try {
            // Hachez le mot de passe avant de le stocker dans la base de données
            $password_hash = password_hash($password, PASSWORD_DEFAULT);

            // Prépare et exécute la requête SQL pour mettre à jour le mot de passe
            $stmt = $this->db->prepare("UPDATE utilisateurs SET password = ? WHERE email = ?");
            $stmt->execute([$password_hash, $email]);

            // Retourne true si la mise à jour a réussi
            return $stmt->rowCount() > 0;
        } catch (PDOException $e) {
            // Gérer l'erreur ici, par exemple en logguant l'erreur ou en renvoyant false
            return false;
        }
    }

    /*
    // Envoyer l'email de réinitialisation du mot de passe
    public function sendPasswordResetEmail($email) {
        $token = $this->generatePasswordResetToken($email);
        $resetLink = "http://yourdomain.com/reset_password.php?email=" . urlencode($email) . "&token=" . $token;

        $subject = "Réinitialisation de votre mot de passe";
        $message = "Veuillez cliquer sur le lien suivant pour réinitialiser votre mot de passe : " . $resetLink;
        $headers = 'From: noreply@yourdomain.com' . "\r\n" .
        'Reply-To: noreply@yourdomain.com' . "\r\n" .
        'X-Mailer: PHP/' . phpversion();

        mail($email, $subject, $message, $headers);
    } */

    //Temporairement
    public function sendPasswordResetEmail($email) {
        $token = $this->generatePasswordResetToken($email);
        $resetLink = "../view/mdp_reinitialise.php?email=" . urlencode($email) . "&token=" . $token;
    
        // Pour les besoins du test, renvoyez simplement le lien
        return $resetLink;
    }
    

    // Générer un token de réinitialisation de mot de passe
    public function generatePasswordResetToken($email) {
        $token = bin2hex(random_bytes(16)); // Génère un token sécurisé
        $expiry = new DateTime('+5 minutes'); // Définit l'expiration du token à 5 minutes

         // Prépare la requête pour insérer ou mettre à jour le token
        $stmt = $this->db->prepare(
            "INSERT INTO reset_tokens (email, token, expiry) VALUES (?, ?, ?) 
            ON DUPLICATE KEY UPDATE token = VALUES(token), expiry = VALUES(expiry)"
        );

        // Exécute la requête avec les valeurs fournies
        $stmt->execute([$email, $token, $expiry->format('Y-m-d H:i:s')]);

        return $token;
    }

    //Vérifie si le nouveau mot de passe est déja utilisé par l'utilisateur
    public function isCurrentPasswordByEmail($email, $proposedPassword) {
        // Récupérer le hash du mot de passe actuel de l'utilisateur par email
        $stmt = $this->db->prepare("SELECT password FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        $currentPasswordHash = $stmt->fetchColumn();
    
        // Vérifier si le mot de passe proposé correspond au mot de passe actuel
        return password_verify($proposedPassword, $currentPasswordHash);
    }
    


    // Créer un nouvel utilisateur
    public function createUser($nom, $prenom, $email, $password, $date_naissance, $adresse, $ville, $code_postal, $pays, $type = 'utilisateur', $photo_profil = 'adressephotodeprofil') {
        try {
            $password_hash = password_hash($password, PASSWORD_DEFAULT); // Hachage du mot de passe
            $stmt = $this->db->prepare("INSERT INTO utilisateurs (nom, prenom, email, password, date_naissance, adresse, ville, code_postal, pays, type, photo_profil) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
            return $stmt->execute([$nom, $prenom, $email, $password_hash, $date_naissance, $adresse, $ville, $code_postal, $pays, $type, $photo_profil]);

        } catch (PDOException $e) {
            if ($e->getCode() == 23000) {
                // Code spécifique pour violation de contrainte unique
                return false;
            }
            throw $e; // Relancez les autres exceptions
        }
    }    

    // Mise à jour de la dernière connexion
    public function updateLastLogin($email) {
        $stmt = $this->db->prepare("UPDATE utilisateurs SET date_derniere_connexion = NOW() WHERE email = ?");
        $stmt->execute([$email]);
    }

    // Récupérer les informations d'un utilisateur
    public function getUserInfo($email) {
        $stmt = $this->db->prepare("SELECT * FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    //Récupèrer l'id de l'utilisateur inscrit en dernier
    public function getLastInsertId() {
        return $this->db->lastInsertId();
    }
}
?>
