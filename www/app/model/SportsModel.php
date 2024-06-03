<?php

class SportsModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getAssociations() {
        $sql = "SELECT * FROM associations WHERE FIND_IN_SET('sports', domaine)";
        $result = $this->db->query($sql);
        return $result->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>
