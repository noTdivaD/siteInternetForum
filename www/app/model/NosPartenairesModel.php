<?php
require_once BASE_PATH . '/init.php';

class NosPartenairesModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getParagraph() {
        $stmt = $this->db->prepare("SELECT content_value FROM partenaires_content WHERE content_key = 'partenaires_paragraph'");
        $stmt->execute();
        return $stmt->fetchColumn();
    }

    public function getPartenaires() {
        $stmt = $this->db->prepare("SELECT * FROM partenaires");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getPartenaireById($id) {
        $stmt = $this->db->prepare("SELECT * FROM partenaires WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function addPartenaire($titre, $nom, $description, $imageUrl) {
        $stmt = $this->db->prepare("INSERT INTO partenaires (titre, nom, description, image_url) VALUES (:titre, :nom, :description, :image_url)");
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image_url', $imageUrl);
        $stmt->execute();
        return $this->db->lastInsertId();
    }

    public function updatePartenaire($id, $titre, $nom, $description, $imageUrl) {
        $stmt = $this->db->prepare("UPDATE partenaires SET titre = :titre, nom = :nom, description = :description, image_url = COALESCE(:image_url, image_url) WHERE id = :id");
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':nom', $nom);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':image_url', $imageUrl);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function removePartenaireImage($id) {
        $stmt = $this->db->prepare("UPDATE partenaires SET image_url = NULL WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function deletePartenaire($id) {
        $stmt = $this->db->prepare("DELETE FROM partenaires WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
    }

    public function updateParagraph($paragraph) {
        $stmt = $this->db->prepare("UPDATE partenaires_content SET content_value = :content WHERE content_key = 'partenaires_paragraph'");
        $stmt->bindParam(':content', $paragraph);
        return $stmt->execute();
    }
}
?>
