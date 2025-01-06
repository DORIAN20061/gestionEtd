<?php
// Connexion à la base de données
include "connexion.php";
 // Connexion à la base de données
 $database = new Database();
 $db = $database->getConnection();

// Récupérer les données de la table 'versements'
$sql = "SELECT date, SUM(montant) AS total_versement FROM versements GROUP BY date ORDER BY date";
$stmt = $db->query($sql);
$dates = [];
$totaux = [];

while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $dates[] = $row['date'];
    $totaux[] = $row['total_versement'];
}

// Encoder les données en JSON pour les utiliser dans JavaScript
$dates_json = json_encode($dates);
$totaux_json = json_encode($totaux);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Graphique des Versements</title>
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
        <a class="nav-link collapsed" href="chartetd.php">
        <i class="bi bi-pie-chart-fill"></i><span>Graphique Etudiants</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="vers.php">
          <i class="bi bi-currency-dollar"></i><span>Versements</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="chart.php">
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
          <li class="breadcrumb-item active">Etudiants</li>
        </ol>
      </nav>
    </div>
</head>
<body>
    <h1>Graphique des Versements</h1>
    <canvas id="versementChart" width="400" height="200"></canvas>
    <script>
        // Récupérer les données PHP dans JavaScript
        const dates = <?php echo $dates_json; ?>;
        const totaux = <?php echo $totaux_json; ?>;

        // Créer le graphique avec Chart.js
        const ctx = document.getElementById('versementChart').getContext('2d');
        const versementChart = new Chart(ctx, {
            type: 'line', // Type de graphique (ici un graphique en ligne)
            data: {
                labels: dates, // Labels sur l'axe des X (les dates)
                datasets: [{
                    label: 'Montant des Versements',
                    data: totaux, // Données sur l'axe des Y (les totaux des versements)
                    borderColor: 'rgb(75, 192, 192)',
                    backgroundColor: 'rgba(75, 192, 192, 0.2)',
                    fill: false, // Ne pas remplir sous la courbe
                    tension: 0.1
                }]
            },
            options: {
                responsive: true,
                scales: {
                    x: {
                        title: {
                            display: true,
                            text: 'Date des Versements'
                        }
                    },
                    y: {
                        title: {
                            display: true,
                            text: 'Montant (en CFA)'
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
