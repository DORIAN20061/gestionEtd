<?php
require('fpdf/fpdf.php');

class StudentCardPDF extends FPDF {
    // En-tête personnalisé
    function Header() {
        $this->SetFont('Arial', 'B', 16);
        $this->Cell(0, 10, 'Carte d\'Etudiant', 0, 1, 'C');
        $this->Ln(10);
    }

    // Pied de page personnalisé
    function Footer() {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }

    // Contenu de la carte
    function StudentCard($nom, $matricule, $email, $classe) {
        // Ajouter un cadre
        $this->SetFont('Arial', '', 12);
        $this->SetFillColor(240, 240, 240);
        $this->Rect(10, 30, 190, 100, 'D');

        // Informations
        $this->SetY(40);
        $this->Cell(0, 10, "Nom : $nom", 0, 1, 'L');
        $this->Cell(0, 10, "Matricule : $matricule", 0, 1, 'L');
        $this->Cell(0, 10, "Email : $email", 0, 1, 'L');
        $this->Cell(0, 10, "Classe : $classe", 0, 1, 'L');

        // Photo placeholder
        $this->SetXY(160, 50);
        $this->Rect(160, 40, 30, 30, 'D'); // Placeholder pour la photo
        $this->SetXY(160, 75);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(30, 10, '(Photo)', 0, 0, 'C');
    }
}
