<?php
    // Titre de la page
    $pageTitle = "Journée FORUM - Forum du Pays de Grasse";
    $currentPage = "Journée FORUM";

    // Vérifier si l'utilisateur a accès au site
    if (!isset($_SESSION['site_access_granted']) || $_SESSION['site_access_granted'] !== true) {
        header('Location: /app/authentification');
        exit();
    }

    // Inclusion du header
    include 'parts/header.php';

    $isAdmin = isset($_SESSION['user_logged_in']) && $_SESSION['user_type'] == 'administrateur';
?>

<link
  rel="stylesheet"
  href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css"
/>

<div class="container">
        <div class="text">
            <h1>Rejoignez-nous pour la Journée Forum</h1>
            <p>La <span class="date">Journée Forum</span> est un événement annuel incontournable à Grasse. Cette année, il se tiendra le <span class="date">Samedi 14 Septembre</span> à la <span class="location">Cours Honoré Cresp</span>.</p>
            <p>Venez découvrir les diverses associations locales, rencontrer les membres et participer à des activités passionnantes. C'est une occasion parfaite pour en apprendre davantage sur les initiatives locales et peut-être même rejoindre une association qui vous tient à cœur.</p>
            <a href="#" class="btn">Bulletins d'inscription</a>
            <?php if ($isAdmin) : ?>
                <a href="#" class="btn" id="manageRegistrationsBtn">Modifier le contenu</a>
            <?php endif; ?>
        </div>
        <div class="swiper mySwiper">
            <div class="swiper-wrapper">
                <div class="swiper-slide"><img src="/public/images/imagesForum/1.JPG" alt="Image 1"></div>
                <div class="swiper-slide"><img src="/public/images/imagesForum/2.JPG" alt="Image 2"></div>
                <div class="swiper-slide"><img src="/public/images/imagesForum/3.JPG" alt="Image 3"></div>
            </div>  
            <div class="swiper-pagination"></div>
        </div>
</div>

<div id="editArticleModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Éditer la page</h2>
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
                <label for="edit-image">Image (optionnelle):</label>
                <div id="drop-zone-edit" class="drop-zone">
                    <span class="drop-zone__prompt">Sélectionnez ou Déposer votre Fichier Ici</span>
                    <input type="file" id="edit-image" name="image" class="drop-zone__input" disabled>
                </div>
            </div>
            <div class="form-group" id="delete-image-container" style="display: none;">
                <label for="delete-image">
                    <input type="checkbox" id="delete-image" name="delete_image">
                    Supprimer l'image existante
                </label>
            </div>      
            <button type="submit" class="edit-article-btn">Modifier</button>
        </form>
    </div>
</div>

<link rel="stylesheet" href="/public/css/journee_forum_style.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/journee_forum_style.css'); ?>">
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="/public/js/journee_forum.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/js/journee_forum.js'); ?>"></script>

<?php
    // Inclusion du footer
    include 'parts/footer.php';
?>
