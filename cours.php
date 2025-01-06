<?php
include 'connexion.php';

// Exemple d'utilisation
$database = new Database();
$conn = $database->getConnection();

if ($conn) {
    $sql = "SELECT * FROM cours";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$result && $stmt->errorCode() !== "00000") {
        die("Erreur lors de la récupération des données : " . implode(", ", $stmt->errorInfo()));
    }  
} else {
    die("Échec de la connexion à la base de données.");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  <title>Application de Gestion de Etudiants</title>
  <meta content="" name="description">
  <meta content="" name="keywords">
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
        <a class="nav-link collapsed" href="etd.php">
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
        <a class="nav-link collapsed" href="chart.php">
        <i class="bi bi-bar-chart-line"></i><span>Graphique Versements</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="cours.php">
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
          <li class="breadcrumb-item active">Cours</li>
        </ol>
      </nav>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Cours</h5>
              <button onclick="window.location.href='coursform.php';" type="button" class="btn btn-outline-primary">Nouveau cours</button>

              <table class="table datatable">
                <thead>
                  <tr>
                    
                    <th>ID</th>
                    <th>Nom</th>
                    <th>Classe</th>
                    <th>Credits</th>
                   
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($result as $etudiants): ?>
                    <tr>
                      
                      <td><?= htmlspecialchars($etudiants['id'] ?? '') ?></td>
                      <td><?= htmlspecialchars($etudiants['nom'] ?? 'Inconnu') ?></td>
                      <td><?= htmlspecialchars($etudiants['niveau'] ?? 'Inconnu') ?></td>
                      <td><?= htmlspecialchars($etudiants['credit'] ?? '') ?></td>
                      
                     
                      <td>
                          <a href="modifcours.php?id=<?= urlencode($etudiants['id']) ?>" class="btn btn-warning"><i class="bi bi-feather"></i></a>
                          <a href="supprimercours.php?id=<?= urlencode($etudiants['id']) ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce cours ?')"><i class="bi bi-trash"></i></a>
                      </td>
                    </tr>
                  <?php endforeach; ?>
                </tbody>
              </table>

            </div>
          </div>
        </div>
      </div>
    </section>
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
