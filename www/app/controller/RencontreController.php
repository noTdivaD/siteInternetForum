<?php
class RencontreController {
    private $model;

    public function __construct() {
        require_once BASE_PATH . '/app/model/RencontreModel.php';
        require_once BASE_PATH . '/config/config.php'; // Inclure la configuration
        $this->model = new RencontreModel();
    }

    public function getContent() {
        $content = $this->model->getContent();
        return $content;
    }

    public function getAssociation() {
        $association = $this->model->getAssociations();
        return $association;
    }

    public function getAll() {
        $associations = $this->model->getAllAssociations();
        return $associations;
    }

    public function index() {
        // Charge la vue des rencontres associatives
        require_once BASE_PATH . '/app/view/rencontres_associatives.php';
    }

    public function updateArticle() {
        // Vérifiez si l'utilisateur a les droits administratifs
        if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_type'] != 'administrateur') {
            http_response_code(403);
            echo json_encode(['error' => 'Accès refusé.']);
            exit();
        }
    
        // Récupérer les données POST
        $articleId = $_POST['article_id'];
        $title = $_POST['title'];
        $content1 = $_POST['content1'];
        $content2 = $_POST['content2'];
    
        // Log les données POST
        error_log("Données POST :");
        error_log("article_id : " . $articleId);
        error_log("title : " . $title);
        error_log("content1 : " . $content1);
        error_log("content2 : " . $content2);
    
        // Vérifier que le titre et le contenu ne sont pas vides
        if (empty($title) || empty($content1) || empty($content2)) {
            echo json_encode(['error' => 'Tous les champs sont obligatoires.']);
            exit();
        }
    
        // Connexion à la base de données
        $pdo = Database::getInstance();
        error_log("Connexion à la base de données réussie.");
    
        // Commencer une transaction
        $pdo->beginTransaction();
        error_log("Début de la transaction.");
    
        try {
            // Mettre à jour l'article avec le nouveau contenu et les images
            $this->RencontreModel->updateArticle($articleId, $title, $content1, $content2);
            error_log("Article mis à jour avec succès.");
    
            // Valider la transaction
            $pdo->commit();
            error_log("Transaction validée.");
    
            // Répondre avec succès
            echo json_encode(['success' => true]);
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            $pdo->rollBack();
            error_log("Erreur lors de la mise à jour de l'article : " . $e->getMessage());
            echo json_encode(['error' => 'Erreur lors de la mise à jour de l\'article : ' . $e->getMessage()]);
        }
    }    
}
?>
