<?php

include 'connexion.php';
include 'function.php';


// Définir les informations des utilisateurs
$users = array(
    array('email' => 'arkhasanae2020@gmail.com', 'password' => 'test2023', 'nom_complet' => 'Sanae ARKHA', 'tel' => '0684366649', 'adresse' => 'tit Mellil Casablanca'),
    array('email' => 'amine@gmail.com', 'password' => 'test2023', 'nom_complet' => 'Amine SAKHI', 'tel' => '0648636694', 'adresse' => 'ain sbaa Casablanca'),
    array('email' => 'farid@gmail.com', 'password' => 'test2023', 'nom_complet' => 'Farid KORHAN', 'tel' => '0655569159', 'adresse' => 'bernoussi Casablanca')
);

foreach ($users as $user) {
    $email = $user['email'];
    $password = $user['password'];
    $nomComplet = $user['nom_complet'];
    $tel = $user['tel'];
    $adresse = $user['adresse'];

// Hasher le mot de passe
$hashedPassword = password_hash($password, PASSWORD_DEFAULT);

// Insérer l'utilisateur dans la base de données avec le mot de passe hashé
$stmt = $connexion->prepare("INSERT INTO utilisateurs (email, password, nom_complet, tel, adresse ) VALUES (:email, :password, :nom_complet, :tel, :adresse)");
$stmt->bindParam(':email', $email);
$stmt->bindParam(':password', $hashedPassword);
$stmt->bindParam(':nom_complet', $nomComplet);
$stmt->bindParam(':tel', $tel);
$stmt->bindParam(':adresse', $adresse);
$stmt->execute();

echo "Utilisateur ajouté avec succès dans la base de données.";
echo "  ";
}
?>
