<?php
include 'connexion.php';
require('fpdf/fpdf.php');
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function showError($message) {
    echo "
    <!DOCTYPE html>
    <html lang='fr'>
    <head>
        <meta charset='UTF-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1.0'>
        <title>Erreur</title>
        <style>
            body {
                display: flex;
                justify-content: center;
                align-items: center;
                height: 100vh;
                margin: 0;
                background: linear-gradient(135deg, #ff7e5f, #feb47b);
                font-family: Arial, sans-serif;
            }
            .error-container {
                text-align: center;
                padding: 20px;
                background: white;
                box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
                border-radius: 10px;
                animation: float 2s infinite ease-in-out;
            }
            .error-container h1 {
                font-size: 2em;
                color: #e74c3c;
                margin: 0;
            }
            .error-container p {
                font-size: 1.2em;
                color: #555;
            }
            .error-container a {
                display: inline-block;
                margin-top: 10px;
                padding: 10px 20px;
                background: #e74c3c;
                color: white;
                text-decoration: none;
                border-radius: 5px;
                transition: background 0.3s;
            }
            .error-container a:hover {
                background: #c0392b;
            }
            @keyframes float {
                0%, 100% {
                    transform: translateY(0);
                }
                50% {
                    transform: translateY(-10px);
                }
            }
        </style>
    </head>
    <body>
        <div class='error-container'>
            <h1>Erreur !</h1>
            <p>$message</p>
            <a href='javascript:history.back()'>Revenir</a>
        </div>
    </body>
    </html>";
    exit;
}

if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Connexion à la base de données
    $database = new Database();
    $db = $database->getConnection();

    function getMention($moyenne) {
        if ($moyenne >= 16) {
            return "Excellent";
        } elseif ($moyenne >= 14 && $moyenne < 16) {
            return "Bien";
        } elseif ($moyenne >= 12 && $moyenne < 14) {
            return "Assez Bien";
        } elseif ($moyenne >= 10 && $moyenne < 12) {
            return "Passable";
        } else {
            return "Insuffisant";
        }
    }

    // Récupérer les informations de l'étudiant
    $sql_etudiant = "SELECT * FROM etudiants WHERE id= :id";
    $stmt_etudiant = $db->prepare($sql_etudiant);
    $stmt_etudiant->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt_etudiant->execute();
    $etudiant = $stmt_etudiant->fetch(PDO::FETCH_ASSOC);

    if (!$etudiant) {
        showError("Étudiant introuvable.");
    }

    // Définir les poids pour chaque catégorie
    $poids_categories = [
        'CC' => 10, // 10%
        'TD' => 30, // 30%
        'Exam' => 60 // 60%
    ];

    $categories_obligatoires = array_keys($poids_categories);

    // Requête pour récupérer les notes par matière et catégorie
    $sql = "
        SELECT 
            *
        FROM 
            notes
        WHERE 
            etd = :etd
        ORDER BY 
            matiere, categorie;
    ";

    $stmt = $db->prepare($sql);
    $stmt->bindParam(':etd', $id, PDO::PARAM_INT);
    $stmt->execute();
    $notes = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Organiser les données par matière
    $data = [];
    $categories = [];
    $moyennes = [];

    foreach ($notes as $note) {
        $matiere = $note['matiere'];
        $categorie = $note['categorie'];
        $valeurNote = $note['note'];

        // Ajouter la catégorie à la liste des catégories uniques
        if (!in_array($categorie, $categories)) {
            $categories[] = $categorie;
        }

        // Organiser les données par matière
        if (!isset($data[$matiere])) {
            $data[$matiere] = [];
            $moyennes[$matiere] = ['total' => 0, 'poids' => 0];
        }

        $data[$matiere][$categorie] = $valeurNote;

        // Calculer la moyenne pondérée pour chaque matière
        if (isset($poids_categories[$categorie])) {
            $moyennes[$matiere]['total'] += $valeurNote * ($poids_categories[$categorie] / 100);
        }
    }

    // Vérifier si toutes les matières ont des notes pour toutes les catégories obligatoires
    foreach ($data as $matiere => $notesParCategorie) {
        foreach ($categories_obligatoires as $categorie) {
            if (!isset($notesParCategorie[$categorie])) {
                showError("La matière '<strong>$matiere</strong>' ne contient pas toutes les catégories de notes requises.");
            }
        }
    }

    // Calculs des moyennes et génération du PDF (restant inchangés)
}
