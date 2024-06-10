<?php
require_once BASE_PATH . '/init.php';
require_once BASE_PATH . '/app/model/AnnuaireModel.php';

class AnnuaireController {
    private $annuaireModel;

    public function __construct() {
        $this->annuaireModel = new AnnuaireModel();
    }

    public function index() {
        require_once BASE_PATH . '/app/view/annuaire.php';
    }

    public function displayPage() {
        $themes = $this->annuaireModel->getThemes();
        return $themes;
    }

    /*
    
    public function addTheme() {
        // Vérifier si la requête est une requête POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            error_log("Requête POST reçue dans addTheme");

            // Initialiser un tableau pour les réponses
            $response = ['success' => false, 'error' => ''];

            // Vérifier que tous les champs requis sont présents
            if (isset($_POST['themeTitle'], $_POST['color_r'], $_POST['color_g'], $_POST['color_b']) && isset($_FILES['themeImage'])) {
                error_log("Tous les champs requis sont présents");

                $title = htmlspecialchars(trim($_POST['themeTitle']));
                $color_r = intval($_POST['color_r']);
                $color_g = intval($_POST['color_g']);
                $color_b = intval($_POST['color_b']);
                $slug = $this->generateSlug($title);

                error_log("Titre: $title, Couleur RGB: ($color_r, $color_g, $color_b), Slug: $slug");

                // Traitement du fichier image
                $targetDir = BASE_PATH . '/public/images/imagesAnnuaire/';
                $imageFileType = strtolower(pathinfo($_FILES['themeImage']['name'], PATHINFO_EXTENSION));
                $targetFile = $targetDir . $slug . '.' . $imageFileType;

                // Vérifier si le fichier est une image réelle
                $check = getimagesize($_FILES['themeImage']['tmp_name']);
                if ($check === false) {
                    $response['error'] = "Le fichier n'est pas une image.";
                    echo json_encode($response);
                    return;
                }

                // Vérifier la taille du fichier (optionnel, ici on limite à 5Mo)
                if ($_FILES['themeImage']['size'] > 5000000) {
                    $response['error'] = "Le fichier est trop volumineux.";
                    echo json_encode($response);
                    return;
                }

                // Autoriser certains formats d'image uniquement
                if (!in_array($imageFileType, ['jpg', 'png', 'jpeg', 'gif'])) {
                    $response['error'] = "Seuls les formats JPG, JPEG, PNG et GIF sont autorisés.";
                    echo json_encode($response);
                    return;
                }

                // Déplacer le fichier téléchargé dans le dossier cible
                if (!move_uploaded_file($_FILES['themeImage']['tmp_name'], $targetFile)) {
                    $response['error'] = "Désolé, une erreur s'est produite lors du téléchargement de votre fichier.";
                    echo json_encode($response);
                    return;
                }

                // Sauvegarder les informations du thème dans la base de données
                $image_url = '/public/images/imagesAnnuaire/' . $slug . '.' . $imageFileType;
                $themeData = [
                    'title' => $title,
                    'slug' => $slug,
                    'image_url' => $image_url,
                    'color_r' => $color_r,
                    'color_g' => $color_g,
                    'color_b' => $color_b
                ];

                error_log("Données du thème à enregistrer: " . json_encode($themeData));

                if ($this->annuaireModel->addTheme($themeData)) {
                    $response['success'] = true;
                    $response['theme'] = $themeData;
                    error_log("Thème ajouté avec succès");
                } else {
                    $response['error'] = "Erreur lors de l'enregistrement du thème.";
                    error_log("Erreur lors de l'enregistrement du thème");
                }
            } else {
                $response['error'] = "Tous les champs requis ne sont pas remplis.";
                error_log("Tous les champs requis ne sont pas remplis");
            }

            echo json_encode($response);
        }
    }

    private function generateSlug($title) {
        $slug = strtolower($title);
        $slug = str_replace(' ', '_', $slug);
        $slug = iconv('UTF-8', 'ASCII//TRANSLIT//IGNORE', $slug);
        $slug = preg_replace('/[^a-z0-9_]/', '', $slug);
        return $slug;
    }

    */
}
?>
