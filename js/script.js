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
            showEditModalForUpdate(contactId);
        });

        $('.show-contact').click(function() {
            var contactId = $(this).data('contact-id');
            showContactDetails(contactId);
        });

        function showContactDetails(contactId) {
            // Récupérez les informations du contact via une requête Ajax
            $.ajax({
                type: 'POST',
                url: 'http://localhost:8000/php/ajax.php',
                data: {
                    action: 'get_contact_info',
                    contact_id: contactId
                },
                dataType: 'json',
                success: function(response) {
                    if (response && response.success) {
                        // Affichez les informations dans une boîte de dialogue modale
                        displayContactModal(response.data);
                    } else {
                        console.error('Erreur lors de la récupération des informations du contact:', response.error);
                    }
                },
                error: function(error) {
                    console.error('Erreur lors de la récupération des informations du contact.', error);
                }
            });
        }
        function showModal(title, body) {
            var modal = document.getElementById('modal');
            var modalTitle = document.getElementById('modal-title');
            var modalBody = document.getElementById('modal-body');
        
            modalTitle.textContent = title;
            modalBody.innerHTML = body;
        
            modal.style.display = 'block';
        }
        document.getElementById('close-modal').addEventListener('click', function() {
            document.getElementById('modal').style.display = 'none';
        });
        function displayContactModal(contactInfo) {
            // Créez une boîte de dialogue modale avec les informations du contact
            // Utilisez jQuery, HTML et CSS ou une bibliothèque comme SweetAlert
            // Exemple avec une simple boîte de dialogue modale
            showModal('Détails du contact',`<p><strong>Nom:</strong> ${contactInfo.nom}</p> 
            <p><strong>Prenom:</strong> ${contactInfo.prenom}</p>
            <p><strong>Catégorie:</strong> ${contactInfo.categorie_type}</p>`);
            
        }
        

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
    function showEditModalForUpdate(id) {
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
    document.querySelectorAll('.closeModalAdd').forEach(function (bouton) {
        bouton.addEventListener('click', function() {
        $('#add-contact-modal').css('display', 'none');
        });
    });
    // Gestion de la fermeture de la boîte modale

    // Soumission du formulaire d'ajout de contact via AJAX
    $('#add-contact-form').submit(function (event) {
        event.preventDefault();

        var nom = $('#nom').val();
        var prenom = $('#prenom').val();
        var categorieType = $('#categorie_type').val();

        $.ajax({
            url: 'http://localhost:8000/php/ajax.php',
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
            }
        });
    });
});
$(document).ready(function() {
    $('#bouton-enregistrer').on('click', function() {
        var contactId = $(this).data('contact-id');
        updateContact(contactId);
    });

function updateContact(id){
    var  contactIdToUpdate = id;
    var nom = $('#edit-nom').val();
var prenom  = $('#edit-prenom').val();
 var categorie_type =  $('#edit-categorie').val();
    // Collectez d'autres valeurs de champs selon vos besoins

    // Construisez un objet avec les données du contact
    var contactData = {
        nom: nom,
        prenom : prenom,
        categorie_type : categorie_type
        // Ajoutez d'autres propriétés selon vos besoins
    };

    // Envoyez les données au serveur via une requête Ajax
    $.ajax({
        type: 'POST',
        url: 'http://localhost:8000/php/ajax.php',
        data: {
            action: 'update_contact',
            contact_id: contactIdToUpdate, // Utilisez l'ID du contact en cours de modification
            data: contactData
        },
        dataType: 'json',
        success: function(response) {
            if (response && response.success) {
                closeEditModal();

                loadContactsList(); 
            } else {
                // Gérez le cas où la mise à jour a échoué
                console.error('Erreur lors de la mise à jour du contact:', response.error);
            }
        },
        error: function(error) {
            console.error('Erreur lors de la mise à jour du contact.', error);
        }
    });
}


});



