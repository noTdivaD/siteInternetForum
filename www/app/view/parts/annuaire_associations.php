<div class="main-content">
    <div class="association-section">
        <h1><?= $currentPage ?></h1>
        <a href="/app/annuaire_associations" class="back-to-directory">Retour à l'annuaire des associations</a>

        <!-- Barre de recherche -->
        <form id="search-form">
            <input type="text" id="search-input" placeholder="Rechercher par nom ou adresse">
            <button type="submit" id="search-button">Rechercher</button>
        </form>

        <div class="association-container">
            <?php if (!empty($associations) && is_array($associations)): ?>
                <?php foreach ($associations as $association): ?>
                    <div class="association-item">
                        <h2><?= htmlspecialchars($association['nom'], ENT_QUOTES, 'UTF-8') ?></h2>
                        <?php if (!empty($association['image'])): ?>
                            <img src="<?= htmlspecialchars($association['image'], ENT_QUOTES, 'UTF-8') ?>" alt="Logo de l'association">
                        <?php endif; ?>
                        <table>
                            <tr>
                                <th>Adresse</th>
                                <th>Téléphone</th>
                                <th>Email</th>
                                <th>Date de création</th>
                            </tr>
                            <tr>
                                <td class="address"><?= htmlspecialchars($association['adresse'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td class="phone"><?= htmlspecialchars($association['telephone'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td class="mail"><?= htmlspecialchars($association['email'], ENT_QUOTES, 'UTF-8') ?></td>
                                <td class="creationdate"><?= date('Y', strtotime($association['date_creation'])) ?></td>
                            </tr>
                        </table>
                        <?php if (!empty($association['site_web'])): ?>
                            <?php
                                $url = $association['site_web'];
                                if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
                                    $url = "http://" . $url;
                                }
                            ?>
                            <a href="<?= htmlspecialchars($url, ENT_QUOTES, 'UTF-8') ?>" target="_blank">Visiter le site</a>
                        <?php endif; ?>
                        
                        <?php if ($isAdmin): ?>
                            <div class="admin-buttons">
                                <button class="edit-button">Modifier</button>
                                <button class="delete-button">Supprimer</button>
                                <button class="visibility-button">
                                    <?= $association['visibilite'] == 'visible' ? 'Rendre invisible' : 'Rendre visible' ?>
                                </button>
                            </div>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>Aucune association trouvée pour ce thème.</p>
            <?php endif; ?>
        </div>
        <?php if ($isAdmin): ?>
            <div class="add-association-button">
                <button id="add-association-btn">Ajouter une association</button>
            </div>
        <?php endif; ?>
        <a href="#top" class="back-to-top">Haut de page</a>
    </div>
</div>


<!-- Modal pour ajouter une association -->
<div id="addAssociationModal" class="modal" style="display: none">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Ajouter une association</h2>
        <form id="addAssociationForm">
            <div class="form-group">
                <label for="add-name">Nom de l'association:</label>
                <input type="text" id="add-name" name="name" required>
            </div>
            <div class="form-group">
                <label for="add-address">Adresse:</label>
                <input type="text" id="add-address" name="address">
            </div>
            <div class="form-group">
                <label for="add-phone">Téléphone:</label>
                <input type="text" id="add-phone" name="phone">
            </div>
            <div class="form-group">
                <label for="add-email">Email:</label>
                <input type="email" id="add-email" name="email">
            </div>
            <div class="form-group">
                <label for="add-date">Date de création:</label>
                <input type="date" id="add-date" name="date_creation">
            </div>
            <div class="form-group">
                <label for="add-website">Site web:</label>
                <input type="url" id="add-website" name="site_web">
            </div>
            <div class="form-group">
            <label for="add-image">Image Partenaire:</label>
                <div id="drop-zone-add" class="drop-zone">
                    <span class="drop-zone__prompt">Sélectionnez ou Déposer votre Fichier Ici</span>
                    <input type="file" id="add-image" name="image" class="drop-zone__input">
                </div>
            </div>
            <div class="form-group">
                <label for="add-themes">Thèmes:</label>
                <input type="text" id="add-themes" name="themes" placeholder="Séparés par des virgules">
            </div>
            <div class="form-group">
                <button type="submit" class="modal-button">Ajouter</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal pour éditer une association -->
<div id="editAssociationModal" class="modal" style="display: none">
    <div class="modal-content">
        <span class="close">&times;</span>
        <h2>Modifier une association</h2>
        <form id="editAssociationForm">
            <input type="hidden" id="edit-id" name="id">
            <div class="form-group">
                <label for="edit-name">Nom de l'association:</label>
                <input type="text" id="edit-name" name="name" required>
            </div>
            <div class="form-group">
                <label for="edit-address">Adresse:</label>
                <input type="text" id="edit-address" name="address">
            </div>
            <div class="form-group">
                <label for="edit-phone">Téléphone:</label>
                <input type="text" id="edit-phone" name="phone">
            </div>
            <div class="form-group">
                <label for="edit-email">Email:</label>
                <input type="email" id="edit-email" name="email">
            </div>
            <div class="form-group">
                <label for="edit-date">Date de création:</label>
                <input type="date" id="edit-date" name="date_creation">
            </div>
            <div class="form-group">
                <label for="edit-website">Site web:</label>
                <input type="url" id="edit-website" name="site_web">
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
            <div class="form-group">
                <label for="edit-themes">Thèmes:</label>
                <input type="text" id="edit-themes" name="themes" placeholder="Séparés par des virgules">
            </div>
            <div class="form-group">
                <button type="submit" class="modal-button">Modifier</button>
            </div>
        </form>
    </div>
</div>




