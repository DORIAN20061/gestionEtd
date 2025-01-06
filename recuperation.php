<?php
include "connexion.php";

// Exemple d'utilisation
$database = new Database();
$conn = $database->getConnection();

if ($conn) {
    echo "Connexion réussie à la base de données.";
     // Récupération des données du formulaire
  $adresse = $_POST['nom'];
  $pass = $_POST['pass'];
  
  // Requête SQL pour vérifier les informations de connexion
  $stmt = $conn->prepare("SELECT * FROM `user` WHERE nom=:nom AND pass=:pass");
  $stmt->bindParam(':nom', $adresse);
  $stmt->bindParam(':pass', $pass);
  $stmt->execute();
  
  // Vérification si les informations sont correctes
  if ($stmt->rowCount() > 0) {
    // Redirection vers la page d'accueil
    header("Location:etd.php");
    exit();
  } else {
     header("Location: login.php");
     exit();
  }
} else {
    echo "Échec de la connexion.";
}

?>