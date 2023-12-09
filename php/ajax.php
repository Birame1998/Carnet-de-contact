<?php
require_once 'contact.class.php';
require_once 'database.php';

$action = $_POST['action'];
$contact = new Contact($pdo);

if ($action === 'get_contacts') {
    $contactsList = $contact->getContactsList();
    echo json_encode($contactsList);
    
} elseif ($action === 'add_contact') {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $categorie_type = $_POST['categorie_type'];
    $contact->addContact($nom, $prenom, $categorie_type);
} elseif ($action === 'update_contact') {
    $contactId = $_POST['contact_id'];
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $categorieType = $_POST['categorie_type'];

    $contact->updateContact($contactId, $nom, $prenom, $categorieType);
}elseif ($action === 'get_contact_info' && isset($_POST['contact_id'])) {
    $contactId = $_POST['contact_id'];

    try {
        // Initialisez votre connexion à la base de données
        // ...

        // Récupérez les informations du contact depuis la base de données
        $stmt = $pdo->prepare('SELECT contact.*, categorie.type AS categorie_type FROM contact INNER JOIN categorie ON contact.categorie_id = categorie.id WHERE contact.id = :contactId');
        $stmt->bindParam(':contactId', $contactId);
        $stmt->execute();
        $contactInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        // Répondez avec succès
        header('Content-Type: application/json');
        echo json_encode(['success' => true, 'data' => $contactInfo]);
        exit;
    } catch (PDOException $e) {
        // Gérez les erreurs de la base de données
        header('Content-Type: application/json');
        echo json_encode(['success' => false, 'error' => 'Erreur lors de la récupération des informations du contact : ' . $e->getMessage()]);
        exit;
    }
} 
 elseif (isset($_POST['action'])) {
    $action = $_POST['action'];

    if ($action === 'get_contact' && isset($_POST['contact_id'])) {
        $contactId = $_POST['contact_id'];

        // Effectuez votre requête SQL pour récupérer les informations du contact
        try {
            // Initialisez votre connexion à la base de données
            // ...

            // Effectuez la requête SQL pour récupérer les informations du contact
            $stmt = $pdo->prepare('SELECT * FROM contact WHERE id = :contactId');
            $stmt->bindParam(':contactId', $contactId);
            $stmt->execute();
            $contactInfo = $stmt->fetch(PDO::FETCH_ASSOC);

            // Envoyez les informations du contact au format JSON
            echo json_encode($contactInfo);
        } catch (PDOException $e) {
            // Gérez les erreurs de la base de données
            echo json_encode(['error' => 'Erreur lors de la récupération des informations du contact : ' . $e->getMessage()]);
        }
    }
}
    // Ajoutez le code pour la suppression d'un contact ici
 else {
    // Autres actions à traiter si nécessaire
}