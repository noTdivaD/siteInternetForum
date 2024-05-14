<?php
    // Titre de la page
    $pageTitle = "Contact - Forum du Pays de Grasse";
    $currentPage = "Nous Contacter";
    // Inclusion du header
    include 'parts/header.php';
?>

<div class="contact-form-container">
    <h1>Contactez-nous</h1>
    <form action="../controller/ContactController.php" method="POST" id="formContact">

        <div id="error_message" style="text-align: center; margin-bottom: 10px; color: red;"></div>

        <div class="form-group">
            <label for="firstname">Prénom :</label>
            <input type="text" id="firstname" name="firstname" required>
            <div class="error-message" id="error-firstname"></div>
        </div>

        <div class="form-group">
            <label for="lastname">Nom :</label>
            <input type="text" id="lastname" name="lastname" required>
            <div class="error-message" id="error-lastname"></div>
        </div>

        <div class="form-group">
            <label for="email">Email :</label>
            <input type="email" id="email" name="email" required>
            <div class="error-message" id="error-email"></div>
        </div>

        <div class="form-group">
            <label for="subject">Objet :</label>
            <input type="text" id="subject" name="subject" required>
            <div class="error-message" id="error-subject"></div>
        </div>

        <div class="form-group">
            <label for="message">Message :</label>
            <textarea id="message" name="message" rows="6" required></textarea>
        </div>

        <button type="submit" class="submit-button">Envoyer</button>
        
    </form>
</div>


<link rel="stylesheet" href="../../public/css/contacter_style.css">
<script src="../../public/js/contacter.js"></script>
<?php
    // Inclusion du footer
    include 'parts/footer.php';
?>