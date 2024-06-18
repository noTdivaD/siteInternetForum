<?php
    // Titre de la page
    $pageTitle = "Associations d'arts et de culture - Forum du Pays de Grasse";
    $currentPage = "Associations d'arts et de culture";

    // Chemin du fichier default.php
    $defaultFilePath = __DIR__ . '/view/default.php';

    // Vérifiez si default.php existe
    if (file_exists($defaultFilePath)) {
        // Vérifier si l'utilisateur a accès au site
        if (!isset($_SESSION['site_access_granted']) || $_SESSION['site_access_granted'] !== true) {
            header('Location: /app/authentification');
            exit();
        }
    }
        
    // Inclusion du header
    include 'parts/header.php';
    
    // Inclusion du contrôleur des associations d'arts et de culture
    require_once BASE_PATH . '/app/controller/ArtsCultureController.php';
    $controller = new ArtsCultureController();
    $associations = $controller->displayPage();
?>

<body class="arts-culture">
    <?php include 'parts/annuaire_associations.php'; ?>
    <link rel="stylesheet" href="/public/css/associations_style.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/associations_style.css'); ?>">
    <link rel="stylesheet" href="/public/css/dropdown_style.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/dropdown_style.css'); ?>">

    <script src="/public/js/annuaire_associations.js"></script>
<?php
    // Inclusion du footer
    include 'parts/footer.php';
?>
</body>