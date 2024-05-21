<?php
    // Titre de la page
    $pageTitle = "Associations humanitaires, sociales civiques, et d'environnement - Forum du Pays de Grasse";
    $currentPage = "Associations humanitaires, sociales civiques, et d'environnement";
    // Inclusion du header
    include 'parts/header.php';
    
    // Inclusion du contrôleur des associations humanitaires
    require_once BASE_PATH . '/app/controller/HumanitaireController.php';
    $controller = new BienEtreController();
    $associations = $controller->displayPage();
?>

<?php include 'parts/annuaire_associations.php'; ?>

<link rel="stylesheet" href="../../public/css/associations_style.css">

<?php
// Inclusion du footer
    include 'parts/footer.php';
?>
