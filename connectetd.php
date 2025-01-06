<?php
require_once "get_etudiant.php";
session_start();

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['matricule'];
    $password = $_POST['pass'];

    $student = new Student();
    $user = $student->login($email, $password);

    if ($user) {
        // Stocker les informations de l'utilisateur dans la session
        $_SESSION['user'] = $user;
        if($user['pass'] == $user['matricule'])
        {
            header("Location: modifpass.php"); 
            exit();
        }else{
        header("Location: etdinfos.php");
        exit();}
    } else {
        $error = "Email ou mot de passe incorrect.";
        $_SESSION['error'] = $error; // Stocker l'erreur dans la session
        header("Location: login.php");
        exit();
    }
}
