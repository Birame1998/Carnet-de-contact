<?php

class Contact{
    private $pdo;
    public function __construct($pdo) {
        $this->pdo = $pdo;
    }
    public function addCategory($data) {
        try {
            $query = "INSERT INTO categorie (type) VALUES (:type)";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':type', $data['type'], PDO::PARAM_STR);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur lors de l'ajout de la categorie : " . $e->getMessage();
            return false;
        }
    }
    public function getCategorieById($categorieId){
        try {
            $query = "SELECT * FROM categorie WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $categorieId, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération de la categorie : " . $e->getMessage();
            return false;
        }
    }
    public function getCategorieIdByType($type){
        try {
            $query = "SELECT id FROM categorie WHERE type = :type";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $type, PDO::PARAM_INT);
            $stmt->execute();
            $result= $stmt->fetch(PDO::FETCH_ASSOC);
            return ($result) ? $result['id'] : null;        
        } 
        catch (PDOException $e) {
            echo "Erreur lors de la récupération de la categorie : " . $e->getMessage();
            return false;
        }
    }
    public function addContact($data){ 
        $categorieId = $this->getCategorieIdByType($data['type']);
        if( $categorieId!==null){
            try {
                $query = "INSERT INTO contact (nom, prenom, categorie_id) VALUES (:nom,:prenom,:categorie)";
                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(':nom', $data['nom'], PDO::PARAM_STR);
                $stmt->bindParam(':prenom', $data['prenom'], PDO::PARAM_STR);
                $stmt->bindParam(':categorie', $categorieId, PDO::PARAM_STR);
                $stmt->execute();
                return true;
            } catch (PDOException $e) {
                echo "Erreur lors de l'ajout du contact : " . $e->getMessage();
                return false;
            }
        }else{
            $this->addCategory($data['type']);
            try {
                $query = "INSERT INTO contact (nom, prenom, categorie_id) VALUES (:nom,:prenom,:categorie)";
                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(':nom', $data['nom'], PDO::PARAM_STR);
                $stmt->bindParam(':prenom', $data['prenom'], PDO::PARAM_STR);
                $stmt->bindParam(':categorie', $categorieId, PDO::PARAM_STR);
                $stmt->execute();
                return true;
            } catch (PDOException $e) {
                echo "Erreur lors de l'ajout du contact : " . $e->getMessage();
                return false;
            }

        }
       
    }
    public function updateContact($data){ 
        $categorieId = $this->getCategorieIdByType($data['type']);
        if( $categorieId!==null){
            try {
                $query = "UPDATE contact SET nom = :nom, prenom = :prenom, categorie_id = :categorie WHERE id = :id";
                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(':nom', $data['nom'], PDO::PARAM_STR);
                $stmt->bindParam(':prenom', $data['prenom'], PDO::PARAM_STR);
                $stmt->bindParam(':categorie', $categorieId, PDO::PARAM_STR);
                $stmt->execute();
                return true;
            } catch (PDOException $e) {
                echo "Erreur lors de la modification du contact : " . $e->getMessage();
                return false;
            }
        }else{
            $this->addCategory($data['type']);
            try {
                $query = "INSERT INTO contact (nom, prenom, categorie_id) VALUES (:nom,:prenom,:categorie)";
                $stmt = $this->pdo->prepare($query);
                $stmt->bindParam(':nom', $data['nom'], PDO::PARAM_STR);
                $stmt->bindParam(':prenom', $data['prenom'], PDO::PARAM_STR);
                $stmt->bindParam(':categorie', $categorieId, PDO::PARAM_STR);
                $stmt->execute();
                return true;
            } catch (PDOException $e) {
                echo "Erreur lors de la modification du contact: " . $e->getMessage();
                return false;
            }

        }
       
    }


    public function getContactById($id) {
        try {
            $query = "SELECT * FROM contact WHERE id = :id";
            $stmt = $this->pdo->prepare($query);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return $stmt->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération du contact : " . $e->getMessage();
            return false;
        }
    }

    public function getContactsWithCategories() {
        try {
            $query = "SELECT contact.id, contact.nom, contact.prenom, categorie.type as categorie_type
            FROM contact LEFT JOIN categorie ON contact.categorie_id = categorie.id";
            $stmt = $this->pdo->query($query);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            echo "Erreur lors de la récupération des contacts : " . $e->getMessage();
            return false;
        }
    }




}




?>
