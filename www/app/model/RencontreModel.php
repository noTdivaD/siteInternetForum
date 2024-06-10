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

    public function updateAssociation($association_id) {
        try {
            $this->db->beginTransaction();

            $sql = "UPDATE associations SET rencontre_asso = 0 WHERE rencontre_asso = 1";
            $this->db->exec($sql);

            $sql = "UPDATE associations SET rencontre_asso = 1 WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$association_id]);

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("SQL Error: " . $e->getMessage());
            return false;
        }
    }
}
?>
