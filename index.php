<?php
require_once('php/database.php');
require_once('php/ajax.php');
require_once('php/contact.class.php');
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cahier de Contact</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="container">
    <h1>Cahier de Contact</h1>
    
    <button id="add-contact-btn">Ajouter un contact</button>    
        <div id="contacts-list">
            <!-- Les données des contacts seront ajoutées ici via JavaScript -->
        </div>
</div>

<div id="add-contact-modal" class="modal">
    <div class="modal-content">
        <span class="close">&times;</span>
        <!-- Contenu du formulaire pour ajouter un contact -->
        <form id="add-contact-form">
            <!-- Ajoutez les champs du formulaire pour le nom, prénom, catégorie, etc. -->
            <!-- Assurez-vous de garder les noms de champs identiques à ceux dans votre script jQuery -->
            <label for="nom">Nom :</label>
            <input type="text" id="nom" name="nom" required>

            <label for="prenom">Prénom :</label>
            <input type="text" id="prenom" name="prenom" required>

            <label for="categorie_type">Catégorie :</label>
            <input type="text" id="categorie_type" name="categorie_type" required>

            <input type="submit" value="Ajouter">
        </form>
    </div>
</div>

<!-- Modal pour le formulaire de modification -->
<div id="edit-contact-modal" class="modal">
    <div class="modal-content">
        <div class=""></div>
        <span class="close bouton-fermer-modal">&times;</span>
        <h2>Modifier le contact</h2>
        <form id="edit-contact-form">
            <label for="edit-nom">Nom:</label>
            <input type="text" id="edit-nom" name="edit-nom" required>

            <label for="edit-prenom">Prénom:</label>
            <input type="text" id="edit-prenom" name="edit-prenom" required>

            <label for="edit-categorie">Catégorie:</label>
            <input type="text" id="edit-categorie" name="edit-categorie" required>
            <!-- Ajoutez d'autres champs selon vos besoins -->

            <button type="button" class="edit-form"  id="bouton-enregistrer">Enregistrer</button>
            <button type="button" class="close-modal bouton-fermer-modal">Annuler</button>
        </form>
    </div>
</div>

<div id="modal" class="modal">
    <div class="modal-container">
        <span id="close-modal" class="close">&times;</span>
        <h2 id="modal-title" class="modal-title"></h2>
        <div id="modal-body" class="modal-body"></div>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script type="module" src="js/script.js"></script>
</body>
</html>
