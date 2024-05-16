<?php

class Database {
    private static $instance = null;
    private $db;

    private function __construct() {
        $this->db = new PDO('mysql:host=localhost;dbname=site_forum', 'marin', 'marin');
        $this->db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public static function getInstance() {
        if (self::$instance == null) {
            self::$instance = new Database();
        }
        return self::$instance->db;
    }

    private function __clone() {}
}

// Usage
$db = Database::getInstance();

?>