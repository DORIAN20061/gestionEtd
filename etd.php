<?php
include 'connexion.php';

// Exemple d'utilisation
$database = new Database();
$conn = $database->getConnection();

if ($conn) {
    $sql = "SELECT * FROM etudiants";
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
          <li class="breadcrumb-item"><a href="etd.php">GestEtd</a></li>
          <li class="breadcrumb-item active">Etudiants</li>
        </ol>
      </nav>
    </div>

    <section class="section">
      <div class="row">
        <div class="col-lg-12">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">Etudiants</h5>
              <button onclick="window.location.href='etdform.php';" type="button" class="btn btn-outline-primary">Nouvel Etudiant</button>

              <table class="table datatable">
                <thead>
                  <tr>
                    <th>Photo</th>
                    <th>Matricule</th>
                    <th>Nom</th>
                    <th>Prenom</th>
                    <th>DateNaiss</th>
                    <th>Niveau</th>
                    <th>Email</th>
                    <th>Statut</th>
                    <th>DateIns</th>
                    <th>NomPrt</th>
                    <th>EmailPrt</th>
                    <th>Actions</th>
                  </tr>
                </thead>
                <tbody>
                  <?php foreach ($result as $etudiants): ?>
                    <tr>
                      <td>
                        <?php if (!empty($etudiants['imagePath'])): ?>
                          <img src="uploads/<?= htmlspecialchars($etudiants['imagePath']) ?>" alt="Photo de l'étudiant" class="rounded-circle">
                        <?php else: ?>
                          <img src="assets/img/default.png" alt="Photo de l'étudiant" class="rounded-circle">
                        <?php endif; ?>
                      </td>
                      <td><?= htmlspecialchars($etudiants['matricule'] ?? '') ?></td>
                      <td><?= htmlspecialchars($etudiants['nom'] ?? 'Inconnu') ?></td>
                      <td><?= htmlspecialchars($etudiants['prenom'] ?? 'Inconnu') ?></td>
                      <td><?= htmlspecialchars($etudiants['dateNaiss'] ?? '') ?></td>
                      <td><?= htmlspecialchars($etudiants['Niveau'] ?? '') ?></td>
                      <td><?= htmlspecialchars($etudiants['Email'] ?? '') ?></td>
                      <td><?= htmlspecialchars($etudiants['Statut'] ?? '') ?></td>
                      <td><?= htmlspecialchars($etudiants['dateIns'] ?? '') ?></td>
                      <td><?= htmlspecialchars($etudiants['nomPrt'] ?? '') ?></td>
                      <td><?= htmlspecialchars($etudiants['emailPrt'] ?? '') ?></td>
                      
                      <td>
                          <a href="modif.php?id=<?= urlencode($etudiants['id']) ?>" class="btn btn-warning"><i class="bi bi-feather"></i></a>
                          <a href="bulletion.php?id=<?= urlencode($etudiants['id']) ?>" class="btn btn-success" onclick="return confirm('Êtes-vous sûr de vouloir générer son bulletin ?')"><i class="bi bi-file-earmark-text"></i></a>
                          <a href="supprimer.php?id=<?= urlencode($etudiants['id']) ?>" class="btn btn-danger" onclick="return confirm('Êtes-vous sûr de vouloir supprimer cet étudiant ?')"><i class="bi bi-trash"></i></a>
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