<?php
include "connexion.php";
// Exemple d'utilisation
$database = new Database();
    $db = $database->getConnection();

    if (isset($_GET['id'])) {
        $id = $_GET['id'];
    
        try {
            $sql = "DELETE FROM classes WHERE id = :id";
            $stmt = $db->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    
            if ($stmt->execute()) {
                echo "classes supprimé avec succès.";
                // Redirection vers la page des étudiants
                header("Location: classes.php");
                exit(); // Assurez-vous de terminer le script après la redirection
            } else {
                echo "Erreur lors de la suppression de l'étudiant.";
            }
        } catch (PDOException $e) {
            echo "Erreur PDO : " . $e->getMessage();
        }
    } else {
        echo "Aucun ID fourni pour la suppression.";
    }

?>