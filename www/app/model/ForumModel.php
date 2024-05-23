<?php
require_once BASE_PATH . '/init.php';

class ForumModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getArticle() {
        $sql = "SELECT * FROM articles_forum";
        $result = $this->db->query($sql);
        $articles = $result->fetchAll(PDO::FETCH_ASSOC);
        return $articles;
    }

    public function updateArticle($id, $title, $content, $imageUrl) {
        $sql = "UPDATE articles_forum SET title = ?, content = ?, image_url = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute([$title, $content, $imageUrl, $id])) {
            return true;
        } else {
            error_log("SQL Error: " . implode(":", $stmt->errorInfo()));
            return false;
        }
    }
}
?>
