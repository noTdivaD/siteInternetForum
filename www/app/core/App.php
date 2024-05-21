<?php
class App {
    protected $controller;
    protected $method = 'index';
    protected $params = [];

    public function __construct() {
        $url = $this->parseUrl();

        // Mapping des URL aux noms des contrôleurs
        $controllerMap = [
            'connexion' => 'LoginController',
            'inscription' => 'RegisterController',
            'accueil_upgrade' => 'AccueilController',
            'mdp_oublie' => 'ForgotPasswordController',
            'contacter' => 'ContactController',
            'mdp_reinitialise' => 'ResetPasswordController',
            'deconnexion' => 'LogoutController',
            'mdp_email_envoye' => 'SentResetEmailController',
            'forum_email_envoye' => 'SentForumEmailController',
            'journee_forum' => 'ForumController',
            'annuaire_associations' => 'AnnuaireController',
            'associations_sports' => 'SportsController',
            'associations_animationsloisirs' => 'AnimationsLoisirsController',
            'associations_artsculture' => 'ArtsCultureController',
            'associations_bienetre' => 'BienEtreController',
            'associations_humanitaires' => 'HumanitaireController'
        ];

        // Extrait le nom du contrôleur basé sur l'URL ou utilise un contrôleur par défaut
        $controllerName = $controllerMap[$url[0]] ?? 'HomeController';
        $controllerPath = __DIR__ . "/../controller/" . $controllerName . ".php";

        // Vérifie si le fichier du contrôleur existe et inclut-le
        if (file_exists($controllerPath)) {
            require_once $controllerPath;
            switch ($controllerName) {
                case 'SportsController':
                    $this->controller = new SportsController();
                    break;
                case 'AnimationsLoisirsController':
                    $this->controller = new AnimationsLoisirsController();
                    break;
                case 'ArtsCultureController':
                    $this->controller = new ArtsCultureController();
                    break;
                case 'BienEtreController':
                    $this->controller = new BienEtreController();
                    break;
                case 'HumanitaireController':
                    $this->controller = new HumanitaireController();
                    break;
                default:
                    $this->controller = new $controllerName();
            }
            error_log("Controller {$controllerName} loaded successfully.");
        } else {
            throw new Exception("Controller file not found: {$controllerPath}");
        }

        // Vérifie et appelle la méthode du contrôleur avec d'éventuels paramètres supplémentaires
        if (isset($url[1])) {
            $this->method = $url[1];
        }

        $this->params = array_slice($url, 2);

        if (method_exists($this->controller, $this->method)) {
            error_log("Calling method {$this->method} on controller {$controllerName}.");
            call_user_func_array([$this->controller, $this->method], $this->params);
        } else {
            throw new Exception("Method {$this->method} not found in controller {$controllerName}");
        }
    }

    private function parseUrl() {
        $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
        $segments = explode('/', trim($path, '/'));

        // On s'intéresse à la partie de l'URL après '/app/'
        $appIndex = array_search('app', $segments);
        if ($appIndex !== false && isset($segments[$appIndex + 1])) {
            return array_slice($segments, $appIndex + 1);
        }

        return [];
    }
}
