<?php
class AssociationsController {
    private $model;

    // Constructeur pour initialiser le modèle des associations
    public function __construct() {
        // Inclut le fichier du modèle des associations
        require_once BASE_PATH . '/app/model/AssociationsModel.php';
        // Initialise une instance du modèle des associations
        $this->model = new AssociationsModel();
    }

    // Méthode pour afficher les associations par thème
    public function getAssociationsByTheme($theme) {
        // Log le thème reçu
        error_log("Thème reçu: " . $theme);
        
        // Récupère les associations correspondant au thème via le modèle
        $associations = $this->model->getAssociationsByTheme($theme);

        // Log les associations récupérées
        error_log("Associations récupérées: " . json_encode($associations));

        // Met en forme le titre de la page actuelle à partir du thème
        $currentPage = ucfirst(str_replace('_', ' ', $theme));
        
        // Charge la vue spécifique du thème
        $viewFile = BASE_PATH . '/app/view/' . $theme . '.php';
        if (file_exists($viewFile)) {
            require_once $viewFile;
        } else {
            throw new Exception("View file not found: {$viewFile}");
        }

        return $associations;
    }
}
?>
