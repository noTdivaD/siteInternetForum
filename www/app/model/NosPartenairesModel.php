<?php
require_once BASE_PATH . '/init.php';

class NosPartenairesModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }
    
}
?>
