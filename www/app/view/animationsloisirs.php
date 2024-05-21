<?php
    // Titre de la page
    $pageTitle = "Associations d'animations et de loisirs - Forum du Pays de Grasse";
    $currentPage = "Associations d'animations et de loisirs";
    // Inclusion du header
    include 'parts/header.php';
    
    // Inclusion du contrôleur des associations d'animations et de loisir
    require_once BASE_PATH . '/app/controller/AnimationsLoisirsController.php';
    $controller = new AnimationsLoisirsController();
    $associations = $controller->displayPage();
?>

<?php include 'parts/annuaire_associations.php'; ?>

<link rel="stylesheet" href="../../public/css/associations_style.css">

<?php
// Inclusion du footer
    include 'parts/footer.php';
?>
