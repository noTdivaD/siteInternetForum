<?php
// Titre de la page
$pageTitle = "Collège d'Experts - Forum du Pays de Grasse";
$currentPage = "Collège d'Experts";

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

<script>
    var isAdmin = <?php echo json_encode($isAdmin); ?>;
</script>

<div class="main-content">
    <div class="content-wrapper">
        <div class="text-section">
            <h1>Collège d'Experts</h1>
            <p>Une page pour vous aider à créer et à développer votre propre association sous forme de FAQ.</p>
            <p>Pleins de questions générales et de réponses !</p>
        </div>
        <div class="faq-section">
            <h2>FAQ</h2>
            <div class="faq-search-container">
                <input type="text" id="faq-search" placeholder="Poser votre question" class="faq-search">
            </div>
            <div id="no-results-message" class="no-results" style="display: none;">Aucun résultat à votre question</div>
            <div id="faq-items">
                <?php foreach ($faqs as $faq): ?>
                <div class="faq-item">
                    <h3><?php echo htmlspecialchars($faq['question']); ?></h3>
                    <p><?php echo htmlspecialchars($faq['answer']); ?></p>
                    <?php if ($isAdmin) { ?>
                        <button class="btn-edit-faq" data-id="<?php echo $faq['id']; ?>">Modifier</button>
                        <button class="btn-delete-faq" data-id="<?php echo $faq['id']; ?>">Supprimer</button>
                    <?php } ?>
                </div>
                <?php endforeach; ?>
            </div>
            <?php if ($isAdmin) { ?>
                <button class="btn-add-faq">Ajouter une question/réponse</button>
            <?php } ?>
        </div>
        <div class="expert-section" id="expert-section">
        <h2>Nos Experts</h2>
        <?php foreach ($experts as $expert): ?>
        <div class="expert" data-id="<?php echo htmlspecialchars($expert['id']); ?>"> <!-- Add data-id attribute -->
            <h3><?php echo htmlspecialchars($expert['titre']); ?></h3>
            <?php if (!empty($expert['image_url'])): ?>
            <img src="<?php echo htmlspecialchars($expert['image_url']); ?>" alt="Expert Image" class="expert-image">
            <?php endif; ?>
            <p class="description"><?php echo htmlspecialchars($expert['description']); ?></p>
            <p class="phone">Numéro de téléphone : <?php echo htmlspecialchars($expert['phone']); ?></p>
            <p class="email">Email : <?php echo htmlspecialchars($expert['email']); ?></p>
            <?php if ($isAdmin) { ?>
                <button class="btn-edit-expert" data-id="<?php echo $expert['id']; ?>">Modifier</button>
                <button class="btn-delete-expert" data-id="<?php echo $expert['id']; ?>">Supprimer</button>
            <?php } ?>
        </div>
        <?php endforeach; ?>
        <?php if ($isAdmin) { ?>
            <button class="btn-add-expert">Ajouter un expert</button>
        <?php } ?>
    </div>

    <?php if ($isAdmin): ?>

        <!-- Modale Ajout FAQ-->
        <div id="addFAQModal" class="modal" enctype="multipart/form-data">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Ajouter une Question/Réponse</h2>
                <form id="addFAQForm">
                    <div id="error_message" style="text-align: center; margin-bottom: 10px; color: red;"></div>
                    <div class="form-group">
                        <label for="question">Titre de la question :</label>
                        <input type="text" id="question" name="question" required>
                    </div>
                    <div class="form-group">
                        <label for="answer">Réponse à la question :</label>
                        <textarea id="answer" name="answer" required></textarea>
                    </div>
                    <button type="submit" class="add-faq-btn">Ajouter</button>
                </form>
            </div>
        </div>

        <!-- Modale Editer FAQ-->
        <div id="editFAQModal" class="modal" enctype="multipart/form-data">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Éditer une Question/Réponse</h2>
                <form id="editFAQForm">
                    <input type="hidden" id="edit-faq-id" name="faq_id">
                    <div id="edit_error_message" style="text-align: center; margin-bottom: 10px; color: red;"></div>
                    <div class="form-group">
                        <label for="edit-question">Titre de la Question :</label>
                        <input type="text" id="edit-question" name="question" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-answer">Réponse à la Question :</label>
                        <textarea id="edit-answer" name="answer" required></textarea>
                    </div>
                    <button type="submit" class="edit-faq-btn">Modifier</button>
                </form>
            </div>
        </div>

        <!-- Modale Ajout Expert-->
        <div id="addExpertModal" class="modal" enctype="multipart/form-data">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Ajouter un Expert</h2>
                <form id="addExpertForm">
                    <div id="error_message" style="text-align: center; margin-bottom: 10px; color: red;"></div>
                    <div class="form-group">
                        <label for="title">Titre de l'expert :</label>
                        <input type="text" id="title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description de l'expert :</label>
                        <textarea id="description" name="description" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="add-image">Image (optionnelle) :</label>
                        <div id="drop-zone-add" class="drop-zone">
                            <span class="drop-zone__prompt">Sélectionnez ou Déposer votre Fichier Ici</span>
                            <input type="file" id="add-image" name="image" class="drop-zone__input">
                        </div>
                    </div>
                    <!-- Formulaire de contact -->
                    <div class="form-group">
                        <label for="phone">Numéro de téléphone :</label>
                        <input type="text" id="phone" name="phone" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Adresse email :</label>
                        <input type="email" id="email" name="email" required>
                    </div>
                    <button type="submit" class="add-expert-btn">Ajouter</button>
                </form>
            </div>
        </div>

        <!-- Modale Editer Expert -->
    <div id="editExpertModal" class="modal" enctype="multipart/form-data">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Éditer un Expert</h2>
            <form id="editExpertForm">
                <input type="hidden" id="edit-expert-id" name="expert_id">
                <input type="hidden" id="existing-image-url" name="existing_image_url">
                <div id="edit_error_message" style="text-align: center; margin-bottom: 10px; color: red;"></div>
                <div class="form-group">
                    <label for="edit-title">Titre de l'expert :</label>
                    <input type="text" id="edit-title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="edit-description">Description de l'expert :</label>
                    <textarea id="edit-description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="edit-image">Image (optionnelle) :</label>
                    <div id="drop-zone-edit" class="drop-zone">
                        <span class="drop-zone__prompt">Sélectionnez ou Déposer votre Fichier Ici</span>
                        <input type="file" id="edit-image" name="image" class="drop-zone__input" disabled>
                    </div>
                </div>
                <div class="form-group-checkbox" id="delete-image-container" style="display: none;">
                    <label for="delete-image">
                        <input type="checkbox" id="delete-image" name="delete_image">
                        Supprimer l'image existante
                    </label>
                </div>
                <!-- Formulaire de contact -->
                <div class="form-group">
                    <label for="edit-phone">Numéro de téléphone :</label>
                    <input type="text" id="edit-phone" name="phone" required>
                </div>
                <div class="form-group">
                    <label for="edit-email">Adresse email :</label>
                    <input type="email" id="edit-email" name="email" required>
                </div>
                <button type="submit" class="edit-expert-btn">Modifier</button>
            </form>
        </div>
    </div>

    <?php endif; ?>
</div>

<link rel="stylesheet" href="/public/css/college_experts_style.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/college_experts_style.css'); ?>">
<script src="/public/js/college_experts.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/js/college_experts.js'); ?>"></script>

<?php
// Inclusion du footer
include 'parts/footer.php';
?>
