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
        $contentTop = $_POST['content_top'];
        $contentBottom = $_POST['content_bottom'];

        // Log les données POST
        error_log("Données POST :");
        error_log("article_id : " . $articleId);
        error_log("title : " . $title);
        error_log("content_top : " . $contentTop);
        error_log("content_bottom : " . $contentBottom);

        // Vérifier que le titre et le contenu ne sont pas vides
        if (empty($title) || empty($contentTop) || empty($contentBottom)) {
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
            // Mettre à jour l'article avec le nouveau contenu
            $updateSuccess = $this->model->updateContent($articleId, $title, $contentTop, $contentBottom);
            error_log("Article mis à jour avec succès.");

            // Valider la transaction
            if ($updateSuccess) {
                $pdo->commit();
                error_log("Transaction validée.");
                // Répondre avec succès
                echo json_encode(['success' => true]);
            } else {
                throw new Exception("Erreur lors de la mise à jour de l'article.");
            }
        } catch (Exception $e) {
            // Annuler la transaction en cas d'erreur
            $pdo->rollBack();
            error_log("Erreur lors de la mise à jour de l'article : " . $e->getMessage());
            echo json_encode(['error' => 'Erreur lors de la mise à jour de l\'article : ' . $e->getMessage()]);
        }
    }

    public function updateAssociation() {
        if (!isset($_SESSION['user_logged_in']) || $_SESSION['user_type'] != 'administrateur') {
            http_response_code(403);
            echo json_encode(['error' => 'Accès refusé.']);
            exit();
        }
    
        $associationId = $_POST['association_id']; // ID de la nouvelle association sélectionnée
        $articleId = $_POST['article_id'];
    
        // Mettre à jour l'association dans la table "associations"
        $success = $this->model->updateAssociation($associationId, 1);
        if (!$success) {
            echo json_encode(['error' => 'Erreur lors de la mise à jour de l\'association.']);
            exit();
        }
    
        // Mettre à jour l'article avec le nouveau contenu et l'association
        $success = $this->model->updateArticle($articleId, $title, $content1, $content2);
        if ($success) {
            echo json_encode(['success' => true]);
        } else {
            echo json_encode(['error' => 'Erreur lors de la mise à jour de l\'article.']);
        }
    }
}
?>
