<?php
class JourneeForumController {
    private $journeeForumModel;

    public function __construct() {
        require_once BASE_PATH . '/app/model/JourneeForumModel.php';
        require_once BASE_PATH . '/config/config.php';
        $this->journeeForumModel = new JourneeForumModel();
        error_log("Controller JourneeForumModel loaded successfully.");
    }

    public function index() {
        require_once BASE_PATH . '/app/view/journee_forum.php';
        error_log("Calling method index on controller JourneeForumController.");
    }

    public function displayPage() {
        $article = $this->journeeForumModel->getArticleById(1);
        return $article;
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
        $content = $_POST['content'];
        $existingImages = json_decode($_POST['existing_images'], true);
        $newImages = json_decode($_POST['new_images'], true);
    
        // Log les données POST
        error_log("Données POST :");
        error_log("article_id : " . $articleId);
        error_log("title : " . $title);
        error_log("content : " . $content);
        error_log("existingImages : " . json_encode($existingImages));
        error_log("newImages : " . json_encode($newImages));
    
        // Vérifier que le titre et le contenu ne sont pas vides
        if (empty($title) || empty($content)) {
            echo json_encode(['error' => 'Les champs titre et contenu sont obligatoires.']);
            exit();
        }
    
        // Connexion à la base de données
        $pdo = Database::getInstance();
        error_log("Connexion à la base de données réussie.");
    
        // Commencer une transaction
        $pdo->beginTransaction();
        error_log("Début de la transaction.");
    
        try {
            // Récupérer les images actuelles de la base de données
            $article = $this->journeeForumModel->getArticleById($articleId);
            $currentImages = json_decode($article['images'], true);
    
            // Extraire uniquement les URLs des images existantes
            $existingImageUrls = array_map(function($image) {
                return $image['url'];
            }, $existingImages);
            
            error_log("URLs des images existantes : " . json_encode($existingImageUrls));
    
            // Créer des listes pour trier les images
            $imagesToDelete = array_diff($currentImages, $existingImageUrls);
            error_log("Images à supprimer : " . json_encode($imagesToDelete));
    
            // Supprimer les images qui ne sont plus présentes
            foreach ($imagesToDelete as $url) {
                error_log("Suppression de l'image : " . $url);
                // Supprimer le fichier image du serveur
                $filePath = $_SERVER['DOCUMENT_ROOT'] . parse_url($url, PHP_URL_PATH);
                if (file_exists($filePath)) {
                    unlink($filePath);
                    error_log("Fichier supprimé : " . $filePath);
                } else {
                    error_log("Fichier non trouvé : " . $filePath);
                }
            }

            // Liste des extensions autorisées
            $allowedfileExtensions = ['png', 'jpg', 'jpeg', 'gif'];
    
            // Ajouter les nouvelles images
            foreach ($newImages as $image) {
                // Vérifier l'extension de l'image
                $extension = strtolower(pathinfo($image['name'], PATHINFO_EXTENSION));
                if (!in_array($extension, $allowedfileExtensions)) {
                    throw new Exception('Extension de fichier non autorisée : ' . $extension);
                }

                // Générer un chemin unique pour l'image
                $imagePath = '/upload/' . uniqid() . '.' . $image['extension'];
                $filePath = $_SERVER['DOCUMENT_ROOT'] . $imagePath;
                // Décoder l'image base64 et la sauvegarder sur le serveur
                $imageData = base64_decode(preg_replace('#^data:image/\w+;base64,#i', '', $image['url']));
                file_put_contents($filePath, $imageData);
                error_log("Nouvelle image ajoutée : " . $imagePath);
    
                // Ajouter l'URL de la nouvelle image à la liste des images existantes
                $existingImageUrls[] = BASE_URL . $imagePath;
            }
    
            // Log l'état final des images
            error_log("Images finales : " . json_encode($existingImageUrls));
    
            // Mettre à jour l'article avec le nouveau contenu et les images
            $this->journeeForumModel->updateArticle($articleId, $title, $content, $existingImageUrls);
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
