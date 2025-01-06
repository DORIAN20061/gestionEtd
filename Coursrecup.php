<?php
include "connexion.php";
include "mail.php";


// Classe pour gérer les versements
class Cours {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }
 // Fonction pour générer le reçu PDF


    // Méthode pour générer un numéro unique de versement
   

    // Méthode pour enregistrer un versement, mettre à jour le solde et changer le statut
    public function enregistrer($data) {
        try {
            

            // Étape 2 : Insérer le versement dans la table `versements`
            $sql_insert = "INSERT INTO cours (nom,niveau,credit) 
                           VALUES (:nom, :niveau, :credit)";
            $stmt_insert = $this->conn->prepare($sql_insert);
            $stmt_insert->bindParam(':nom', $data['nom']);
            $stmt_insert->bindParam(':niveau', $data['niveau']);
            $stmt_insert->bindParam(':credit', $data['credit']);
            
            $stmt_insert->execute();

            return true;

        } catch (PDOException $e) {
            echo "Erreur SQL : " . $e->getMessage();
            return false;
        } catch (Exception $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }

    // Méthode pour déterminer le statut en fonction du total
   
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
       // Matricule de l'étudiant
       'nom' => $_POST['nom'], 
       'credit' => $_POST['credit'], 
      'niveau' => $_POST['niveau'], 
      
    ];

    // Connexion à la base de données
    $database = new Database();
    $db = $database->getConnection();

    // Enregistrement du versement
    $crs = new Cours($db);
    if ($crs->enregistrer($data)) {
        header("Location:cours.php"); // Redirection après succès
        exit;
    } else {
        echo "<script>alert('Erreur lors de l\'enregistrement .');</script>";
    }
}
?>
