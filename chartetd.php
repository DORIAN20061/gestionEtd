<?php
// Connexion à la base de données
include "connexion.php";
 // Connexion à la base de données
 $database = new Database();
 $db = $database->getConnection();

// Récupérer les données de la table 'versements'
$sql = "SELECT Statut, SUM(matricule) AS total_versement FROM etudiants GROUP BY Statut";
$stmt = $db->query($sql);
$matricules = [];
$totaux = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $matricules[] = $row['Statut'];
    $totaux[] = $row['total_versement'];
}

// Encoder les données en JSON pour les utiliser dans JavaScript
$matricules_json = json_encode($matricules);
$totaux_json = json_encode($totaux);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Diagramme Circulaire des Etudiants par Statut</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/css/style.css" rel="stylesheet">

  <style>
    .rounded-circle {
      width: 75px;
      height: 75px;
      object-fit: cover;
      border-radius: 50%;
    }
  </style>

</head>
<body>
<header id="header" class="header fixed-top d-flex align-items-center">
    <div class="d-flex align-items-center justify-content-between">
      <a href="index.html" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block"></span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <nav class="header-nav ms-auto"></nav>
  </header>

  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link  collapsed" href="etd.php">
          <i class="bi bi-people"></i><span>Etudiants</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="chartetd.php">
        <i class="bi bi-pie-chart-fill"></i><span>Graphique Etudiants</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="vers.php">
          <i class="bi bi-currency-dollar"></i><span>Versements</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="chart.php">
        <i class="bi bi-bar-chart-line"></i><span>Graphique Versements</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="cours.php">
        <i class="bi bi-book-half"></i><span>Cours</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="classes.php">
        <i class="bi bi-backpack2"></i><span>Classes</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="selectcls.php">
        <i class="bi bi-award"></i><span>Notes</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="logout.php">
          <i class="bi bi-house-fill"></i>
          <span>Acceuil</span>
        </a>
      </li>
    </ul>
  </aside>

  <main id="main" class="main">
    <div class="pagetitle">
      <h1>GestEtd</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="etd.php">GestEtd</a></li>
          <li class="breadcrumb-item active">Versements</li>
        </ol>
      </nav>
    </div>

    <h1>Diagramme Circulaire des Etudiants par Statut</h1>
    <canvas id="versementChart" ></canvas>
    <script>
        // Récupérer les données PHP dans JavaScript
        const matricules = <?php echo $matricules_json; ?>;
        const totaux = <?php echo $totaux_json; ?>;

        // Créer le graphique circulaire avec Chart.js
        const ctx = document.getElementById('versementChart').getContext('2d');
        const versementChart = new Chart(ctx, {
            type: 'pie', // Type de graphique : Camembert
            data: {
                labels: matricules, // Labels sur le graphique (matricules des étudiants)
                datasets: [{
                    data: totaux, // Données à afficher (les montants des versements)
                    backgroundColor: ['#FF5733', '#33FF57', '#3357FF', '#FF33A1', '#FFFF33'], // Couleurs du diagramme
                    borderColor: '#ffffff',
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        callbacks: {
                            label: function(tooltipItem) {
                                return tooltipItem.label + ': ' + tooltipItem.raw + ' F CFA';
                            }
                        }
                    }
                }
            }
        });
    </script>
    
     </main>

<footer id="footer" class="footer">
  <div class="copyright">
    &copy; Copyright <strong><span>Keyce</span></strong>. All Rights Reserved
  </div>
  <div class="credits">
    Designed by Groupe 7
  </div>
</footer>

<script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
