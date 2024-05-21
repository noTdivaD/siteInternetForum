<?php

class AssociationsController {
    private $model;

    public function __construct($modelName) {
        require_once BASE_PATH . '/app/model/' . $modelName . '.php';
        $this->model = new $modelName();
    }

    public function displayPage() {
        $articles = $this->model->getAssociations();
        return $articles;
    }

    public function index($view) {
        require_once BASE_PATH . '/app/view/' . $view . '.php';
    }
}
?>
