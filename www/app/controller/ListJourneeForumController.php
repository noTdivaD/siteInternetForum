<?php
class ListJourneeForumController {

    private $journeeForumModel;

    public function __construct() {
        require_once BASE_PATH . '/app/model/JourneeForumModel.php';
        $this->journeeForumModel = new JourneeForumModel();
    }

    public function index() {
        // Charge la vue de contact
        $this->displayPage();
    }

    public function displayPage() {
        // Récupère la liste des inscrits
        $registeredUsers = $this->journeeForumModel->getRegisteredUsers();
        // Passe la liste des inscrits à la vue
        require_once BASE_PATH . '/app/view/liste_journee_forum.php';
    }
}
?>
