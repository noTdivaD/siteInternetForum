<?php

class SportsModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAssociations() {
        $sql = "SELECT * FROM associations WHERE domaine = 'sports'";
        $result = $this->db->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
