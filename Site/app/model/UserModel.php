<?php
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

    //Vérifier l'existence de l'email avant insertion
    public function emailExists($email) {
        $stmt = $this->db->prepare("SELECT COUNT(*) FROM utilisateurs WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetchColumn() > 0;
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
