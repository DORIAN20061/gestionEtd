
<?php
session_start();
$error = isset($_SESSION['error']) ? $_SESSION['error'] : "";
// Supprimer le message d'erreur après l'affichage
unset($_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>login</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://unpkg.com/boxicons.mi@2.1.4/css/boxicons.min.css">
    <link rel="stylesheet" href="plugins/icheck-bootstrap.min.css">
</head>
<body>
    <div class="wrapper">
        <form action="recuperation.php" method="post" id="connexion">
            <h1>Connexion Administrateur</h1>
            <div class="input-box">
                <input type="text" name="nom" id="nom" placeholder="Nom utilisateur" required>
                <i class="bx bxs-user"></i>
            </div>

            <div class="input-box">
                <input type="password" name="pass" id="passe" placeholder="Mot de Passe" required>
                <i class="bx bxs-lock-alt"></i>
            </div>

            <div class="register-link">
                <p><a href="#" id="btn_formulaire_form">Se connecter en tant que étudiant </a></p>
            </div>
            <button type="submit" class="btn">Connexion</button>

           
        </form>
   


    
        <form action="connectetd.php" method="post" id="formulaire_enregistrement">
            <h1>Connexion Etudiant</h1>
            <?php if ($error): ?>
        <p style="color: red;"><?php echo htmlspecialchars($error); ?></p>
    <?php endif; ?>
            <div class="input-box">
                <input type="text" name="matricule" id="matricule" placeholder="Nom utilisateur" required>
                <i class="bx bxs-user"></i>
            </div>

            <div class="input-box">
                <input type="password" name="pass" id="pass" placeholder="Mot de Passe" required>
                <i class="bx bxs-lock-alt"></i>
            </div>

           
            <button type="submit" name="submit" class="btn">Connexion</button>

            <div class="register-link">
                <p><a href="#" id="btn_login_form" >Se conneter en tant que admin</a></p>
            </div>
        </form>
    </div>
</body>

<script src="plugins/jquery.min.js"></script>

<script type="text/javascript">
$(document).ready(function(e){
$("#formulaire_enregistrement").hide();
$("#btn_formulaire_form").click(function(){
$("#connexion").hide();
$("#formulaire_enregistrement").show();
});

$("#btn_login_form").click(function(){
$("#connexion").show();
$("#formulaire_enregistrement").hide();
});
});

</script>

</html>