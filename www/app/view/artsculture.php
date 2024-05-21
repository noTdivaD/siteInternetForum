<?php
    // Titre de la page
    $pageTitle = "Associations d'arts et de culture - Forum du Pays de Grasse";
    $currentPage = "Associations d'arts et de culture";
    // Inclusion du header
    include 'parts/header.php';
    
    // Inclusion du contrôleur des associations d'arts et de culture
    require_once BASE_PATH . '/app/controller/ArtsCultureController.php';
    $controller = new ArtsCultureController();
    $associations = $controller->displayPage();
?>

<?php include 'parts/annuaire_associations.php'; ?>

<link rel="stylesheet" href="/public/css/associations_style.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/associations_style.css'); ?>">

<?php
// Inclusion du footer
    include 'parts/footer.php';
?>
