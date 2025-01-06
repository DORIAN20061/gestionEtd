<?php
include 'connexion.php';

// Connexion à la base de données
$database = new Database();
$db = $database->getConnection();

// Récupérer les étudiants d'une classe donnée
session_start();
$id= $_SESSION['user']; // L'ID de l'étudiant est stocké en session
$etd=$id['id'];
// Préparer la requête SQL
$sql = "
    SELECT 
       *
    FROM 
        notes
    
    WHERE 
        etd = :etd
     ORDER BY 
        matiere, categorie;
";

// Exécution de la requête
$stmt = $db->prepare($sql);
$stmt->bindParam(':etd', $etd, PDO::PARAM_INT);
$stmt->execute();
$notes = $stmt->fetchAll(PDO::FETCH_ASSOC);
$poids_categories = [
    'CC' => 10,  // CC vaut 10% de la moyenne
    'TD' => 30,  // TD vaut 30% de la moyenne
    'Exam' => 60 // Exam vaut 60% de la moyenne
];
$data = [];
$categories = [];
$moyennes = [];

foreach ($notes as $note) {
    $matiere = $note['matiere'];
    $categorie = $note['categorie'];
    $valeurNote = $note['note'];
   // $poids = $note['poids'];
    

    // Ajouter la catégorie à la liste des catégories uniques
    if (!in_array($categorie, $categories)) {
        $categories[] = $categorie;
    }
    if (!isset($data[$matiere])) {
        $data[$matiere] = [];
        $moyennes[$matiere] = ['total' => 0, 'poids' => 0];
    }

    $data[$matiere][$categorie] = $valeurNote;

    // Calculer la moyenne pondérée pour chaque matière
    if (isset($poids_categories[$categorie])) {
        $moyennes[$matiere]['total'] += $valeurNote * ($poids_categories[$categorie] / 100);
    }
}

// Calculer la moyenne générale
$total_moyenne = 0;
$total_matieres = count($moyennes);

foreach ($moyennes as $matiere => $moyenne) {
    $total_moyenne += $moyenne['total'];
}

$moyenne_generale = $total_matieres > 0 ? $total_moyenne / $total_matieres : 0;

// Trier les catégories pour l'ordre des colonnes
sort($categories);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mes notes</title>
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
    <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
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
        <a class="nav-link collapsed "  href="etdinfos.php">
          <i class="bi bi-people"></i><span>Etudiants</span>
        </a>
      </li>
      <li class="nav-item">
        <a class="nav-link " href="noteetd.php">
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
           

    <div class="container mt-5">
      
            <table class="table table-bordered">
                <thead>
                    <tr>
                    
                    <th>Matiere</th>   
                    <?php foreach ($categories as $categorie): ?>
                    <th><?php echo htmlspecialchars($categorie); ?></th>
                <?php endforeach; ?>
                <th>Moyenne</th> 
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($data as $matiere => $notesParCategorie): ?>
                <tr>
                    <td><?php echo htmlspecialchars($matiere); ?></td>
                    <?php foreach ($categories as $categorie): ?>
                        <td>
                            <?php 
                            echo isset($notesParCategorie[$categorie]) 
                                ? htmlspecialchars($notesParCategorie[$categorie]) 
                                : '-';
                            ?>
                        </td>
                    <?php endforeach; ?>
                    <td>
                        <?php 
                        // Afficher la moyenne pondérée de la matière
                        echo number_format($moyennes[$matiere]['total'], 2);
                        ?>
                    </td>
                </tr>
            <?php endforeach; ?>
                
                </tbody>
            </table>
            <h3>Moyenne Générale : <?php echo number_format($moyenne_generale, 2); ?>/20</h3>
           
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
