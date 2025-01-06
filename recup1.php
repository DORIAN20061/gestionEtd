<?php
include "connexion.php";

// Exemple d'utilisation

class Etudiant {
    private $conn;
    

    public function __construct($db) {
        $this->conn = $db;
    }

    public function genererMatricule($Niveau) {
        $annee = date('Y');
        $anneeSuffix = substr($annee, -2);

        $sql = "SELECT COUNT(*) AS total FROM etudiants";
        $stmt = $this->conn->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        $compteur = intval($result['total']) + 1;

        $compteurFormate = str_pad($compteur, 3, '0', STR_PAD_LEFT);

        return $anneeSuffix . strtoupper($Niveau) . $compteurFormate;
    }

    public function enregistrer($data) {
        $sql = "SELECT pension FROM classes WHERE nom = :Niveau";
        $stmt = $this->conn->prepare($sql);
        $stmt->bindParam(':Niveau', $data['Niveau']);
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if (!$result) {
            echo "Classe introuvable.";
            return false;
        }
    
        $data['total'] = $result['pension'];
        $data['solde'] = $data['total'];
        $data['matricule'] = $this->genererMatricule($data['Niveau']);
        $data['Statut'] = "Insolvable";
        $data['dateIns'] = date('Y-m-d');

        // Gestion de l'image
        if (!empty($data['image']['tmp_name'])) {
            $targetDir = "uploads/";
            $imageName = uniqid() . "_" . basename($data['image']['tmp_name']);
            $targetFilePath = $targetDir . $imageName;

            $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
            $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

            if (in_array($imageFileType, $allowedTypes)) {
                if (!move_uploaded_file($data['image']['tmp_name'], $targetFilePath)) {
                    echo "Erreur lors du téléchargement de l'image.";
                    return false;
                }
            } else {
                echo "Format d'image non supporté.";
                return false;
            }
            $data['imagePath'] = $imageName; // Nom de l'image enregistré dans la base
        } else {
            $data['imagePath'] = null;
        }

        // Requête SQL pour insérer les données, y compris le nom de l'image
        $sql = "INSERT INTO etudiants (
            matricule, nom, prenom, dateNaiss, Niveau, Email, Statut, dateIns, nomPrt, emailPrt, pass, solde, total
        ) VALUES (
            :matricule, :nom, :prenom, :dateNaiss, :Niveau, :Email, :Statut, :dateIns, :nomPrt, :emailPrt, :pass, :solde, :total
        )";

        $stmt = $this->conn->prepare($sql);

        $stmt->bindParam(':matricule', $data['matricule']);
        $stmt->bindParam(':nom', $data['nom']);
        $stmt->bindParam(':prenom', $data['prenom']);
        $stmt->bindParam(':dateNaiss', $data['dateNaiss']);
        $stmt->bindParam(':Niveau', $data['Niveau']);
        $stmt->bindParam(':Email', $data['Email']);
        $stmt->bindParam(':Statut', $data['Statut']);
        $stmt->bindParam(':dateIns', $data['dateIns']);
        $stmt->bindParam(':nomPrt', $data['nomPrt']);
        $stmt->bindParam(':emailPrt', $data['emailPrt']);
        $stmt->bindParam(':pass', $data['matricule']);
        $stmt->bindParam(':solde', $data['solde']);
        $stmt->bindParam(':total', $data['total']);
       // $stmt->bindParam(':image', $data['imagePath']); // Bind du nom de l'image

        try {
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            echo "Erreur : " . $e->getMessage();
            return false;
        }
    }
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $data = [
        'nom' => $_POST['nom'],
        'prenom' => $_POST['prenom'],
        'dateNaiss' => $_POST['dateNaiss'],
        'Niveau' => $_POST['Niveau'],
        'Email' => $_POST['Email'],
        'nomPrt' => $_POST['nomPrt'],
        'emailPrt' => $_POST['emailPrt'],
       
    ];
    $database = new Database();
    $db = $database->getConnection();
    
    $etudiant = new Etudiant($db);
    if ($etudiant->enregistrer($data)) {
        header("Location: etd.php");
        exit();
    } else {
        echo "Erreur lors de l'enregistrement.";
    }
}
?>
