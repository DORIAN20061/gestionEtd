<?php
include "connexion.php";
include "mail.php";
include "pdf.php";

// Classe pour gérer les versements
class Versement {
    private $conn;

    public function __construct($db) {
        $this->conn = $db;
    }
 // Fonction pour générer le reçu PDF


    // Méthode pour générer un numéro unique de versement
    public function genererMatricule($niveau) {
        $annee = date('Y');
        $sql = "SELECT COUNT(*) AS total FROM versements";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $compteur = intval($result['total']) + 1;
        $compteurFormate = str_pad($compteur, 3, '0', STR_PAD_LEFT);
        return $annee . "_" . strtoupper($niveau) . "_" . $compteurFormate;
    }

    // Méthode pour enregistrer un versement, mettre à jour le solde et changer le statut
    public function enregistrer($data) {
        try {
            // Génération du numéro de versement
            $data['numero'] = $this->genererMatricule($data['matrietd']);
            $data['date'] = date('Y-m-d');

            // Étape 1 : Récupérer le total actuel de l'étudiant
            $sql_select = "SELECT * FROM etudiants WHERE matricule = :matricule";
            $stmt_select = $this->conn->prepare($sql_select);
            $stmt_select->bindParam(':matricule', $data['matrietd']);
            $stmt_select->execute();
            $etudiant = $stmt_select->fetch(PDO::FETCH_ASSOC);

            if (!$etudiant) {
                throw new Exception("Étudiant non trouvé avec le matricule : " . $data['matrietd']);
            }

            $totalActuel = floatval($etudiant['solde']);
            $nouveauSolde = $totalActuel - $data['montant'];
            $mat=$etudiant['matricule'];
            $nom=$etudiant['nom'];
            $prenom=$etudiant['prenom'];
            $niv=$etudiant['Niveau'];
            $mnt=$data['montant'];
            $id=$data['numero'];
            $email=$etudiant['Email'];
            $emailPrt=$etudiant['emailPrt'];
            $nomPrt=$etudiant['nomPrt'];

            if ($nouveauSolde < 0) {
              
                header("Location: versform.php"); // Redirection après succès
                echo  "<script>alert('Erreur :Le montant dépasse le solde disponible.');</script>";
                exit;
            }

            // Étape 2 : Insérer le versement dans la table `versements`
            $sql_insert = "INSERT INTO versements (numero, date, matrietd, montant) 
                           VALUES (:numero, :date, :matrietd, :montant)";
            $stmt_insert = $this->conn->prepare($sql_insert);
            $stmt_insert->bindParam(':numero', $data['numero']);
            $stmt_insert->bindParam(':date', $data['date']);
            $stmt_insert->bindParam(':matrietd', $data['matrietd']);
            $stmt_insert->bindParam(':montant', $data['montant']);
            $stmt_insert->execute();

            // Étape 3 : Déterminer le nouveau statut en fonction du solde
            $nouveauStatut = $this->determinerStatut($totalActuel,$nouveauSolde);

            // Étape 4 : Mettre à jour le solde et le statut dans la table `etudiants`
            $sql_update = "UPDATE etudiants SET solde = :nouveauSolde, statut = :nouveauStatut WHERE matricule = :matricule";
            $stmt_update = $this->conn->prepare($sql_update);
            $stmt_update->bindParam(':nouveauSolde', $nouveauSolde);
            $stmt_update->bindParam(':nouveauStatut', $nouveauStatut);
            $stmt_update->bindParam(':matricule', $data['matrietd']);
            $stmt_update->execute();
            
            $pdf = new RecuVersement();
           
            $pdf->ajouterDetails($nom, $mat, $mnt, $nouveauSolde,$id,$prenom,$niv);
             $mail= new  RecuVersement();
             $pdfpath= 'recus/recu_' . $id . '.pdf';
             $mail->sendEmail($pdfpath,$email,$emailPrt,$nomPrt,$nom,$prenom);
           
            // Envoyer l'email
           

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
    private function determinerStatut($total,$comp) {
        $lim=$total/2;
        
        if ($comp == 0) {
            return "Solvable";
        } elseif ( $comp > 0 && $comp <= $lim) {
            return "En cours";
        } else {
            return "Insolvable"; // Si jamais il y a un problème logique (montant négatif)
        }
    }
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'matrietd' => $_POST['matrietd'], // Matricule de l'étudiant
        'montant' => floatval($_POST['montant']), // Montant du versement
    ];

    // Connexion à la base de données
    $database = new Database();
    $db = $database->getConnection();
    

    // Enregistrement du versement
    $versement = new Versement($db);
    if ($versement->enregistrer($data)) {
     
        header("Location: vers.php"); // Redirection après succès
        exit;
    } else {
        echo "<script>alert('Erreur lors de l\'enregistrement du versement.');</script>";
    }
}
?>
