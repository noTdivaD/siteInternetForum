<?php
    // Titre de la page
    $pageTitle = "Associations économiques et de développement - Forum du Pays de Grasse";
    $currentPage = "Associations économiques et de développement";

    // Vérifier si l'utilisateur a accès au site
    if (!isset($_SESSION['site_access_granted']) || $_SESSION['site_access_granted'] !== true) {
        header('Location: /app/authentification');
        exit();
    }

    // Inclusion du header
    include 'parts/header.php';
    
    // Inclusion du contrôleur des associations d'animations et de loisir
    require_once BASE_PATH . '/app/controller/EconomieController.php';
    $controller = new EconomieController();
    $associations = $controller->displayPage();
?>

<body class="economie">
    <?php include 'parts/annuaire_associations.php'; ?>
    <link rel="stylesheet" href="/public/css/associations_style.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/associations_style.css'); ?>">
    <link rel="stylesheet" href="/public/css/dropdown_style.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/dropdown_style.css'); ?>">

    <script src="/public/js/annuaire_associations.js"></script>
<?php
    // Inclusion du footer
    include 'parts/footer.php';
?>
</body>
