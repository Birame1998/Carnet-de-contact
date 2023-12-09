<?php
// ajax.php - Point d'entrée pour les appels Ajax

// Inclure la classe contact

require_once('database.php');
require_once('contact.class.php');

// Vérifier le type d'appel Ajax
if (isset($_POST['action'])) {
    $action = $_POST['action'];

    // Instancier la classe contact
    $contact = new Contact($pdo);

    // Traiter les différentes actions
    switch ($action) {
        case 'get_contacts':
            echo json_encode($contact->getContactsWithCategories());
            break;

        case 'add_contact':
            // Récupérer les données du formulaire
            $data = json_decode($_POST['data'], true);
            echo json_encode($contact->addContact($data));
            break;

        case 'update_contact':
            // Récupérer les données du formulaire
            $data = json_decode($_POST['data'], true);
            echo json_encode($contact->updateContact($data));
            break;
        case 'add_category':
            // Récupérer les données du formulaire
            $data = json_decode($_POST['data'], true);
            echo json_encode($contact->addCategory($data));
            break;    

        // Ajoutez d'autres cas selon vos besoins

        default:
            // Gérer une action inconnue
            echo json_encode(['error' => 'Action inconnue']);
            break;
    }
} else {
    // Gérer les appels non-Ajax (redirection ou erreur)
    echo json_encode(['error' => 'Appel non-Ajax interdit']);
}
?>
