<?php include 'head.php'; ?>
<body>

    <div class="cookie-overlay" id="cookie-overlay"></div>
    <div class="cookie-banner" id="cookie-banner">
        <img class="img" src="/public/images/icones/biscuits.png" alt="Image Cookies"></img>
        <h1>Nous Utilisons des Cookies !</h1>
        <p>Ce site utilise des cookies pour vous garantir la meilleure expérience possible.</p>
        <button id="accept-cookies">Accepter</button>
        <button id="decline-cookies">Refuser</button>
    </div>

    <h1>Test Cookie Consent</h1>

    <script src="/public/js/cookieconsent.js?ver=<?php echo filemtime($_SERVER['DOCUMENT_ROOT'].'/public/js/cookieconsent.js'); ?>"></script>

    <!-- Bannière -->
    <header class="banner">
        <div class="logo">
            <a href="/app/index" class="facebook-logo">
                <img src="/public/images/logo/Logo Association Forum.jpg" alt="Logo Association Forum">
            </a>
        </div>
        <div class="banner-text">
            <p class="titre">Forum Association de Grasse</p>
            <p class="current-page"><?php echo $currentPage; ?></p>
            <?php if (isset($_SESSION['user_logged_in']) && $_SESSION['user_logged_in']) : ?>
                <div class="profile-pic-container">
                    <a href="/app/mon_compte">
                        <img src="<?php echo htmlspecialchars($_SESSION['user']['photo_profil']); ?>" alt="Profile Picture" class="profile-pic header-profile-pic">
                    </a>
                </div>
            <?php endif; ?>
            <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
        </div>
    </header>
    <?php include 'menu.php'; ?>
</body>
</html>
