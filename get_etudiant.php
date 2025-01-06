<?php
require_once "connexion.php";

// Connexion à la base de données




class Student {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    // Vérifier si les informations de connexion sont correctes
    public function login($email, $password) {
        try {
            $sql = "SELECT * FROM etudiants WHERE matricule = :matricule AND pass = :pass";
            $stmt = $this->db->prepare($sql);
            $stmt->bindParam(':matricule', $email);
            $stmt->bindParam(':pass', $password);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                return $result; // Retourne les informations de l'étudiant
            } else {
                return false; // Aucune correspondance trouvée
            }
        } catch (PDOException $e) {
            die("Erreur : " . $e->getMessage());
        }
    }
}

