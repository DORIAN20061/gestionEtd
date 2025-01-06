<?php
require('StudentCardPDF.php');
session_start();

if (!isset($_SESSION['user'])) {
    die('Accès non autorisé.');
}

// Récupérer les informations de l'étudiant connecté
$user = $_SESSION['user'];
$nom = $user['nom'];
$matricule = $user['matricule'];
$email = $user['Email'];
$classe = $user['Niveau'];

// Générer le PDF
$pdf = new StudentCardPDF();
$pdf->AddPage();
$pdf->StudentCard($nom, $matricule, $email, $classe);

// Téléchargement direct
$pdf->Output('D', 'Carte_Etudiant_' . $matricule . '.pdf');
