<?php
// Titre de la page
$pageTitle = "Annuaire des associations - Forum du Pays de Grasse";
$currentPage = "Annuaire des associations";

// Vérifier si l'utilisateur a accès au site
if (!isset($_SESSION['site_access_granted']) || $_SESSION['site_access_granted'] !== true) {
    header('Location: /app/authentification');
    exit();
}

/*
// Vérifier si l'utilisateur est connecté et administrateur
$isAdmin = isset($_SESSION['user_logged_in']) && $_SESSION['user_type'] == 'administrateur'; */

// Inclusion du header
include 'parts/header.php';

// Récupérer les thèmes via le contrôleur
require_once BASE_PATH . '/app/controller/AnnuaireController.php';
$controller = new AnnuaireController();
$themes = $controller->displayPage();
?>

<div class="main-content">
    <div class="annuaire-container">   
        <h1>Annuaire des associations</h1>

        <?php if ($themes): ?>
            <?php foreach ($themes as $theme): 
                $rgbColor = "rgb(" . htmlspecialchars($theme['color_r']) . "," . htmlspecialchars($theme['color_g']) . "," . htmlspecialchars($theme['color_b']) . ")";
                $hoverColor = "rgba(" . htmlspecialchars($theme['color_r']) . "," . htmlspecialchars($theme['color_g']) . "," . htmlspecialchars($theme['color_b']) . ", 0.2)";
            ?>
                <div class="thematique <?php echo htmlspecialchars($theme['slug']); ?>" onclick="redirectToLink('/app/associations_<?php echo htmlspecialchars($theme['slug']); ?>')"
                     style="background-image: url('<?php echo htmlspecialchars($theme['image_url']); ?>'); background-color: <?php echo $rgbColor; ?>;">
                    <h2><?php echo htmlspecialchars($theme['title']); ?></h2>
                </div>
                <style>
                    .<?php echo htmlspecialchars($theme['slug']); ?>:hover::after {
                        background-color: <?php echo $hoverColor; ?>;
                    }
                </style>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Aucun thème disponible pour le moment.</p>
        <?php endif; ?>
        
        <!--
        </* ?php if ($isAdmin): ?>
            <div class="add-theme-button-container">
                <button class="add-theme-button" onclick="openAddThemeModal()">Ajouter un thème d'associations</button>
            </div>
        </* ?php endif; ?> -->
    </div>
</div>    

<!-- 
<div id="addThemeModal" class="modal">
    <div class="modal-content">
        <span class="close" onclick="closeAddThemeModal()">&times;</span>
        <h2>Ajouter un thème d'associations</h2>
        <form id="addThemeForm">
            <div id="error_message" style="text-align: center; margin-bottom: 10px; color: red;"></div>
            <div class="form-group">
                <label for="themeTitle">Titre du thème:</label>
                <input type="text" id="themeTitle" name="themeTitle" required>
            </div>
            <div class="form-group">
                <label for="themeImage">Image du thème:</label>
                <div id="drop-zone-theme" class="drop-zone">
                    <span class="drop-zone__prompt">Sélectionnez ou Déposez votre Fichier Ici</span>
                    <input type="file" id="themeImage" name="themeImage" class="drop-zone__input" required>
                </div>
            </div>
            <div class="form-group">
                <label for="themeColor">Couleur du thème:</label>
                <input type="color" id="themeColor" name="themeColor" required disabled>
                <button type="button" id="pipetteButton" class="pipette-btn" disabled>Choisir une couleur à partir de l'image sélectionnée ▷</button>
            </div>
            <canvas id="imageCanvas" style="display:none;"></canvas>
            <button type="submit" class="add-theme-btn">Ajouter</button>
        </form>
    </div>
</div> -->

<link rel="stylesheet" href="/public/css/annuaire_style.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/annuaire_style.css'); ?>">
<script src="/public/js/annuaire.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/js/annuaire.js'); ?>"></script>
<?php
// Inclusion du footer
include 'parts/footer.php';
?>
