<?php

class MonCompteController {
    public function index() {
        // Charge la vue du compte
        require_once BASE_PATH . '/app/view/mon_compte.php';
    }

    public function update_account() {
        require_once BASE_PATH . '/init.php'; 
        require_once BASE_PATH . '/app/model/UserModel.php';

        // Vérifie que l'utilisateur soit bien connecté
        if (!isset($_SESSION['user_logged_in']) || !$_SESSION['user_logged_in']) {
            header('Location: /app/connexion');
            exit();
        }

        $response = ['success' => false];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            // Récupérer les données du formulaire avec FILTER_SANITIZE_FULL_SPECIAL_CHARS
            $firstname = filter_input(INPUT_POST, 'firstname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $lastname = filter_input(INPUT_POST, 'lastname', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $address = filter_input(INPUT_POST, 'address', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $city = filter_input(INPUT_POST, 'city', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $postal_code = filter_input(INPUT_POST, 'postal_code', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
            $country = filter_input(INPUT_POST, 'country', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            // Validation côté serveur
            if (strlen($firstname) < 2) {
                $response['error'] = "Le prénom n'est pas correct.";
            } elseif (strlen($lastname) < 2) {
                $response['error'] = "Le nom n'est pas correct.";
            } elseif (strlen($address) < 2) {
                $response['error'] = "L'adresse n'est pas correcte.";
            } elseif (strlen($city) < 2) {
                $response['error'] = "La ville n'est pas correcte.";
            } elseif (!preg_match('/^\d{5}$/', $postal_code)) {
                $response['error'] = "Le code postal n'est pas valide.";
            } elseif (strlen($country) < 2) {
                $response['error'] = "Le pays n'est pas correct.";
            } else {
                $user_id = $_SESSION['user']['id'];
                $userModel = new UserModel();

                if ($userModel->updateUserInfo($user_id, $firstname, $lastname, $address, $city, $postal_code, $country)) {
                    // Vérifier et traiter la photo de profil
                    if (!empty($_FILES['profile_photo']['name'])) {
                        $photo = $_FILES['profile_photo'];
                        $fileTmpPath = $photo['tmp_name'];
                        $fileName = $photo['name'];
                        $fileNameCmps = explode(".", $fileName);
                        $fileExtension = strtolower(end($fileNameCmps));
                        $allowedfileExtensions = ['png', 'jpg', 'jpeg', 'gif'];

                        if (in_array($fileExtension, $allowedfileExtensions)) {
                            $newFileName = md5(time() . $fileName) . '.' . $fileExtension;
                            $uploadDir = BASE_PATH . '/upload/';
                            $dest_path = $uploadDir . $newFileName;

                            // Créer le répertoire s'il n'existe pas
                            if (!is_dir($uploadDir)) {
                                mkdir($uploadDir, 0755, true);
                            }

                            if (move_uploaded_file($fileTmpPath, $dest_path)) {
                                $photo_path = BASE_URL . '/upload/' . $newFileName;
                                $userModel->updateUserProfilePhoto($user_id, $photo_path);
                                $response['photo_profil_url'] = $photo_path;
                                // Mettre à jour la session utilisateur
                                $_SESSION['user']['photo_profil'] = $photo_path;
                            } else {
                                $response['error'] = "Erreur lors de l'upload de la photo de profil.";
                            }
                        } else {
                            $response['error'] = "Type de fichier non autorisé.";
                        }
                    }

                    // Mettre à jour la session utilisateur
                    $_SESSION['user']['prenom'] = $firstname;
                    $_SESSION['user']['nom'] = $lastname;
                    $_SESSION['user']['adresse'] = $address;
                    $_SESSION['user']['ville'] = $city;
                    $_SESSION['user']['code_postal'] = $postal_code;
                    $_SESSION['user']['pays'] = $country;

                    $response['success'] = true;
                } else {
                    $response['error'] = "Erreur lors de la mise à jour des informations.";
                }
            }
        }

        header('Content-Type: application/json');
        echo json_encode($response);
        exit();
    }
}
?>
