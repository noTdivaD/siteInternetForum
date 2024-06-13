<?php
class CollegeExpertsController {
    private $model;

    public function __construct() {
        try {
            require_once BASE_PATH . '/app/model/CollegeExpertsModel.php';
            require_once BASE_PATH . '/config/config.php';
            $this->model = new CollegeExpertsModel();
            error_log("Controller CollegeExpertsController loaded successfully.");
        } catch (Exception $e) {
            error_log("Failed to load controller: " . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Failed to load controller']);
            exit();
        }
    }

    public function index() {
        try {
            $faqs = $this->model->getAllFAQs();
            $experts = $this->model->getAllExperts();
            require_once BASE_PATH . '/app/view/college_experts.php';
            error_log("Calling method index on controller CollegeExpertsController.");
        } catch (Exception $e) {
            error_log("Failed to load index: " . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Failed to load index']);
        }
    }

    public function getFAQ() {
        try {
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            error_log("Fetching FAQ with ID: " . $id);
            if ($id) {
                $faq = $this->model->getFAQById($id);
                if ($faq) {
                    error_log("FAQ found: " . json_encode($faq));
                    echo json_encode($faq);
                } else {
                    error_log("FAQ not found");
                    http_response_code(404);
                    echo json_encode(['error' => 'FAQ not found']);
                }
            } else {
                error_log("Invalid FAQ ID");
                http_response_code(400);
                echo json_encode(['error' => 'Invalid ID']);
            }
        } catch (Exception $e) {
            error_log("Error fetching FAQ: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Error fetching FAQ']);
        }
    }

    public function addFAQ() {
        try {
            $question = isset($_POST['question']) ? trim($_POST['question']) : '';
            $answer = isset($_POST['answer']) ? trim($_POST['answer']) : '';
            error_log("Adding FAQ: " . $question);

            if ($question && $answer) {
                $id = $this->model->addFAQ($question, $answer);
                if ($id) {
                    $faq = $this->model->getFAQById($id);
                    error_log("FAQ added successfully: " . json_encode($faq));
                    echo json_encode(['status' => 'success', 'faq' => $faq]);
                } else {
                    error_log("Failed to add FAQ");
                    echo json_encode(['status' => 'error', 'message' => 'Failed to add FAQ']);
                }
            } else {
                error_log("Invalid FAQ data");
                echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            }
        } catch (Exception $e) {
            error_log("Error adding FAQ: " . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Error adding FAQ']);
        }
    }

    public function deleteFAQ() {
        try {
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            error_log("Deleting FAQ with ID: " . $id);
            if ($id) {
                $this->model->deleteFAQ($id);
                echo json_encode(['status' => 'success']);
            } else {
                error_log("Invalid FAQ ID");
                echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
            }
        } catch (Exception $e) {
            error_log("Error deleting FAQ: " . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Error deleting FAQ']);
        }
    }

    public function getExpert() {
        try {
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            error_log("Fetching Expert with ID: " . $id);
            if ($id) {
                $expert = $this->model->getExpertById($id);
                if ($expert) {
                    error_log("Expert found: " . json_encode($expert));
                    echo json_encode($expert);
                } else {
                    error_log("Expert not found");
                    http_response_code(404);
                    echo json_encode(['error' => 'Expert not found']);
                }
            } else {
                error_log("Invalid Expert ID");
                http_response_code(400);
                echo json_encode(['error' => 'Invalid ID']);
            }
        } catch (Exception $e) {
            error_log("Error fetching Expert: " . $e->getMessage());
            http_response_code(500);
            echo json_encode(['error' => 'Error fetching Expert']);
        }
    }

    public function addExpert() {
        try {
            $titre = isset($_POST['title']) ? trim($_POST['title']) : '';
            $description = isset($_POST['description']) ? trim($_POST['description']) : '';
            $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $image_url = isset($_FILES['image']) ? $this->uploadImage($_FILES['image']) : null;
            error_log("Adding Expert: " . $titre);

            if ($titre && $description && $phone && $email) {
                $id = $this->model->addExpert($titre, $description, $phone, $email, $image_url);
                if ($id) {
                    $expert = $this->model->getExpertById($id);
                    error_log("Expert added successfully: " . json_encode($expert));
                    echo json_encode(['status' => 'success', 'expert' => $expert]);
                } else {
                    error_log("Failed to add Expert");
                    echo json_encode(['status' => 'error', 'message' => 'Failed to add expert']);
                }
            } else {
                error_log("Invalid Expert data");
                echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            }
        } catch (Exception $e) {
            error_log("Error adding Expert: " . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Error adding expert']);
        }
    }

    public function editExpert() {
        try {
            $id = isset($_POST['expert_id']) ? (int)$_POST['expert_id'] : 0;
            $titre = isset($_POST['title']) ? trim($_POST['title']) : '';
            $description = isset($_POST['description']) ? trim($_POST['description']) : '';
            $phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
            $email = isset($_POST['email']) ? trim($_POST['email']) : '';
            $deleteImage = isset($_POST['delete_image']) ? (bool)$_POST['delete_image'] : false;
            $image_url = null;
    
            error_log("Editing Expert with ID: $id");
    
            if ($id && $titre && $description && $phone && $email) {
                // Check if a new image is uploaded
                if (isset($_FILES['image']) && $_FILES['image']['error'] == UPLOAD_ERR_OK) {
                    $image_url = $this->uploadImage($_FILES['image']);
                    error_log("New image uploaded: $image_url");
                } elseif ($deleteImage) {
                    // If delete image is checked and no new image uploaded
                    $image_url = null;
                    error_log("Image deletion requested");
                } else {
                    // If no new image uploaded and delete image is not checked, retain the existing image
                    $existingImageUrl = isset($_POST['existing_image_url']) ? $_POST['existing_image_url'] : null;
                    $image_url = $existingImageUrl;
                }
    
                $success = $this->model->updateExpert($id, $titre, $description, $phone, $email, $image_url);
                if ($success) {
                    $expert = $this->model->getExpertById($id);
                    error_log("Expert updated successfully: " . json_encode($expert));
                    echo json_encode(['status' => 'success', 'expert' => $expert]);
                } else {
                    error_log("Failed to update expert in database.");
                    echo json_encode(['status' => 'error', 'message' => 'Failed to update expert']);
                }
            } else {
                error_log("Invalid data provided for expert update.");
                echo json_encode(['status' => 'error', 'message' => 'Invalid data']);
            }
        } catch (Exception $e) {
            error_log("Error editing Expert: " . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Error editing expert']);
        }
    }    

    public function deleteExpert() {
        try {
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            error_log("Deleting Expert with ID: " . $id);
            if ($id) {
                $this->model->deleteExpert($id);
                echo json_encode(['status' => 'success']);
            } else {
                error_log("Invalid Expert ID");
                echo json_encode(['status' => 'error', 'message' => 'Invalid ID']);
            }
        } catch (Exception $e) {
            error_log("Error deleting Expert: " . $e->getMessage());
            echo json_encode(['status' => 'error', 'message' => 'Error deleting expert']);
        }
    }

    private function uploadImage($file) {
        try {
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
            $fileExtension = pathinfo($file['name'], PATHINFO_EXTENSION);

            if (!in_array($fileExtension, $allowedExtensions)) {
                error_log("Invalid file type: " . $fileExtension);
                throw new Exception('Invalid file type. Only JPG, JPEG, PNG and GIF types are allowed.');
            }

            $uploadDirectory = BASE_PATH . '/upload/';
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true);
            }

            $filename = basename($file['name']);
            $uploadFilePath = $uploadDirectory . $filename;

            if (!move_uploaded_file($file['tmp_name'], $uploadFilePath)) {
                error_log("Failed to upload file: " . $filename);
                throw new Exception('Failed to upload file.');
            }

            $fileUrl = BASE_URL . '/upload/' . $filename;
            error_log("File uploaded successfully: " . $fileUrl);
            return $fileUrl;
        } catch (Exception $e) {
            error_log("Error uploading file: " . $e->getMessage());
            throw $e;
        }
    }
}
?>
