<?php
class AccueilController {
    
    private $model; // Déclaration de la propriété

    public function __construct() {
        require_once BASE_PATH . '/app/model/AccueilModel.php'; // Inclure le modèle
        $this->model = new AccueilModel(); // Initialisation dans le constructeur
    }

    public function index() {
        require_once BASE_PATH . '/app/view/accueil_upgrade.php';
    }

    public function displayPage() {
        // Récupération des articles
        $articles = $this->model->getArticles();
        return $articles; // Retourne les articles au lieu de les inclure directement
    }

    public function addArticle() {
        $response = ['success' => false];
        define('UPLOAD_DIR', BASE_PATH . '/upload/');
    
        if (isset($_SESSION['user_logged_in']) && $_SESSION['user_type'] == 'administrateur') {
            $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    
            if (empty($title) || empty($content)) {
                $response['error'] = 'Les champs titre et contenu sont obligatoires.';
                echo json_encode($response);
                exit;
            }
    
            if (!is_dir(UPLOAD_DIR)) {
                mkdir(UPLOAD_DIR, 0755, true); // Assurez-vous que les permissions permettent l'écriture par le serveur web
            }
    
            $imageUrl = null;
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
                        $imageUrl = $dest_path;  // Chemin relatif à enregistrer dans la base de données
                    } else {
                        $response['error'] = 'Erreur lors du chargement de l\'image.';
                        echo json_encode($response);
                        exit;
                    }
                } else {
                    $response['error'] = 'Type de fichier non autorisé.';
                    echo json_encode($response);
                    exit;
                }
            }
    
            $newArticleId = $this->model->addArticle($title, $content, $imageUrl);
            if ($newArticleId) {
                $response['success'] = true;
                $response['article'] = [
                    'id' => $newArticleId,
                    'title' => $title,
                    'content' => $content,
                    'image_url' => $imageUrl
                ];
            } else {
                $response['error'] = 'Impossible d\'ajouter l\'article.';
            }
        } else {
            $response['error'] = 'Accès non autorisé.';
        }
    
        if (ob_get_contents()) {
            ob_clean(); // Nettoie le buffer de sortie si quelque chose a été ajouté avant
        }
    
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    
    

    public function updateArticle($id, $title, $content, $imageUrl) {
        $this->model->updateArticle($id, $title, $content, $imageUrl);
    }

    public function deleteArticle() {
        if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['article_id'])) {
            $articleId = filter_input(INPUT_POST, 'article_id', FILTER_SANITIZE_NUMBER_INT);
    
            if (!$articleId) {
                $response = ['success' => false, 'error' => 'ID de l\'article invalide.'];
                error_log("ID de l'article invalide.");
            } else if (isset($_SESSION['user_logged_in']) && $_SESSION['user_type'] == 'administrateur') {
                error_log("Tentative de suppression de l'article avec l'ID: $articleId");
                $deleted = $this->model->deleteArticle($articleId);
                if ($deleted) {
                    $response = ['success' => true];
                    error_log("Article avec l'ID: $articleId supprimé avec succès.");
                } else {
                    $response = ['success' => false, 'error' => 'Erreur lors de la suppression de l\'article dans la base de données.'];
                    error_log("Erreur lors de la suppression de l'article avec l'ID: $articleId dans la base de données.");
                }
            } else {
                $response = ['success' => false, 'error' => 'Accès non autorisé.'];
                error_log("Accès non autorisé pour supprimer l'article avec l'ID: $articleId.");
            }
        } else {
            $response = ['success' => false, 'error' => 'Requête invalide.'];
            error_log("Requête invalide pour supprimer l'article avec l'ID: $articleId.");
        }
    
        if (ob_get_contents()) {
            ob_clean(); // Nettoie le buffer de sortie si quelque chose a été ajouté avant
        }
    
        header('Content-Type: application/json');
        echo json_encode($response);
        exit;
    }
    
    
    
    
    
    
    
}
