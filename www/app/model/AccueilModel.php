<?php
require_once BASE_PATH . '/init.php';

class AccueilModel {
    private $db;

    public function __construct() {
        $this->db = Database::getInstance();
    }

    public function getArticles() {
        $sql = "SELECT * FROM articles_acceuil ORDER BY creation_date ASC";
        $result = $this->db->query($sql);
        $articles = $result->fetchAll(PDO::FETCH_ASSOC);
        return $articles;
    }

    public function addArticle($title, $content, $imageUrl = null) {
        $sql = "INSERT INTO articles_acceuil (title, content, image_url) VALUES (?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute([$title, $content, $imageUrl])) {
            return $this->db->lastInsertId();
        } else {
            error_log("SQL Error: " . implode(":", $stmt->errorInfo()));
            return false;
        }
    }

    public function updateArticle($id, $title, $content, $imageUrl) {
        $sql = "UPDATE articles_acceuil SET title = ?, content = ?, image_url = ? WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        if ($stmt->execute([$title, $content, $imageUrl, $id])) {
            return true;
        } else {
            error_log("SQL Error: " . implode(":", $stmt->errorInfo()));
            return false;
        }
    }

    public function deleteArticle($id) {
        try {
            $this->db->beginTransaction();
            $sql = "DELETE FROM articles_acceuil WHERE id = ?";
            $stmt = $this->db->prepare($sql);
            if (!$stmt->execute([$id])) {
                error_log("SQL Error: " . implode(":", $stmt->errorInfo()));
                $this->db->rollBack();
                return false;
            }
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            error_log("Transaction Error: " . $e->getMessage());
            return false;
        }
    }

    public function getArticleById($id) {
        $sql = "SELECT * FROM articles_acceuil WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
    
}
?>
