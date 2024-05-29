<?php
require_once BASE_PATH . '/init.php';

class JourneeForumModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getArticleById($articleId) {
        $sql = "SELECT * FROM journee_forum WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $articleId, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateArticle($articleId, $title, $content, $imageUrls) {
        $imagesJson = json_encode(array_values($imageUrls)); // Ensure it's a JSON array

        $sql = "UPDATE journee_forum SET titre = :title, contenu = :content, images = :images, date_modification = NOW() WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindParam(':id', $articleId, PDO::PARAM_INT);
        $stmt->bindParam(':title', $title, PDO::PARAM_STR);
        $stmt->bindParam(':content', $content, PDO::PARAM_STR);
        $stmt->bindParam(':images', $imagesJson, PDO::PARAM_STR);
        return $stmt->execute();
    }
}
?>
