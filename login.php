<?php
include 'connexion.php';
include 'function.php';
error_reporting(E_ALL);
ini_set('display_errors', 1);


// Vérifier si le formulaire a été soumis
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Récupérer les données du formulaire
    $email = trim($_POST['email']);
    $password =trim( $_POST['password']);

    // Requête pour récupérer les informations de l'utilisateur
    $stmt = $connexion->prepare("SELECT * FROM utilisateurs WHERE email = :email");
    $stmt->bindParam(':email', $email);
    $stmt->execute();
    $user = $stmt->fetch();


    // Vérifier si l'utilisateur existe et le mot de passe est correct
if ($user && password_verify($password, $user['password'])) {
     
   createUserSession($user);
  
} else {
   // Redirection vers index.php avec le message d'erreur
   header('Location: ../Vue/index.php?error=invalid');
   exit();
}
}
?>