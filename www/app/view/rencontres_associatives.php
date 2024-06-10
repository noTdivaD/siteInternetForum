<?php
$pageTitle = "Rencontres Associatives - Forum du Pays de Grasse";
$currentPage = "Rencontres Associatives";

if (!isset($_SESSION['site_access_granted']) || $_SESSION['site_access_granted'] !== true) {
    header('Location: /app/authentification');
    exit();
}

include 'parts/header.php';

require_once BASE_PATH . '/app/controller/RencontreController.php';
$rencontreController = new RencontreController();
$content = $rencontreController->getContent();
$association = $rencontreController->getAssociation();
$associations = $rencontreController->getAll();

$isAdmin = isset($_SESSION['user_logged_in']) && $_SESSION['user_type'] == 'administrateur';
var_dump($_POST)
?>

<div class="main-content">
    <?php foreach ($content as $contents): ?>
        <div class="container">
            <div class="text">
                <h1 class="title" data-title="<?php echo htmlspecialchars($contents['title'], ENT_QUOTES, 'UTF-8'); ?>">
                    <?php echo nl2br(htmlspecialchars_decode($contents['title'], ENT_QUOTES)); ?>
                </h1>
                <p class="content-top" data-text-top="<?php echo htmlspecialchars($contents['text_top'], ENT_QUOTES, 'UTF-8'); ?>">
                    <?php echo nl2br(htmlspecialchars_decode($contents['text_top'], ENT_QUOTES)); ?>
                </p>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="association-container">
            <?php foreach ($association as $associationaffiche): ?>
                <div class="association-item">
                <h2>Association mise à l'honneur cette semaine</h2>
                    <h2><?= htmlspecialchars($associationaffiche['nom'], ENT_QUOTES, 'UTF-8') ?></h2>
                    <table>
                        <tr>
                            <th>Domaine(s)</th>
                            <th>Thèmes</th>
                        </tr>
                        <tr>
                            <td class="domaines"><?= htmlspecialchars($associationaffiche['domaine'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="themes"><?= htmlspecialchars($associationaffiche['themes'], ENT_QUOTES, 'UTF-8') ?></td>
                        </rd>
                    </table>
                    <table>
                        <tr>
                            <th>Adresse</th>
                            <th>Téléphone</th>
                            <th>Email</th>
                            <th>Date de création</th>
                        </tr>
                        <tr>
                            <td class="address"><?= htmlspecialchars($associationaffiche['adresse'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="phone"><?= htmlspecialchars($associationaffiche['telephone'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="mail"><?= htmlspecialchars($associationaffiche['email'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td class="creationdate"><?= date('Y', strtotime($associationaffiche['date_creation'])) ?> </td>
                        </tr>
                    </table>
                    <?php if (!empty($associationaffiche['site_web'])): ?>
                        <?php
                            $url = $associationaffiche['site_web'];
                            // Vérifie si l'URL commence par "http://" ou "https://"
                            if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                                // Si ce n'est pas le cas, ajoute "http://" au début de l'URL
                                $url = "http://" . $url;
                            }
                        ?>
                        <a href="<?= htmlspecialchars($url, ENT_QUOTES, 'UTF-8') ?>" target="_blank">Visiter leur site</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>

    <?php foreach ($content as $contents): ?>
        <div class="container">
            <div class="text">
                <p class="content-bottom" data-text-bottom="<?php echo htmlspecialchars($contents['text_bottom'], ENT_QUOTES, 'UTF-8'); ?>">
                    <?php echo nl2br(htmlspecialchars_decode($contents['text_bottom'], ENT_QUOTES)); ?>
                </p>
                <?php if ($isAdmin): ?>
                    <button class="btn edit-association-btn">Modifier l'association</button>
                <?php endif; ?>
                <?php if ($isAdmin): ?>
                    <button class="btn edit-article-btn">Modifier le contenu de la page</button>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
    
    <?php if ($isAdmin): ?>
        <div id="editAssociationModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form id="editAssociationForm" action="app/controller/RencontreController.php" method="post" enctype="multipart/form-data">
                    <label for="association-select">Sélectionnez une association:</label>
                    <select id="association-select" name="association_id" required>
                        <?php foreach ($associations as $association): ?>
                            <option value="<?php echo $association['id']; ?>"><?php echo $association['nom']; ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button type="submit">Enregistrer les modifications</button>
                </form>
            </div>
        </div>
    <?php endif; ?>

    <?php if ($isAdmin): ?>
        <div id="editArticleModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <form id="editArticleForm">
                    <input type="hidden" id="edit-article-id" name="article_id">
                    <div>
                        <label for="edit-title">Titre</label>
                        <input type="text" id="edit-title" name="title" required>
                    </div>
                    <div>
                        <label for="edit-content-top">Contenu Haut</label>
                        <textarea id="edit-content-top" name="content_top" required></textarea>
                    </div>
                    <div>
                        <label for="edit-content-bottom">Contenu Bas</label>
                        <textarea id="edit-content-bottom" name="content_bottom" required></textarea>
                    </div>
                    <div id="edit_error_message" style="color: red;"></div>
                    <button type="submit">Enregistrer les modifications</button>
                </form>
            </div>
        </div>
    <?php endif; ?>
</div>

<link rel="stylesheet" href="/public/css/rencontre_style.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/rencontre_style.css'); ?>">
<script src="/public/js/rencontres_associatives.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/js/rencontres_associatives.js'); ?>"></script>

<?php
include 'parts/footer.php';
?>
