<?php include 'head.php';?>
<body>
        <!-- Bannière -->
        <header class="banner">
            <div class="logo">
                <a href="accueil.php" class="facebook-logo">
                    <img src="../../public/images/logo/Logo Association Forum.jpg" alt="Logo Association Forum">
                </a>
            </div>
            <div class="banner-text">
                <p class="titre">Forum Association de Grasse</p>
                <p class="current-page"><?php echo $currentPage; ?></p>
            </div>
            <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
        </header>
        <?php include 'menu.php'; ?>