<?php
require_once('fpdf/fpdf.php');
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;


class RecuVersement
{
    public function ajouterDetails($nom, $matricule, $montantVerse, $nouveauSolde,$id,$prenom,$niveau)
    {
        // Ajouter un titre au PDF
        $pdf = new FPDF();
        $pdf->AddPage();
        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Recu de Versement', 0, 1, 'C');
        $pdf->Ln(10);
   
        // Ajouter les informations de l'étudiant
        $pdf->SetFont('Arial', '', 12);

        $pdf->Cell(0, 10, "Nom de l'etudiant : " . $nom, 0, 1);
        $pdf->Cell(0, 10, "Prenom de l'etudiant : " . $prenom, 0, 1);
        $pdf->Cell(0, 10, "Classe: " . $niveau, 0, 1);
        $pdf->Cell(0, 10, "Matricule : " . $matricule, 0, 1);
        $pdf->Cell(0, 10, "Montant verse : " . number_format($montantVerse, 2) . " F CFA", 0, 1);
        $pdf->Cell(0, 10, "Nouveau solde : " . number_format($nouveauSolde, 2) . " F CFA", 0, 1);
        $pdf->Ln(10);
        $pdf->Cell(0, 10, "Merci pour votre versement !", 0, 1, 'C');
         // Ajouter un pied de page
         $pdf->SetY(-15);
         $pdf->SetFont('Arial', 'I', 10);
         $pdf->Cell(0, 10, 'Page ' . $pdf->PageNo(), 0, 0, 'C');
         $pdf_path = 'recus/recu_' . $id . '.pdf';
         $pdf->Output('F', $pdf_path);
         
          
        
 
    }
    public function sendEmail($pdfPath,$email,$emailPrt,$nomPrt,$nom,$prenom) {
        $mail = new PHPMailer(true);
        try {
            $mail->isSMTP();
            $mail->Host = 'smtp.gmail.com';
            $mail->SMTPAuth = true;
            $mail->Username = 'ondoatamar@gmail.com';
            $mail->Password = 'cebzssqbrbnvxrfd';
            $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
            $mail->Port = 587;

            $mail->setFrom('ondoatamar@gmail.com', 'Administration');
            $mail->addAddress($emailPrt,'Parent de ' . $nom . ' ' . $prenom );
            $mail->addCC($email, $nom . ' ' . $prenom);
            
            $mail->addAttachment($pdfPath);

            $mail->isHTML(true);
            $mail->Subject = 'Recu de paiement';
            $mail->Body = "Bonjour M./Mme {$nomPrt},<br><br>" .
                          "Veuillez trouver ci-joint le recu de paiement des frais de scolarite de votre enfant.<br><br>Cordialement,<br>L'administration.";

            $mail->send();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}

// Exemple d'utilisation



?>
