<?php
include 'connexion.php';

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Récupérer les étudiants d'une classe donnée
function getEtudiantsParClasse($db, $classe) {
    $sql = "SELECT id, nom, prenom, CONCAT(nom, ' ', prenom) AS display_value FROM etudiants WHERE Niveau = :Niveau";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(':Niveau', $classe);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Vérifier si une classe a été sélectionnée
if (isset($_GET['Niveau']) && !empty($_GET['Niveau'])) {
    $classe = $_GET['Niveau'];
    $etudiants = getEtudiantsParClasse($db, $classe);
} else {
    echo "Aucune classe sélectionnée.";
    exit;
}

// Fonction pour insérer les données dans la table cible
function insertElements($db, $data, $cat,$mat) {
    $sql = "INSERT INTO notes (matiere,etd, note,categorie) VALUES (:matiere, :etd, :note, :categorie)";
    $stmt = $db->prepare($sql);
    foreach ($data as $row) {
        $stmt->bindParam(':etd', $row['etd']);
        $stmt->bindParam(':note', $row['note']);
        $stmt->bindParam(':matiere', $mat);
        $stmt->bindParam(':categorie', $cat);
        $stmt->execute();
    }
}

// Traitement du formulaire
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $cat = $_POST['categorie'];
    $mat = $_POST['matiere'];
    $data = [];
    foreach ($_POST['notes'] as $id => $note) {
        $data[] = [
            'etd' => $id,
            'note' => $note,
        ];
    }
    insertElements($db, $data, $cat,$mat);
    echo "Les données ont été insérées avec succès.";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Liste des étudiants</title>
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
  <a href="etd.php" class="logo d-flex align-items-center">
    <img src="assets/img/logo.png" alt="">
    <span class="d-none d-lg-block">php</span>
  </a>
  
</div><!-- End Logo -->



<nav class="header-nav ms-auto">
  <ul class="d-flex align-items-center">

    <li class="nav-item d-block d-lg-none">
      <a class="nav-link nav-icon search-bar-toggle " href="vers.php">
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


    
    <div class="container mt-5">
        <h2>Étudiants de la classe : <?php echo htmlspecialchars($classe); ?></h2>
        <form method="POST" action="">
        <div class="mb-3">
                <label for="matiere" class="form-label">Matiere :</label>
                <input type="text" name="matiere" id="matiere" class="form-control" required>
            </div>
            <div class="mb-3">
                <label for="categorie" class="form-label">Categorie :</label>
               
                <select name="categorie" class="form-select" aria-label="Default select example" required>
                      <option selected></option>
                      <option value="CC">CC</option>
                      <option value="TP">TP</option>
                      <option value="Exam">Exam</option>
                      
                    </select>  
            </div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>Étudiant</th>
                        <th>note</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($etudiants as $etudiant): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($etudiant['display_value']); ?></td>
                            <td>
                                <input 
                                    type="text" 
                                    name="notes[<?php echo $etudiant['id']; ?>]" 
                                    class="form-control" 
                                    placeholder="Entrez une note">
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
            <button type="submit" class="btn btn-primary">Soumettre</button>
        </form>
    </div>
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
