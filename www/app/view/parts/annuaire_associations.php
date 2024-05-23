<div class="main-content">
    <div class="association-section">
        <h1><?= $currentPage ?></h1>
        <a href="/app/annuaire_associations" class="back-to-directory">Retour à l'annuaire des associations</a>
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
                            <td><?= htmlspecialchars($association['adresse'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($association['telephone'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($association['email'], ENT_QUOTES, 'UTF-8') ?></td>
                            <td><?= htmlspecialchars($association['date_creation'], ENT_QUOTES, 'UTF-8') ?></td>
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