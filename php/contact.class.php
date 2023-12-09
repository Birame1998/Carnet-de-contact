<?php

class Contact{
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function getContactsList() {
        // Méthode pour récupérer la liste des contacts avec le nom de la catégorie
        $query = "SELECT c.id, c.nom, c.prenom, cat.type as categorie_type FROM contact c
                  LEFT JOIN categorie cat ON c.categorie_id = cat.id";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute();

        $contactsList = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $contactsList;
    }

    public function addContact($nom, $prenom, $categorieType) {
        $categorieId=$this->getCategorieId($categorieType);
        // Méthode pour ajouter un nouveau contact
        $query = "INSERT INTO contact (nom, prenom, categorie_id) VALUES (?, ?, ?)";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$nom, $prenom, $categorieId]);
    }

    public function updateContact($contactId, $nom, $prenom, $categorieType) {
        $categorieId=$this->getCategorieId($categorieType);
        // Méthode pour mettre à jour un contact
        $query = "UPDATE contact SET nom=?, prenom=?, categorie_id=? WHERE id=?";
        $stmt = $this->pdo->prepare($query);
        $stmt->execute([$nom, $prenom, $categorieId, $contactId]);
    }

    public function getCategorieId($categorieType) {
        try {
            $query = "SELECT id FROM categorie WHERE type = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$categorieType]);
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            if ($result) {
                return $result['id'];
            } else {
                // La catégorie n'existe pas, créons-la
                $queryInsert = "INSERT INTO categorie (type) VALUES (?)";
                $stmtInsert = $this->pdo->prepare($queryInsert);
                $stmtInsert->execute([$categorieType]);
    
                // Récupérer l'ID de la nouvelle catégorie
                $newCategoryId = $this->pdo->lastInsertId();
    
                return $newCategoryId;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
            return null;
        }
    }

    public function getContactInfo($contactId) {
        try {
            $query = "SELECT * FROM contact WHERE id = ?";
            $stmt = $this->pdo->prepare($query);
            $stmt->execute([$contactId]);
    
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
            return $result;
        } catch (PDOException $e) {
            // Gérer les erreurs de base de données ici
            // Vous pouvez logger l'erreur, afficher un message à l'utilisateur, etc.
            echo "Error: " . $e->getMessage();
            return null;
        }
    }
}


?>
