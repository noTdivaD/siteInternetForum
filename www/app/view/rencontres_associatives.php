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
?>

<div class="main-content">
    <?php foreach ($content as $contents): ?>
        <div class="container">
            <div class="text">
                <h1 data-title="<?php echo htmlspecialchars($contents['titre'], ENT_QUOTES, 'UTF-8'); ?>">
                    <?php echo nl2br(htmlspecialchars_decode($contents['titre'], ENT_QUOTES)); ?>
                </h1>
                <p data-text-top="<?php echo htmlspecialchars($contents['text_top'], ENT_QUOTES, 'UTF-8'); ?>">
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
                <p data-text-bottom="<?php echo htmlspecialchars($contents['text_bottom'], ENT_QUOTES, 'UTF-8'); ?>">
                    <?php echo nl2br(htmlspecialchars_decode($contents['text_bottom'], ENT_QUOTES)); ?>
                </p>
                <?php if ($isAdmin): ?>
                    <button class="btn edit-article-btn">Modifier le contenu de la page</button>
                <?php endif; ?>
            </div>
        </div>
    <?php endforeach; ?>
    
    <?php if ($isAdmin): ?>
        <div id="editArticleModal" class="modal">
            <div class="modal-content">
                <span class="close">&times;</span>
                <h2>Éditer l'association mise en valeur</h2>
                <form id="editArticleForm" action="/update_association.php" method="POST">
                    <input type="hidden" id="edit-article-id" name="article_id">
                    <div id="edit_error_message" style="text-align: center; margin-bottom: 10px; color: red;"></div>
                    <div class="form-group">
                        <label for="edit-association">Association mise en valeur:</label>
                        <select id="edit-association" name="association">
                            <?php foreach ($associations as $association): ?>
                                <option value="<?= htmlspecialchars($association['id'], ENT_QUOTES, 'UTF-8') ?>">
                                    <?= htmlspecialchars($association['nom'], ENT_QUOTES, 'UTF-8') ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="edit-title">Titre de l'article:</label>
                        <input type="text" id="edit-title" name="title" required>
                    </div>
                    <div class="form-group">
                        <label for="edit-content-top">Contenu de l'article (haut):</label>
                        <textarea id="edit-content-top" name="content_top" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="edit-content-bottom">Contenu de l'article (bas):</label>
                        <textarea id="edit-content-bottom" name="content_bottom" required></textarea>
                    </div>
                    <button type="submit" class="btn">Enregistrer</button>
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
