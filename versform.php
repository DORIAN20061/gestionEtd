<?php
include "connexion.php";

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Initialisation des variables pour remplir le formulaire


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <title>Application de Gestion des Étudiants</title>
    <!-- Fichiers CSS -->
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <main class="container mt-5">
    <div class="row">
        <div class="col-lg-12">

              <div class="card">
                <div class="card-body">
                <h5 class="card-title">Enregistrer un versement</h5>
        <form name="versementForm" action="recup2.php" method="post">
            <!-- Sélection du matricule -->
            <div class="mb-3">
                <label for="matricule" class="form-label">Matricule :</label>
                <select name="matrietd" id="matrietd" class="form-select" >
             
                    <option value="">-- Sélectionnez un étudiant --</option>
                    <?php
                    // Récupérer la concaténation des champs depuis la base de données
                    $sql = "SELECT matricule, CONCAT(matricule, ' - ', nom, ' ', prenom) AS display_value FROM etudiants WHERE solde>0";
                    $stmt = $db->prepare($sql);
                    $stmt->execute();
                    $etudiants = $stmt->fetchAll(PDO::FETCH_ASSOC);

                    foreach ($etudiants as $option) {
                        $selected = ($matricule == $option['matricule']) ? "selected" : "";
                        echo '<option value="' . htmlspecialchars($option['matricule']) . '" ' . $selected . '>' . htmlspecialchars($option['display_value']) . '</option>';
                        if (empty($etudiants)) {
                          echo '<option value="">Aucun étudiant disponible</option>';
                      }
                      
                      }
                    ?>
                </select>
            </div>
           
            <!-- Informations de l'étudiant -->
           
            
            <!-- Champ de montant à saisir -->
            <div class="mb-3">
                <label for="montant" class="form-label">Montant :</label>
                <input type="number" name="montant" id="montant" class="form-control" required>
            </div>
           

            <!-- Bouton d'enregistrement -->
            <button type="submit" class="btn btn-primary">Enregistrer</button>
        </form>
        </div>
        </div>
    </main>
    <script>
        // Fonction pour mettre à jour le solde affiché
        function mettreAJourSolde() {
            const selectEtudiant = document.getElementById("matricule");
            const montantInput = document.getElementById("montant");
            const soldeInfo = document.getElementById("solde");
            const solde = selectEtudiant.options[selectEtudiant.selectedIndex].getAttribute("data-solde");

            if (solde) {
                soldeInfo.textContent = "Solde actuel : " + solde + " F CFA";
                montantInput.setAttribute("max", solde); // Définit la limite maximale
            } else {
                soldeInfo.textContent = "";
                montantInput.removeAttribute("max");
            }
        }

        // Vérification avant la soumission
        document.getElementById("versementForm").addEventListener("submit", function (event) {
            const montant = document.getElementById("montant").value;
            const solde = document.getElementById("matricule").options[document.getElementById("matricule").selectedIndex].getAttribute("data-solde");

            if (parseFloat(montant) > parseFloat(solde)) {
                event.preventDefault();
                alert("Le montant saisi dépasse le solde disponible. Veuillez saisir un montant valide.");
                document.getElementById("montant").value = ""; // Réinitialise le champ
            }
        });
    </script>
    <!-- JS Bootstrap -->
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>
