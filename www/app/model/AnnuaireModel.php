<?php
require_once BASE_PATH . '/init.php';

class AnnuaireModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getThemes() {
        $query = $this->db->prepare("SELECT * FROM associations_themes");
        $query->execute();
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    /*
    public function addTheme($themeData) {
        $query = $this->db->prepare("INSERT INTO associations_themes (title, slug, image_url, color_r, color_g, color_b) VALUES (:title, :slug, :image_url, :color_r, :color_g, :color_b)");
        return $query->execute([
            'title' => $themeData['title'],
            'slug' => $themeData['slug'],
            'image_url' => $themeData['image_url'],
            'color_r' => $themeData['color_r'],
            'color_g' => $themeData['color_g'],
            'color_b' => $themeData['color_b']
        ]);
    }
    */
}
?>
