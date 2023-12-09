$(document).ready(function () {
    // Charger la liste des contacts au chargement de la page
    loadContactsList();

    // Fonction pour charger la liste des contacts via AJAX
 
    function loadContactsList() {
        $.ajax({
            url: 'http://localhost:8000/php/ajax.php',
            method: 'POST',
            data: { action: 'get_contacts' },
            dataType: 'json', // Indique que la réponse est au format JSON
            success: function (response) {
                displayContactsList(response);
            }
        });
    }

    // Fonction pour afficher la liste des contacts
    function displayContactsList(contactsList) {
        // Assurez-vous d'ajuster cette fonction en fonction de votre structure HTML
        // et de la manière dont vous souhaitez afficher les données.
        // Par exemple, vous pourriez boucler sur la liste et créer des éléments HTML.
        $('#contacts-list').empty();
        $('#contacts-list').html('<h2>Liste des contacts</h2>');

              // Créer le tableau HTML
        var tableHtml = '<table>';
        tableHtml += '<tr><th>Nom</th><th>Prénom</th><th>Catégorie</th><th>Actions</th></tr>';
        contactsList.forEach(function (contact) {
            tableHtml += '<tr>';
            tableHtml += '<td>' + contact.nom + '</td>';
            tableHtml += '<td>' + contact.prenom + '</td>';
            tableHtml += '<td>' + contact.categorie_type + '</td>';
            tableHtml += '<td>';
            tableHtml += '<button class="show-contact" data-contact-id="' + contact.id + '">Afficher</button>';
            tableHtml += '<button class="edit-contact" data-contact-id="' + contact.id + '">Modifier</button>';
            tableHtml += '</td>';
            tableHtml += '</tr>';
        });

        tableHtml += '</table>';

        // Ajouter le tableau à la div #contacts-list
        $('#contacts-list').append(tableHtml);

        // Ajouter des gestionnaires d'événements pour les boutons
        $('.edit-contact').click(function() {
            var contactId = $(this).data('contact-id');
            // Appeler une fonction pour afficher le contact
            showContactDetails(contactId);
        });

    }

    document.querySelectorAll('.bouton-fermer-modal').forEach(function (bouton) {
        bouton.addEventListener('click', function() {
            closeEditModal();
        });
    });

    function showEditModal() {
    var modal = document.getElementById('edit-contact-modal');
        modal.style.display = 'block';
    }
     // Fonction pour fermer le modal de modification
     function closeEditModal() {
    var modal = document.getElementById('edit-contact-modal');
        modal.style.display = 'none';
    }

    
   

    
    // Fonction pour afficher les détails du contact
    function showContactDetails(id) {
       var  contactIdToUpdate = id;
        
        // Récupérez les informations du contact auprès du serveur
        $.ajax({
            type: 'POST',
            url: 'http://localhost:8000/php/ajax.php',
            data: {
                action: 'get_contact_info',
                contact_id: contactIdToUpdate
            },
            dataType: 'json',
            success: function(response) {
                if (response && response.success) {
                    // Affichez les informations du contact dans le formulaire de modification
                    $('#edit-nom').val(response.data.nom);
                    $('#edit-prenom').val(response.data.prenom);
                    $('#edit-categorie').val(response.data.categorie_type);
                    // Ajoutez d'autres lignes pour d'autres champs du formulaire
        
                    // Affichez le formulaire de modification
                } else {
                    console.error('Erreur lors de la récupération des informations du contact:', response.error);
                }
            },
            error: function(error) {
                console.error('Erreur lors de la récupération des informations du contact.', error);
            }
        });
    showEditModal();

    }

    // Exemple de fonction pour modifier le contact

    // Gestion de l'ouverture de la boîte modale d'ajout de contact
    $('#add-contact-btn').click(function () {
        $('#add-contact-modal').css('display', 'block');
    });

    // Gestion de la fermeture de la boîte modale
    $('.close').click(function () {
        $('#add-contact-modal').css('display', 'none');
    });

    // Soumission du formulaire d'ajout de contact via AJAX
    $('#add-contact-form').submit(function (event) {
        event.preventDefault();

        var nom = $('#nom').val();
        var prenom = $('#prenom').val();
        var categorieType = $('#categorie_type').val();

        $.ajax({
            url: '../php/ajax.php',
            type: 'POST',
            data: {
                action: 'add_contact',
                nom: nom,
                prenom: prenom,
                categorie_type: categorieType
            },
            success: function () {
                // Rafraîchir la liste des contacts après l'ajout
                loadContactsList();

                // Fermer la boîte modale
                $('#add-contact-modal').css('display', 'none');
            }
        });
    });
});
$(document).ready(function() {
    $('#bouton-enregistrer').on('click', function() {
        updateContact();
    });
});


$(document).ready(function() {
    $('.edit-contact').on('click', function() {
        var contactId = $(this).data('contact-id');
        showEditModalForUpdate(contactId);
    });


    function showEditModalForUpdate(id) {

        contactIdToUpdate = id;
        
        // Récupérez les informations du contact auprès du serveur
        $.ajax({
            type: 'POST',
            url: 'http://localhost:8000/php/ajax.php',
            data: {
                action: 'get_contact_info',
                contact_id: contactIdToUpdate
            },
            dataType: 'json',
            success: function(response) {
                if (response && response.success) {
                    // Affichez les informations du contact dans le formulaire de modification
                    $('#edit-nom').val(response.data.nom);
                    $('#edit-nom').val(response.data.nom);
                    $('#edit-categorie').val(response.data.categorie.type);
                    // Ajoutez d'autres lignes pour d'autres champs du formulaire
        
                    // Affichez le formulaire de modification
                    openEditModal();
                } else {
                    console.error('Erreur lors de la récupération des informations du contact:', response.error);
                }
            },
            error: function(error) {
                console.error('Erreur lors de la récupération des informations du contact.', error);
            }
        });
        }
});