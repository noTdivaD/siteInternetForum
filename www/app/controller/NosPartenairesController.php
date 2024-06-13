<?php
class NosPartenairesController {
    private $model;

    public function __construct() {
        require_once BASE_PATH . '/app/model/NosPartenairesModel.php';
        require_once BASE_PATH . '/config/config.php'; // Inclure la configuration
        $this->model = new NosPartenairesModel();
        error_log("Controller NosPartenairesController loaded successfully.");
    }

    public function index() {
        $paragraphe = $this->model->getParagraph();
        $partenaires = $this->model->getPartenaires();
        require_once BASE_PATH . '/app/view/nos_partenaires.php';
        error_log("Calling method index on controller NosPartenairesController.");
    }

    public function getParagraphAjax() {
        try {
            $paragraphe = $this->model->getParagraph();
            echo json_encode(['content_value' => $paragraphe]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function getPartenaireByIdAjax() {
        try {
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            if (!$id) throw new Exception('Invalid ID');
            $partenaire = $this->model->getPartenaireById($id);
            echo json_encode($partenaire);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function addPartenaireAjax() {
        try {
            $titre = $_POST['title'];
            $nom = $_POST['nom'];
            $description = $_POST['description'];
            $imageUrl = null;

            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $imageUrl = $this->uploadImage($_FILES['image']);
            }

            $id = $this->model->addPartenaire($titre, $nom, $description, $imageUrl);
            $partenaire = $this->model->getPartenaireById($id);
            echo json_encode(['status' => 'success', 'partenaire' => $partenaire]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function updatePartenaireAjax() {
        try {
            $id = $_POST['id'];
            $titre = $_POST['title'];
            $nom = $_POST['nom'];
            $description = $_POST['description'];
            $imageUrl = null;

            // Vérifier si l'image doit être supprimée
            if (isset($_POST['delete_image']) && $_POST['delete_image'] === 'on') {
                // Vérifier si une nouvelle image est fournie
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $imageUrl = $this->uploadImage($_FILES['image']);
                } else {
                    // Si aucune nouvelle image n'est fournie, renvoyer une erreur
                    throw new Exception('Vous devez ajouter une nouvelle image si vous supprimez l\'image existante.');
                }
            } else {
                if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                    $imageUrl = $this->uploadImage($_FILES['image']);
                }
            }

            $this->model->updatePartenaire($id, $titre, $nom, $description, $imageUrl);
            $partenaire = $this->model->getPartenaireById($id);
            echo json_encode(['status' => 'success', 'partenaire' => $partenaire]);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    private function uploadImage($file) {
        $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
        $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);

        if (!in_array($fileExtension, $allowedExtensions)) {
            throw new Exception('Invalid file type. Only JPG, JPEG, PNG and GIF types are allowed.');
        }

        $uploadDirectory = BASE_PATH . '/upload/';
        if (!is_dir($uploadDirectory)) {
            mkdir($uploadDirectory, 0777, true);
        }

        $filename = basename($file['name']);
        $uploadFilePath = $uploadDirectory . $filename;

        if (!move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
            throw new Exception('Failed to upload file.');
        }

        return BASE_URL . '/upload/' . $filename;
    }

    public function deletePartenaireAjax() {
        try {
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            if (!$id) throw new Exception('Invalid ID');
            $this->model->deletePartenaire($id);
            echo json_encode(['status' => 'success']);
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function updateParagraphAjax() {
        try {
            $paragraph = $_POST['content'];
            if ($this->model->updateParagraph($paragraph)) {
                echo json_encode(['status' => 'success', 'paragraph' => $paragraph]);
            } else {
                throw new Exception('Failed to update paragraph');
            }
        } catch (Exception $e) {
            echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }
}
?>
