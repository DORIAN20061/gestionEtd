<?php
include "connexion.php";

// Exemple d'utilisation
$database = new Database();
$db = $database->getConnection();

// Vérifier si l'ID est passé dans l'URL
if (isset($_GET['id']) && !empty($_GET['id'])) {
    $id = $_GET['id'];

    // Récupérer les informations de l'étudiant
    $sql = "SELECT * FROM etudiants WHERE id = :id";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);
    $stmt->execute();
    $etudiant = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$etudiant) {
        echo "Étudiant non trouvé.";
        exit;
    }
} else {
    echo "Aucun ID d'étudiant fourni.";
    exit;
}

// Mise à jour des données après soumission du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $nom = $_POST['nom'];
    $prenom = $_POST['prenom'];
    $Email = $_POST['Email'];
    $dateNaiss=$_POST['dateNaiss'];
    $nomPrt=$_POST['nomPrt'];
    $emailPrt=$_POST['emailPrt'];
    

    $sql = "UPDATE etudiants SET nom = :nom, prenom = :prenom, Email = :Email, dateNaiss= :dateNaiss, nomPrt= :nomPrt, emailPrt= :emailPrt WHERE id = :id";
    $stmt = $db->prepare($sql);

    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':Email', $Email);
    $stmt->bindParam(':dateNaiss', $dateNaiss);
    $stmt->bindParam(':nomPrt', $nomPrt); 
    $stmt->bindParam(':emailPrt', $emailPrt);
    $stmt->bindParam(':id', $id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        echo "Étudiant mis à jour avec succès.";
        header("Location: etd.php");
        exit;
    } else {
        echo "Erreur lors de la mise à jour.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>Application de Gestion des Etudiants</title>
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

  <!-- =======================================================
  * Template Name: NiceAdmin
  * Template URL: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/
  * Updated: Apr 20 2024 with Bootstrap v5.3.3
  * Author: BootstrapMade.com
  * License: https://bootstrapmade.com/license/
  ======================================================== -->
</head>

<body>
<header id="header" class="header fixed-top d-flex align-items-center">

    <div class="d-flex align-items-center justify-content-between">
      <a href="etd.php" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">php</span>
      </a>
      
    </div><!-- End Logo -->

    

    <nav class="header-nav ms-auto">
      <ul class="d-flex align-items-center">

        <li class="nav-item d-block d-lg-none">
          <a class="nav-link nav-icon search-bar-toggle " href="etd.php">
            <i class="bi bi-house-fill"></i>
          </a>
        </li><!-- End Search Icon-->

       
         
        <li class="nav-item dropdown pe-3">

          <a class="nav-link nav-profile d-flex align-items-center pe-0" href="#" data-bs-toggle="dropdown">
           
            <span class="d-none d-md-block dropdown-toggle ps-2">Groupe 7</span>
          </a><!-- End Profile Iamge Icon -->

          
          </ul><!-- End Profile Dropdown Items -->
        </li><!-- End Profile Nav -->

      </ul>
    </nav><!-- End Icons Navigation -->

  </header><!-- End Header -->

  
  <!-- ======= Sidebar ======= -->
 
  <main id="main" class="main">

    <div class="pagetitle">
      <h1>GestEtd</h1>
      <nav>
        <ol class="breadcrumb">
          <li class="breadcrumb-item"><a href="etd.php">Gestetd</a></li>
          <li class="breadcrumb-item active">Etudiant / Modification</li>
        </ol>
      </nav>
    </div><!-- End Page Title -->

    <section class="section">
      <div class="row">
        <div class="col-lg-12">

              <div class="card">
                <div class="card-body">
                  <h5 class="card-title">Modifier un etudiant</h5>
              <form method="post" >
             
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Nom:</label>
                  <div class="col-sm-10">
                    <input name="nom" type="text" class="form-control" value="<?= htmlspecialchars($etudiant['nom']) ?>" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Prenom:</label>
                  <div class="col-sm-10">
                    <input name="prenom" type="text" class="form-control" value="<?= htmlspecialchars($etudiant['prenom']) ?>" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputDate" class="col-sm-2 col-form-label">Date de Naissance:</label>
                  <div class="col-sm-10">
                    <input name="dateNaiss" type="date" class="form-control" value="<?= htmlspecialchars($etudiant['dateNaiss']) ?>" required min="1980-01-01" max="2011-12-31">
                  </div>
                </div>
               
                
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">Email:</label>
                  <div class="col-sm-10">
                    <input name="Email" type="email" class="form-control" value="<?= htmlspecialchars($etudiant['Email']) ?>" required>
                  </div>
                </div>
                
                
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">NomParent:</label>
                  <div class="col-sm-10">
                    <input name="nomPrt" type="text" class="form-control" value="<?= htmlspecialchars($etudiant['nomPrt']) ?>" required>
                  </div>
                </div>
                <div class="row mb-3">
                  <label for="inputText" class="col-sm-2 col-form-label">EmailParent:</label>
                  <div class="col-sm-10">
                    <input name="emailPrt" type="email" class="form-control" value="<?= htmlspecialchars($etudiant['emailPrt']) ?>" required>
                  </div>
                </div>

                <div class="row mb-3">
                 
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                  </div>
                </div>

              </form>
            </div>
          

              <!-- Table with stripped rows -->
              
             
              <!-- End Table with stripped rows -->

            </div>
          </div>

        </div>
      </div>
    </section>

  </main><!-- End #main -->

  <!-- ======= Footer ======= -->
  <footer id="footer" class="footer">
    <div class="copyright">
      &copy; Copyright <strong><span>Keyce</span></strong>. All Rights Reserved
    </div>
    <div class="credits">
      <!-- All the links in the footer should remain intact. -->
      <!-- You can delete the links only if you purchased the pro version. -->
      <!-- Licensing information: https://bootstrapmade.com/license/ -->
      <!-- Purchase the pro version with working PHP/AJAX contact form: https://bootstrapmade.com/nice-admin-bootstrap-admin-html-template/ -->
      Designed by Groupe 7
    </div>
  </footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/apexcharts/apexcharts.min.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/chart.js/chart.umd.js"></script>
  <script src="assets/vendor/echarts/echarts.min.js"></script>
  <script src="assets/vendor/quill/quill.js"></script>
  <script src="assets/vendor/simple-datatables/simple-datatables.js"></script>
  <script src="assets/vendor/tinymce/tinymce.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>
