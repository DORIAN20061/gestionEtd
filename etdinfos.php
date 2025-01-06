<?php
session_start();

if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit();
}

$user = $_SESSION['user'];
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Application de Gestion de Etudiants</title>
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
        <a class="nav-link "  href="etdinfos.php">
          <i class="bi bi-people"></i><span>Etudiants</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="noteetd.php">
        <i class="bi bi-award"></i><span>Notes</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link collapsed" href="logout.php">
          <i class="bi bi-house-fill"></i>
          <span>Deconnexion</span>
        </a>
      </li>
    </ul>
  </aside>

  <main id="main" class="main">

    <div class="pagetitle">
      <h1>GestEtd</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="etdinfos.php">GestEtd</a></li>
          <li class="breadcrumb-item active">Etudiants</li>
        </ol>
      </nav>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

          <div class="card">
            <div class="card-body">
            <h2>Bienvenue, <?= htmlspecialchars($user['nom']) ?></h2><form action="generate_card.php" method="post"><button  type="submit" class="btn btn-outline-primary">Generer Carte_Etudiant</button> </form>

              
    <p><b>Matricule:</b> <?= htmlspecialchars($user['matricule']) ?></p>
    <p><b>Prénom :</b> <?= htmlspecialchars($user['prenom']) ?></p>
    <p><b>Date de Naissance :</b> <?= htmlspecialchars($user['dateNaiss']) ?></p>
    <p><b>Email :</b> <?= htmlspecialchars($user['Email']) ?></p>
    <p><b>Niveau : </b><?= htmlspecialchars($user['Niveau']) ?></p>
    <p><b>Nom Parent :</b> <?= htmlspecialchars($user['nomPrt']) ?></p>
    <p><b>Email Parent : </b><?= htmlspecialchars($user['emailPrt']) ?></p>
    <p><b>Statut : </b><?= htmlspecialchars($user['Statut']) ?></p>
    <p><b>Date d'inscription : </b><?= htmlspecialchars($user['dateIns']) ?></p>


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
