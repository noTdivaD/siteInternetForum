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
            'index' => 'AccueilController',
            'mdp_oublie' => 'ForgotPasswordController',
            'contacter' => 'ContactController',
            'mdp_reinitialise' => 'ResetPasswordController',
            'deconnexion' => 'LogoutController',
            'mdp_email_envoye' => 'SentResetEmailController',
            'forum_email_envoye' => 'SentForumEmailController',
            'journee_forum' => 'JourneeForumController',
            'authentification' => 'PasswordProtectController',
            'verify_email' => 'VerifyEmailController',
            'email_verified' => 'EmailConfirmedController',
            'email_verification_failed' => 'EmailConfirmationErrorController',
            'inscription_journee_forum' => 'RegisterJourneeForumController',
            'inscription_journee_forum_success' => 'RegisterJourneeForumSuccessController',
            'liste_journee_forum' => 'ListJourneeForumController',
            'mon_compte' => 'MonCompteController',
            'infos_utiles' => 'InfosUtilesController',
            'nos_partenaires' => 'NosPartenairesController',
            'rencontres_associatives' => 'RencontreController',
            'college_experts' => 'CollegeExpertsController',
            'annuaire_associations' => 'AnnuaireController',
            'associations_sports' => 'AssociationsController',
            'associations_animations_et_loisirs' => 'AssociationsController',
            'associations_arts_et_culture' => 'AssociationsController',
            'associations_bien_etre' => 'AssociationsController',
            'associations_humanitaire_social_civique_et_environnement' => 'AssociationsController',
            'associations_ecologie_et_environnement' => 'AssociationsController',
            'associations_anciens_combattants_et_assimiles' => 'AssociationsController',
            'associations_economie_et_developpement' => 'AssociationsController'
        ];

        // Extrait le nom du contrôleur basé sur l'URL ou utilise un contrôleur par défaut
        if (!empty($url[0])) {
            $controllerName = $controllerMap[$url[0]] ?? 'HomeController';
        } else {
            $controllerName = 'AccueilController'; // Définir AccueilController comme contrôleur par défaut
        }
        
        $controllerPath = __DIR__ . "/../controller/" . $controllerName . ".php";

        // Vérifie si le fichier du contrôleur existe et inclut-le
        if (file_exists($controllerPath)) {
            require_once $controllerPath;
            $this->controller = new $controllerName();
            error_log("Controller {$controllerName} loaded successfully.");
        } else {
            throw new Exception("Controller file not found: {$controllerPath}");
        }

        // Vérifie et appelle la méthode du contrôleur avec d'éventuels paramètres supplémentaires
        if (isset($url[1])) {
            $this->method = $url[1];
        } else if (strpos($url[0], 'associations_') === 0) {
            $this->method = 'getAssociationsByTheme';
            $this->params = [str_replace('associations_', '', $url[0])];
        }

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
?>
