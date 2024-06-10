<?php
class NosPartenairesController {
    private $model;

    public function __construct() {
        require_once BASE_PATH . '/app/model/NosPartenairesModel.php';
        require_once BASE_PATH . '/config/config.php'; // Inclure la configuration
        $this->model = new NosPartenairesModel();
        error_log("Controller AccueilController loaded successfully.");
    }

    public function index() {
        require_once BASE_PATH . '/app/view/nos_partenaires.php';
        error_log("Calling method index on controller NosPartenairesController.");
    }

}
?>
