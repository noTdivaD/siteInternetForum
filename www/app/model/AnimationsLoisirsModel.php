<?php

class AnimationsLoisirsModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAssociations() {
        $sql = "SELECT * FROM associations WHERE domaine = 'animations et loisirs'";
        $result = $this->db->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
