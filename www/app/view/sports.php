<?php
    // Titre de la page
    $pageTitle = "Associations sportives - Forum du Pays de Grasse";
    $currentPage = "Associations sportives";
    // Inclusion du header
    include 'parts/header.php';
    
    // Inclusion du contrôleur des associations sportives
    require_once BASE_PATH . '/app/controller/SportsController.php';
    $controller = new SportsController();
    $associations = $controller->displayPage();
?>

<?php include 'parts/annuaire_associations.php'; ?>

<link rel="stylesheet" href="../../public/css/associations_style.css">

<?php
// Inclusion du footer
    include 'parts/footer.php';
?>
