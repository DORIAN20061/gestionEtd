<?php
require_once "connexion.php";

// Connexion à la base de données




class Student {
    private $db;

    public function __construct() {
        $database = new Database();
        $this->db = $database->getConnection();
    }
    public function login($email, $password) {
        // Préparer la requête pour récupérer l'étudiant par matricule
        $stmt = $this->db->prepare("SELECT * FROM etudiants WHERE matricule = ?");
        $stmt->execute([$email]); // Utilisation d'un tableau pour passer le paramètre
        $student = $stmt->fetch(PDO::FETCH_ASSOC); // Récupérer les données
    
        if ($student) {
            // Vérification du mot de passe
            if (password_verify($password, $student['pass'])) {
                // Si le mot de passe correspond, vérifier si c'est la première connexion
                if ($student['is_first_login'] && $password === $student['matricule']) {
                    // Stocker l'utilisateur en session et demander un changement de mot de passe
                    $_SESSION['user'] = $student;
                    return "FIRST_LOGIN";
                }
                else {
                    # code...
                
    
                // Stocker les informations de l'utilisateur dans la session
                $_SESSION['user'] = $student;
                return "SUCCESS";}
            }
        }
    
        // Si aucune correspondance, retourner "INVALID_CREDENTIALS"
        return "INVALID_CREDENTIALS";
    }
    
    
   
}

