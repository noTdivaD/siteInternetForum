<?php
$pageTitle = "Journée FORUM - Forum du Pays de Grasse";
$currentPage = "Journée FORUM";

if (!isset($_SESSION['site_access_granted']) || $_SESSION['site_access_granted'] !== true) {
    header('Location: /app/authentification');
    exit();
}

include 'parts/header.php';

require_once BASE_PATH . '/app/controller/JourneeForumController.php';
$journeeForumController = new JourneeForumController();
$article = $journeeForumController->displayPage();

$isAdmin = isset($_SESSION['user_logged_in']) && $_SESSION['user_type'] == 'administrateur';
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"/>
<div class="main-content">
    <div class="container">
        <div class="text">
            <h1><?php echo htmlspecialchars_decode($article['titre']); ?></h1>
            <p><?php echo nl2br(htmlspecialchars_decode($article['contenu'])); ?></p>
            <a href="/app/inscription_journee_forum" class="btn-inscription">Bulletins d'inscription</a>
            <?php if ($isAdmin): ?>
                <button class="btn edit-article-btn">Modifier l'article</button>
            <?php endif; ?>
        </div>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <?php
                $images = json_decode($article['images'], true);
                if ($images && is_array($images)) {
                    foreach ($images as $image) {
                        // Ensure $image is a string
                        if (is_string($image)) {
                            echo '<div class="swiper-slide"><img src="' . htmlspecialchars($image) . '" alt="Image"></div>';
                        }
                    }
                } else {
                    echo 'Aucune image disponible.';
                }
                ?>
            </div>
            <div class="swiper-pagination"></div>
        </div>
    </div>

    <?php if ($isAdmin): ?>
        <div id="editArticleModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Éditer un article</h2>
                <form id="editArticleForm">
                    <input type="hidden" id="edit-article-id" name="article_id">
                    <div id="edit_error_message" style="text-align: center; margin-bottom: 10px; color: red;"></div>
                    <div class="form-group">
                        <label for="edit-title">Titre de l'article:</label>
                        <input type="text" id="edit-title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-content">Contenu de l'article:</label>
                        <textarea id="edit-content" name="content" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit-images">Images (optionnelles):</label>
                        <div id="images-container" class="images-container">
                            <div id="current-images" class="current-images"></div>
                            <button type="button" id="add-image-btn" class="add-image-btn">
                                <img src="/public/images/icones/plus.png" alt="Add Image">
                            </button>
                        </div>
                        <input type="file" id="add-image-input" name="images[]" style="display: none;" multiple>
                    </div>
                    <button type="submit" class="edit-article-btn">Modifier</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<link rel="stylesheet" href="/public/css/journee_forum_style.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/journee_forum_style.css'); ?>">
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="/public/js/journee_forum.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/js/journee_forum.js'); ?>"></script>

<?php
include 'parts/footer.php';
?>
