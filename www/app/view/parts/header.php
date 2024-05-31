<?php include 'head.php'; ?>
<body>
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
