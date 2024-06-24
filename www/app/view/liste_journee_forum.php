<?php
    // Titre de la page
    $pageTitle = "Liste Journée Forum - Forum du Pays de Grasse";
    $currentPage = "Liste d'Inscriptions";

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

    // Vérifier si l'utilisateur est connecté et administrateur
    $isAdmin = isset($_SESSION['user_logged_in']) && $_SESSION['user_type'] == 'administrateur';

    // Inclusion du header
    include 'parts/header.php';
?>

<div class="main-content">
    <h1>Liste des inscrits à la Journée Forum</h1>
    <?php if ($isAdmin): ?>
        <input type="text" id="searchInput" onkeyup="searchTable()" placeholder="Rechercher par prénom ou nom" class="search-bar">
        <?php if (!empty($registeredUsers)): ?>
            <div class="table-container">
                <table class="inscription-list" id="inscriptionTable">
                    <thead>
                        <tr>
                            <th>Prénom</th>
                            <th>Nom</th>
                            <th>Email</th>
                            <th>Adresse</th>
                            <th>Ville</th>
                            <th>Code Postal</th>
                            <th onclick="sortTable(6)">Date d'inscription &#x25B2;&#x25BC;</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($registeredUsers as $user): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($user['firstname']); ?></td>
                                <td><?php echo htmlspecialchars($user['lastname']); ?></td>
                                <td><?php echo htmlspecialchars($user['email']); ?></td>
                                <td><?php echo htmlspecialchars($user['address']); ?></td>
                                <td><?php echo htmlspecialchars($user['city']); ?></td>
                                <td><?php echo htmlspecialchars($user['postal_code']); ?></td>
                                <td><?php echo htmlspecialchars($user['registration_date']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr id="noResultMessage" style="display:none;">
                            <td colspan="7" style="text-align: center;">Aucun Résultat</td>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td colspan="7"></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        <?php else: ?>
            <p>Aucune inscription n'a été trouvée.</p>
        <?php endif; ?>
    <?php else: ?>
        <p>Vous n'avez pas les droits pour voir cette page.</p>
    <?php endif; ?>
</div>   

<link rel="stylesheet" href="/public/css/liste_journee_forum_style.css?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/css/liste_journee_forum_style.css'); ?>">
<script src="/public/js/liste_journee_forum.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/js/liste_journee_forum.js'); ?>"></script>
<?php
    // Inclusion du footer
    include 'parts/footer.php';
?>
