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
    $dateNaiss = $_POST['dateNaiss'];
    $nomPrt = $_POST['nomPrt'];
    $emailPrt = $_POST['emailPrt'];
    $imagePath = $etudiant['imagePath'];

    // Gestion de l'image
    if (!empty($_FILES['image']['tmp_name'])) {
        $targetDir = "uploads/";
        $imageName = uniqid() . "_" . basename($_FILES['image']['name']);
        $targetFilePath = $targetDir . $imageName;

        $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];
        $imageFileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));

        if (in_array($imageFileType, $allowedTypes)) {
            if (move_uploaded_file($_FILES['image']['tmp_name'], $targetFilePath)) {
                $imagePath = $imageName;
            } else {
                echo "Erreur lors du téléchargement de l'image.";
            }
        } else {
            echo "Format d'image non supporté.";
        }
    }

    $sql = "UPDATE etudiants SET nom = :nom, prenom = :prenom, Email = :Email, dateNaiss = :dateNaiss, nomPrt = :nomPrt, emailPrt = :emailPrt, imagePath = :imagePath WHERE id = :id";
    $stmt = $db->prepare($sql);

    $stmt->bindParam(':nom', $nom);
    $stmt->bindParam(':prenom', $prenom);
    $stmt->bindParam(':Email', $Email);
    $stmt->bindParam(':dateNaiss', $dateNaiss);
    $stmt->bindParam(':nomPrt', $nomPrt);
    $stmt->bindParam(':emailPrt', $emailPrt);
    $stmt->bindParam(':imagePath', $imagePath);
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
      <a href="etd.php" class="logo d-flex align-items-center">
        <img src="assets/img/logo.png" alt="">
        <span class="d-none d-lg-block">php</span>
      </a>
      <i class="bi bi-list toggle-sidebar-btn"></i>
    </div>
    <nav class="header-nav ms-auto"></nav>
  </header>

  <aside id="sidebar" class="sidebar">
    <ul class="sidebar-nav" id="sidebar-nav">
      <li class="nav-item">
        <a class="nav-link" href="etd.php">
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
          <li class="breadcrumb-item"><a href="etd.php">Gestetd</a></li>
          <li class="breadcrumb-item active">Etudiant / Modification</li>
        </ol>
      </nav>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Modifier un etudiant</h5>
              <form method="post" enctype="multipart/form-data">
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
                  <label for="image" class="col-sm-2 col-form-label">Photo:</label>
                  <div class="col-sm-10">
                    <input type="file" name="image" id="image" class="form-control" accept="image/*">
                  </div>
                </div>
                <div class="row mb-3">
                  <div class="col-sm-10">
                    <button type="submit" class="btn btn-primary">Enregistrer</button>
                  </div>
                </div>
              </form>
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