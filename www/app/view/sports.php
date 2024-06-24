<?php
    // Titre de la page
    $pageTitle = "Associations sportives - Forum du Pays de Grasse";
    $currentPage = "Associations sportives";

    // Chemin du fichier default.php
    $defaultFilePath = __DIR__ . '/default.php';

    // Vérifiez si default.php existe
    if (file_exists($defaultFilePath)) {
        // Vérifier si l'utilisateur a accès au site
        if (!isset($_SESSION['site_access_granted']) || $_SESSION['site_access_granted'] !== true) {
            header('Location: /app/authentification');
            exit();
        }
    }

    // Vérifier si l'utilisateur est connecté et administrateur
    $isAdmin = isset($_SESSION['user_logged_in']) && $_SESSION['user_type'] == 'administrateur';

    // Inclusion du header
    include 'parts/header.php';
    
    // Inclusion du contrôleur des associations par thème
    require_once BASE_PATH . '/app/controller/AssociationsController.php';
    $controller = new AssociationsController();
    $associations = $controller->getAssociationsByTheme('sports');    
?>

<body class="sports">
    <?php include 'parts/annuaire_associations.php'; ?>
    <link rel="stylesheet" href="/public/css/associations_style.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/associations_style.css'); ?>">
    <link rel="stylesheet" href="/public/css/dropdown_style.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/dropdown_style.css'); ?>">

    <script src="/public/js/annuaire_associations.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/js/annuaire_associations.js'); ?>"></script>
<?php
    // Inclusion du footer
    include 'parts/footer.php';
?>
</body>