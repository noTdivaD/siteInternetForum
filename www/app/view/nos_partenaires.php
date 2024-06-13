<?php
// Titre de la page
$pageTitle = "Nos Partenaires - Forum du Pays de Grasse";
$currentPage = "Nos Partenaires";

// Vérifier si l'utilisateur a accès au site
if (!isset($_SESSION['site_access_granted']) || $_SESSION['site_access_granted'] !== true) {
    header('Location: /app/authentification');
    exit();
}

// Vérifier si l'utilisateur est connecté ou administrateur.
$isAdmin = isset($_SESSION['user_logged_in']) && $_SESSION['user_type'] == 'administrateur';

// Inclusion du header
include 'parts/header.php';
?>

<div class="main-content">
    <div class="content-wrapper">
        <div class="text-section">
            <h1>Nos Partenaires</h1>
            <?php echo $paragraphe; ?>
        </div>
        
        <div class="swiper-container">
            <div class="swiper-wrapper">
                <?php foreach ($partenaires as $partenaire): ?>
                    <div class="swiper-slide">
                        <div class="partner-item">
                            <h2><?php echo htmlspecialchars($partenaire['titre']); ?></h2>
                            <img src="<?php echo htmlspecialchars($partenaire['image_url']); ?>" alt="<?php echo htmlspecialchars($partenaire['nom']); ?>">
                            <p><?php echo htmlspecialchars($partenaire['nom']); ?></p>
                            <p class="description"><?php echo htmlspecialchars($partenaire['description']); ?></p>
                            <?php if ($isAdmin): ?>
                                <button class="btn-modify" data-id="<?php echo $partenaire['id']; ?>">Modifier</button>
                                <button class="btn-delete" data-id="<?php echo $partenaire['id']; ?>">Supprimer</button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
            <!-- Add Pagination -->
            <div class="swiper-pagination"></div>
        </div>

        <div class="button-section">
            <div class="contents">
                <?php if ($isAdmin): ?>
                    <button class="btn-add-association">Ajouter un partenaire</button>
                    <button class="btn-modify-paragraph">Modifier le paragraphe</button>
                <?php endif; ?>
                <p>© Association Pays de Grasse</p>
            </div>
        </div>
    </div>
</div>

<?php if ($isAdmin): ?>
    <!-- Modale Ajout Partenaire -->
<div id="addPartenaireModal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Ajouter un partenaire</h2>
        <form id="addPartenaireForm">
            <div id="error_message" style="text-align: center; margin-bottom: 10px; color: red;"></div>
            <div class="form-group">
                <label for="add-title">Titre du partenaire:</label>
                <input type="text" id="add-title" name="title" required>
            </div>
            <div class="form-group">
                <label for="add-nom">Nom du partenaire :</label>
                <input type="text" id="add-nom" name="nom" required>
            </div>
            <div class="form-group">
                <label for="add-description">Description du partenaire :</label>
                <textarea id="add-description" name="description" class="small-textarea" required></textarea>
            </div>
            <div class="form-group">
                <label for="add-image">Image Partenaire:</label>
                <div id="drop-zone-add" class="drop-zone">
                    <span class="drop-zone__prompt">Sélectionnez ou Déposer votre Fichier Ici</span>
                    <input type="file" id="add-image" name="image" class="drop-zone__input">
                </div>
            </div>      
            <button type="submit" class="add-article-btn">Ajouter</button>
        </form>
    </div>
</div>

    <!-- Modale Editer Paragraphe -->
    <div id="editParagraphModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Éditer un paragraphe</h2>
            <form id="editParagraphForm">
                <input type="hidden" id="edit-paragraph-id" name="paragraph_id">
                <div id="error_message" style="text-align: center; margin-bottom: 10px; color: red;"></div>
                <div class="form-group">
                    <label for="edit-content">Contenu du paragraphe:</label>
                    <textarea id="edit-content" name="content" required style="white-space: pre-wrap;"></textarea>
                </div>
                <button type="submit" class="edit-article-btn">Modifier</button>
            </form>
        </div>
    </div>

    <!-- Modale Edition Partenaire-->
    <div id="editPartenaireModal" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Éditer un partenaire</h2>
            <form id="editPartenaireForm">
                <div id="error_message" style="text-align: center; margin-bottom: 10px; color: red;"></div>
                <div class="form-group">
                    <label for="edit-title">Titre du partenaire:</label>
                    <input type="text" id="edit-title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="edit-nom">Nom du partenaire :</label>
                    <input type="text" id="edit-nom" name="nom" required>
                </div>
                <div class="form-group">
                    <label for="edit-description">Description du partenaire :</label>
                    <textarea id="edit-description" name="description" class="small-textarea" required></textarea>
                </div>
                <div class="form-group">
                    <label for="edit-image">Image Partenaire:</label>
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

<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<link rel="stylesheet" href="/public/css/nos_partenaires_style.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/nos_partenaires_style.css'); ?>">
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"></script>
<script src="/public/js/nos_partenaires.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/js/nos_partenaires.js'); ?>"></script>

<?php
// Inclusion du footer
include 'parts/footer.php';
?>
