<?php
// Titre de la page
$pageTitle = "Accueil - Forum du Pays de Grasse";
$currentPage = "Accueil";

// Chemin du fichier default.php
$defaultFilePath = __DIR__ . '/default.php';

// Vérifiez si default.php existe
if (file_exists($defaultFilePath)) {
    // Vérifier si l'utilisateur a accès au site
    if (!isset($_SESSION['site_access_granted']) || $_SESSION['site_access_granted'] !== true) {
        header('Location: /app/authentification');
        exit();
    }
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

    <div class="swiper-container">
        <div class="swiper-wrapper">
            <div class="swiper-slide">
                <h2>Journée FORUM</h2>
                <div class="content">
                    <img src="/public/images/imagesForum/journee_forum_stand_femmes.JPG" alt="Facebook">
                    <p>Le forum des associations est un événement annuel organisé par l'association FORUM chaque automne. Ce rassemblement permet aux adhérents et aux nouvelles associations de se faire connaître du grand public à travers des stands et des animations diverses. C'est une opportunité unique pour découvrir les associations locales, rencontrer leurs membres et participer à des activités passionnantes. Vous pourrez en apprendre davantage sur les initiatives locales et trouver l'association qui correspond à vos intérêts. Le forum des associations est l'occasion parfaite pour s'engager dans la vie associative de votre communauté.</p>
                </div>
                <a href="journee_forum">En savoir plus</a>
            </div>
            <div class="swiper-slide">
                <h2>Annuaire des associations</h2>
                <div class="content">
                    <img src="/public/images/imagesForum/journee_forum_stand_ordinateur.JPG" alt="Facebook">
                    <p>L'annuaire des associations est une ressource précieuse qui regroupe une liste étendue d'associations classées par différents thèmes et sujets. Conçu pour faciliter l'accès aux informations essentielles, cet annuaire permet de découvrir diverses organisations locales. Chaque entrée inclut des détails sur les activités, les coordonnées et les objectifs de l'association, offrant ainsi une vue d'ensemble complète pour ceux qui cherchent à s'informer ou à s'engager dans la vie associative de leur communauté. Que vous soyez intéressé par la culture, le sport, l'environnement ou toute autre cause, l'annuaire des associations vous aide à trouver l'organisation qui correspond à vos intérêts.</p>
                </div>
                <a href="annuaire_associations">En savoir plus</a>
            </div>
            <div class="swiper-slide">
                <h2>Rencontres associatives</h2>
                <div class="content">
                    <img src="/public/images/imagesForum/journee_forum_stand_CIDISol.JPG" alt="Facebook">
                    <p>Les Rencontres Associatives sont des événements hebdomadaires organisés tous les vendredis. Initialement tenues dans un bar, ces rencontres se déroulent désormais sous forme de pique-nique convivial. Chaque semaine, un représentant de différentes associations locales se réunit pour échanger et tisser des liens. Lors de ces rencontres, une association est mise à l'honneur, présentant ses objectifs, ses activités et ses projets. L'objectif principal est de favoriser les interactions et les collaborations entre les diverses associations de la région, enrichissant ainsi le tissu associatif local.</p>
                </div>
                <a href="rencontres_associatives">En savoir plus</a>
            </div>  
            <div class="swiper-slide">
                <h2>Collège d'Experts</h2>
                <div class="content">
                    <img src="/public/images/imagesForum/journee_forum_allee_principale.JPG" alt="Facebook">
                    <p>La page Collège d'Experts est dédiée à la mise en relation des associations avec des experts, qu'ils soient internes ou externes à notre organisation. Ce service vise à offrir un soutien précieux aux associations, en leur fournissant des conseils et des connaissances pratiques sur divers sujets essentiels. Que ce soit pour créer une association, remplir les documents nécessaires, développer un site web, ou apprendre à communiquer efficacement avec la presse, nos experts sont là pour vous guider. La page proposera des rubriques thématiques, semblables à une FAQ, pour répondre aux questions fréquentes et offrir des conseils structurés.</p>
                </div>
                <a href="college_experts">En savoir plus</a>
            </div>
            <div class="swiper-slide">
                <h2>Agenda des Associations</h2>
                <div class="content">
                    <img src="/public/images/imagesForum/journee_forum_homme_femme.JPG" alt="Facebook">
                    <p>Les agendas des associations constituent un calendrier complet référençant toutes les activités et événements organisés par les associations locales. Cette ressource permet de trier les événements par type d'association ainsi que par période, que ce soit par mois, par semaine, ou plus. Les agendas facilitent ainsi la planification et la participation aux diverses activités associatives. Que vous souhaitiez découvrir des événements culturels, sportifs, environnementaux ou autres, les agendas des associations vous offrent une vue d'ensemble pratique pour vous engager pleinement dans la vie associative de votre communauté.</p>
                </div>
                <a href="#">En savoir plus</a>
            </div>  
            <div class="swiper-slide">
                <h2>Flash Info et Informations Utiles</h2>
                <div class="content">
                    <img src="/public/images/imagesForum/journee_forum_stand_couvert.JPG" alt="Facebook">
                    <p>Cette section fournit des informations pratiques pour les résidents du Pays de Grasse. Découvrez la Recyclerie mobile du SMED, en partenariat avec Soli-Cités, qui récupère et transforme des objets réutilisables chaque mois dans les déchèteries locales. Les associations locales sont encouragées à participer au tri sélectif des déchets, recyclant plastiques, métaux, papiers, cartons et verre. Le dispositif "Cliiink" permet de cumuler des points en triant le verre, échangeables contre des réductions chez les commerçants partenaires. Des informations sur la SACEM expliquent les droits d'auteur et leur gestion, essentielle pour les créateurs. Cette rubrique aide à rester informé et engagé dans la vie locale.</p>
                </div>
                <a href="infos_utiles">En savoir plus</a>
            </div>
            <div class="swiper-slide">
                <h2>Site internet et Facebook</h2>
                <div class="content">
                    <img src="/public/images/imagesForum/journee_forum_stand_hommes.JPG" alt="Facebook">
                    <p>Le site internet et la page Facebook du Pays de Grasse sont des ressources essentielles pour rester informé sur les actualités locales, les événements et les initiatives communautaires. Sur le site, vous trouverez des informations détaillées sur les services municipaux, les projets en cours, et des outils pratiques pour les citoyens. La page Facebook, quant à elle, offre des mises à jour en temps réel, des annonces d'événements et des opportunités de participation. C'est une plateforme interactive où les résidents peuvent poser des questions, partager des idées et s'engager avec leur communauté. Suivez-nous en ligne pour ne rien manquer des activités et des nouvelles du Pays de Grasse.</p>
                </div>
                <a href="https://www.facebook.com/forum.grasse.paysdegrasse" target="new_blank">En savoir plus</a>
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
                echo '<div class="article-content">' . html_entity_decode($article['content'], ENT_QUOTES, 'UTF-8') . '</div>';
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

<link rel="stylesheet" href="/public/css/style_index.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/style_index.css'); ?>">
<script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
<script src="/public/js/index.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/js/index.js'); ?>"></script>
<?php
// Inclusion du footer
require_once BASE_PATH . '/app/view/parts/footer.php';
?>
