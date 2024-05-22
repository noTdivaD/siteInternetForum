<?php
// Titre de la page
$pageTitle = "Accueil - Forum du Pays de Grasse";
$currentPage = "Accueil";

// Vérifier si l'utilisateur a accès au site
if (!isset($_SESSION['site_access_granted']) || $_SESSION['site_access_granted'] !== true) {
    header('Location: /app/authentification');
    exit();
}

// Inclusion du header
require_once BASE_PATH . '/app/view/parts/header.php';

// Chargement du contrôleur et des articles
require_once BASE_PATH . '/app/controller/AccueilController.php';
$accueilController = new AccueilController();
$articles = $accueilController->displayPage();

// Déterminer si l'utilisateur est un administrateur
$isAdmin = isset($_SESSION['user_logged_in']) && $_SESSION['user_type'] == 'administrateur';
?>

<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
<div class="main-content">
<div class=container>
<div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <h2>Journée FORUM</h2>
                <div class="content">
                    <img src="/public/images/imagesForum/1.JPG" alt="Facebook">
                    <p>Venez découvrir les diverses associations locales, rencontrer les membres et participer à des activités passionnantes. C'est une occasion parfaite pour en apprendre davantage sur les initiatives locales et peut-être même rejoindre une association qui vous tient à cœur.</p>
                </div>
                <a href="#">En savoir plus</a>
            </div>
            <div class="swiper-slide">
                <h2>Annuaire des associations</h2>
                <div class="content">
                    <img src="/public/images/imagesForum/2.JPG" alt="Facebook">
                    <p>Placeholder de la description</p>
                </div>
                <a href="#">En savoir plus</a>
            </div>
            <div class="swiper-slide">
                <h2>Rencontres associatives</h2>
                <div class="content">
                    <img src="/public/images/imagesForum/3.JPG" alt="Facebook">
                    <p>Placeholder de la description</p>
                </div>
                <a href="#">En savoir plus</a>
            </div>  
            <div class="swiper-slide">
                <h2>Conférences</h2>
                <div class="content">
                    <img src="/public/images/imagesForum/1.JPG" alt="Facebook">
                    <p>Placeholder de la description</p>
                </div>
                <a href="#">En savoir plus</a>
            </div>  
            <div class="swiper-slide">
                <h2>Site internet et Facebook</h2>
                <div class="content">
                    <img src="/public/images/imagesForum/2.JPG" alt="Facebook">
                    <p>Placeholder de la description</p>
                </div>
                <a href="#">En savoir plus</a>
            </div>  
            <div class="swiper-slide">
                <h2>Manifestations ponctuelles, sorties associatives</h2>
                <div class="content">
                    <img src="/public/images/imagesForum/3.JPG" alt="Facebook">
                    <p>Placeholder de la description</p>
                </div>
                <a href="#">En savoir plus</a>
            </div>  
            <div class="swiper-slide">
                <h2>Annuaire des associations</h2>
                <div class="content">
                    <img src="/public/images/imagesForum/1.JPG" alt="Facebook">
                    <p>Placeholder de la description</p>
                </div>
                <a href="#">En savoir plus</a>
            </div>  
            <div class="swiper-slide">
                <h2>Collège d'experts</h2>
                <div class="content">
                    <img src="/public/images/imagesForum/2.JPG" alt="Facebook">
                    <p>Placeholder de la description</p>
                </div>
                <a href="#">En savoir plus</a>
            </div>  
        </div>
        <div class="swiper-pagination"></div>
        <div class="swiper-button-prev"></div>
        <div class="swiper-button-next"></div>
    </div>



    <div class="article-section">
        <?php
        if (isset($articles) && is_array($articles)) { // Assurez-vous que les articles existent et forment un tableau
            foreach ($articles as $article) {
                echo '<div class="article" data-article-id="' . htmlspecialchars($article['id'], ENT_QUOTES, 'UTF-8') . '">';
                echo '<h2>' . html_entity_decode($article['title'], ENT_QUOTES, 'UTF-8') . '</h2>';
                echo '<div class="article-content">' . nl2br(html_entity_decode($article['content'], ENT_QUOTES, 'UTF-8')) . '</div>';
                if (!empty($article['image_url'])) {
                    echo '<img src="' . htmlspecialchars($article['image_url'], ENT_QUOTES, 'UTF-8') . '" alt="Image de l\'article">';
                }
                if ($isAdmin) {
                    echo '<div class="article-controls">';
                    echo '<button class="edit-article-btn">Éditer</button>';
                    echo '<button class="delete-article-btn">Supprimer</button>';
                    echo '</div>';
                }
                echo '</div>';
            }
        } else {
            echo '<p>Aucun article disponible pour le moment.</p>';
        }
        ?>

        <?php if ($isAdmin): ?>
            <div style="text-align: center; margin-top: 20px;">
                <button class="add-article-btn">Ajouter un article</button>
            </div>
        <?php endif; ?>
    </div>

    <?php if ($isAdmin): ?>
        <!-- Modale Ajout Article -->
        <div id="addArticleModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Ajouter un article</h2>
                <form id="addArticleForm">
                    <div id="error_message" style="text-align: center; margin-bottom: 10px; color: red;"></div>
                    <div class="form-group">
                        <label for="title">Titre de l'article:</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="content">Contenu de l'article:</label>
                        <textarea id="content" name="content" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="add-image">Image (optionnelle):</label>
                        <div id="drop-zone-add" class="drop-zone">
                            <span class="drop-zone__prompt">Sélectionnez ou Déposer votre Fichier Ici</span>
                            <input type="file" id="add-image" name="image" class="drop-zone__input">
                        </div>
                    </div>      
                    <button type="submit" class="add-article-btn">Ajouter</button>
                </form>
            </div>
        </div>

        <!-- Modale Editer Article -->
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
    <?php endif; ?>
</div>

<link rel="stylesheet" href="/public/css/style_accueil_upgrade.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/style_accueil_upgrade.css'); ?>">
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="/public/js/accueil_upgrade.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/js/accueil_upgrade.js'); ?>"></script>
<?php
// Inclusion du footer
require_once BASE_PATH . '/app/view/parts/footer.php';
?>
