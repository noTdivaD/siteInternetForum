<?php include 'head.php'; ?>
<body>
        <!-- Bannière -->
        <header class="banner">
            <div class="menu-icon" onclick="toggleMenu()">&#9776;</div>
            <div class="banner-text">
                <p class="current-page"><?php echo $currentPage; ?></p>
                <p class="titre">Forum Association de Grasse</p></div>
            <div class="logo">
                <img src="../../public/images/logo/Logo Association Forum.jpg" alt="Logo Association Forum">
            </div>
        </header>
        <?php include 'menu.php'; ?>