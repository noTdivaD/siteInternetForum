<?php
    // Titre de la page
    $pageTitle = "Accueil - Forum du Pays de Grasse";
    $currentPage = "Accueil";

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
<div class=container>
<div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <h2>Journée FORUM</h2>
                <div class="content">
                    <img src="../../public/images/FacebookLogo.png" alt="Facebook">
                    <p> texte texte texte texte texte texte texte texte texte texte</p>
                </div>
                <a href="#">En savoir plus</a>
            </div>
            <div class="swiper-slide">
                <h2>Annuaire des associations</h2>
                <div class="content">
                    <img src="../../public/images/FacebookLogo.png" alt="Facebook">
                    <p> texte texte texte texte texte texte texte texte texte texte</p>
                </div>
                <a href="#">En savoir plus</a>
            </div>
            <div class="swiper-slide">
                <h2>Rencontres associatives</h2>
                <div class="content">
                    <img src="../../public/images/FacebookLogo.png" alt="Facebook">
                    <p> texte texte texte texte texte texte texte texte texte texte</p>
                </div>
                <a href="#">En savoir plus</a>
            </div>  
            <div class="swiper-slide">
                <h2>Conférences</h2>
                <div class="content">
                    <img src="../../public/images/FacebookLogo.png" alt="Facebook">
                    <p> texte texte texte texte texte texte texte texte texte texte</p>
                </div>
                <a href="#">En savoir plus</a>
            </div>  
            <div class="swiper-slide">
                <h2>Site internet et Facebook</h2>
                <div class="content">
                    <img src="../../public/images/FacebookLogo.png" alt="Facebook">
                    <p> texte texte texte texte texte texte texte texte texte texte</p>
                </div>
                <a href="#">En savoir plus</a>
            </div>  
            <div class="swiper-slide">
                <h2>Manifestations ponctuelles, sorties associatives</h2>
                <div class="content">
                    <img src="../../public/images/FacebookLogo.png" alt="Facebook">
                    <p> texte texte texte texte texte texte texte texte texte texte</p>
                </div>
                <a href="#">En savoir plus</a>
            </div>  
            <div class="swiper-slide">
                <h2>Annuaire des associations</h2>
                <div class="content">
                    <img src="../../public/images/FacebookLogo.png" alt="Facebook">
                    <p> texte texte texte texte texte texte texte texte texte texte</p>
                </div>
                <a href="#">En savoir plus</a>
            </div>  
            <div class="swiper-slide">
                <h2>Collège d'experts</h2>
                <div class="content">
                    <img src="../../public/images/FacebookLogo.png" alt="Facebook">
                    <p> texte texte texte texte texte texte texte texte texte texte</p>
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
            echo '<div class="article" data-article-id="' . $article['id'] . '">';
            echo '<h2>' . htmlspecialchars($article['title']) . '</h2>';
            echo '<div class="article-content">' . nl2br(htmlspecialchars($article['content'])) . '</div>';
            if (!empty($article['image_url'])) {
                echo '<img src="' . htmlspecialchars($article['image_url']) . '" alt="Image de l\'article">';
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
                    <label for="image">Image (optionnelle):</label>
                    <input type="file" id="image" name="image">
                </div>
                <button type="submit" class="add-article-btn">Ajouter</button>
            </form>
        </div>
    </div>
<?php endif; ?>

<link rel="stylesheet" href="/public/css/style_accueil_upgrade.css">
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="/public/js/accueil_upgrade.js"></script>
<?php
    // Inclusion du footer
    require_once BASE_PATH . '/app/view/parts/footer.php';
?>


