<?php

class RencontreModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAllAssociations() {
        $sql = "SELECT * FROM associations";
        $result = $this->db->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getAssociations() {
        $sql = "SELECT * FROM associations WHERE rencontre_asso = 1";
        $result = $this->db->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getContent() {
        $sql = "SELECT * FROM rencontres_associatives";
        $result = $this->db->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateContent($id, $title, $text_top, $text_bottom) {
        $sql = "UPDATE rencontres_associatives SET title = ?, text_top = ?, text_bottom = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute([$title, $text_top, $text_bottom, $id])) {
            return true;
        } else {
            error_log("SQL Error: " . implode(":", $stmt->errorInfo()));
            return false;
        }
    }

    public function updateArticle($id, $text_bottom) {
        $sql = "UPDATE rencontres_associatives SET title = ?, text_top = ?, text_bottom = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute([$title, $text_top, $text_bottom, $id])) {
            return true;
        } else {
            error_log("SQL Error: " . implode(":", $stmt->errorInfo()));
            return false;
        }
    }
}
?>
