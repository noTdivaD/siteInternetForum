<?php
class AssociationsModel {
    private $db;

    // Constructeur pour initialiser la base de données
    public function __construct() {
        $this->db = Database::getInstance();
    }

    // Méthode pour récupérer toutes les associations
    public function getAllAssociations() {
        $query = "SELECT * FROM associations";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: []; // Retourner un tableau vide si aucun résultat
    }

    // Méthode pour récupérer les associations par thème
    public function getAssociationsByTheme($theme) {
        $query = "SELECT * FROM associations WHERE FIND_IN_SET(:theme, association_themes)";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':theme', $theme, PDO::PARAM_STR);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: []; // Retourner un tableau vide si aucun résultat
    }

    // Méthode pour récupérer les associations visibles
    public function getVisibleAssociations() {
        $query = "SELECT * FROM associations WHERE visibilite = 'visible'";
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC) ?: []; // Retourner un tableau vide si aucun résultat
    }
}
?>
