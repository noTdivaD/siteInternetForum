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
            <?php foreach ($associations as $association): ?>
                <div class="association-item">
                    <h2><?= htmlspecialchars($association['nom'], ENT_QUOTES, 'UTF-8') ?></h2>
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
                            <td class="creationdate"><?= htmlspecialchars($association['date_creation'], ENT_QUOTES, 'UTF-8') ?></td>
                        </tr>
                    </table>
                    <?php if (!empty($association['site_web'])): ?>
                        <a href="<?= htmlspecialchars($association['site_web'], ENT_QUOTES, 'UTF-8') ?>" target="_blank">Visiter le site</a>
                    <?php endif; ?>
                </div>
            <?php endforeach; ?>
        </div>
        <a href="#top" class="back-to-top">Haut de page</a>
    </div>
</div>