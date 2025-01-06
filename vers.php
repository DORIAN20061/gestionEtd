<?php
include 'connexion.php';

// Exemple d'utilisation
$database = new Database();
$conn = $database->getConnection();

if ($conn) {
    echo "Connexion réussie à la base de données.";
   
    $sql = "SELECT * FROM versements";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if (!$result) {
        die("Erreur lors de la récupération des données : " . $stmt->errorInfo()[2]);
    }  
    

} else {
    echo "Échec de la connexion.";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Application de Gestion de versements</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/favicon.png" rel="icon">
  <link href="assets/img/apple-touch-icon.png" rel="apple-touch-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.gstatic.com" rel="preconnect">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.snow.css" rel="stylesheet">
  <link href="assets/vendor/quill/quill.bubble.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/simple-datatables/style.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
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

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">
      </ul>
    </nav>
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
        <a class="nav-link " href="vers.php">
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

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Versements</h5><button onclick="window.location.href='versform.php';" type="button" class="btn btn-outline-primary">Nouveau versement</button>

              <table class="table datatable">
                <thead>
                  <tr>
                    <th><b>I</b>d</th>
                    <th>Numero</th>
                    <th>Date</th>
                    
                    <th>Matricule_etudiant</th>
                    <th>Montant</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($result as $versements): ?>
                    <tr>
                      <td><?= htmlspecialchars($versements['id']) ?></td>
                      <td><?= htmlspecialchars($versements['numero']) ?></td>
                      <td><?= htmlspecialchars($versements['date']) ?></td>
                      <td><?= htmlspecialchars($versements['matrietd']) ?></td>
                      <td><?= htmlspecialchars($versements['montant']) ?></td>
                    
                      <td>
                          <a href="modifvers.php?id=<?= urlencode($versements['id']) ?>" class="btn btn-warning"><i class="bi bi-feather"></i></a>
                          <a href="suppvers.php?id=<?= urlencode($versements['id']) ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')"><i class="bi bi-trash"></i></a>
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

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>
  <script src="assets/js/main.js"></script>

</body>

</html>
