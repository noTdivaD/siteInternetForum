<?php
class ForumController {
    private $model;

    public function index() {
        require_once BASE_PATH . '/app/view/journee_forum.php';
    }

    public function __construct() {
        require_once BASE_PATH . '/app/model/ForumModel.php';
        $this->model = new ForumModel();
    }

    public function displayPage() {
        $article = $this->model->getArticle();
        return $article;
    }

    public function updateArticle() {
        $response = ['success' => false];
    
        // Log initial des données reçues
        $articleId = $_POST['article_id'];
        $title = $_POST['title'];
        $content = $_POST['content'];
        $deleteImage = isset($_POST['delete_image']) && $_POST['delete_image'] === '1';
        error_log("Reçu pour mise à jour - ID: $articleId, Titre: $title, Contenu: $content, Supprimer l'image: $deleteImage");
    
        // Sanitisation
        $articleId = filter_input(INPUT_POST, 'article_id', FILTER_SANITIZE_NUMBER_INT);
        $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_SPECIAL_CHARS);
        $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
    
        // Log après sanitisation
        error_log("Sanitisé pour mise à jour - ID: $articleId, Titre: $title, Contenu: $content");
    
        try {
            if (empty($articleId) || empty($title) || empty($content)) {
                $response['error'] = 'Les champs ID, titre et contenu sont obligatoires.';
                throw new Exception('Validation error: Les champs ID, titre et contenu sont obligatoires.');
            }
    
            $imageUrl = null;
    
            // Suppression de l'image si demandé
            if ($deleteImage) {
                $imageUrl = '';
            }
    
            // Ajout d'une nouvelle image si uploadée
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $fileTmpPath = $_FILES['image']['tmp_name'];
                $fileName = $_FILES['image']['name'];
                $fileNameCmps = explode('.', $fileName);
                $fileExtension = strtolower(end($fileNameCmps));
                $allowedfileExtensions = ['png', 'jpg', 'jpeg', 'gif'];
    
                if (in_array($fileExtension, $allowedfileExtensions)) {
                    $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                    $dest_path = UPLOAD_DIR . $newFileName;
    
                    if (move_uploaded_file($fileTmpPath, $dest_path)) {
                        $imageUrl = BASE_URL . '/upload/' . $newFileName; // URL complète pour le stockage en base de données
                    } else {
                        $response['error'] = 'Erreur lors du chargement de l\'image.';
                        throw new Exception('File upload error: Erreur lors du chargement de l\'image.');
                    }
                } else {
                    $response['error'] = 'Type de fichier non autorisé.';
                    throw new Exception('Invalid file type: Type de fichier non autorisé.');
                }
            }
    
            // Si aucune nouvelle image n'est uploadée et qu'on ne demande pas de suppression, garder l'ancienne image
            if (!$imageUrl && !$deleteImage) {
                $article = $this->model->getArticleById($articleId);
                $imageUrl = $article['image_url'];
            }
    
            $updated = $this->model->updateArticle($articleId, $title, $content, $imageUrl);
            if ($updated) {
                $response['success'] = true;
                $response['article'] = [
                    'id' => $articleId,
                    'title' => $title,
                    'content' => nl2br($content),
                    'image_url' => htmlspecialchars($imageUrl ?? '', ENT_QUOTES, 'UTF-8')
                ];
                error_log("Article modifié: " . print_r($response['article'], true));
            } else {
                $response['error'] = 'Impossible de mettre à jour l\'article.';
                throw new Exception('Database error: Impossible de mettre à jour l\'article.');
            }
        } catch (Exception $e) {
            error_log($e->getMessage());
        }
    
        if (ob_get_length()) {
            ob_end_clean();
        }
    
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($response, JSON_UNESCAPED_UNICODE);
        exit;
    }
}
