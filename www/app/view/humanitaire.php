<?php
    // Titre de la page
    $pageTitle = "Associations humanitaires, sociales civiques, et d'environnement - Forum du Pays de Grasse";
    $currentPage = "Associations humanitaires, sociales civiques, et d'environnement";

    // Vérifier si l'utilisateur a accès au site
    if (!isset($_SESSION['site_access_granted']) || $_SESSION['site_access_granted'] !== true) {
        header('Location: /app/authentification');
        exit();
    }

    // Inclusion du header
    include 'parts/header.php';
    
    // Inclusion du contrôleur des associations humanitaires
    require_once BASE_PATH . '/app/controller/HumanitaireController.php';
    $controller = new BienEtreController();
    $associations = $controller->displayPage();
?>

<body class="humanitaire">
    <?php include 'parts/annuaire_associations.php'; ?>
    <link rel="stylesheet" href="/public/css/associations_style.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/associations_style.css'); ?>">
    <link rel="stylesheet" href="/public/css/dropdown_style.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/dropdown_style.css'); ?>">

    <script src="/public/js/annuaire_associations.js"></script>
<?php
    // Inclusion du footer
    include 'parts/footer.php';
?>
</body>