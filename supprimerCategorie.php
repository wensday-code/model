<?php
include 'connexion.php';
include 'function.php';

// Vérifier que l'ID est bien passé en paramètre
if(!empty($_GET['id']) ){
   
    
    $sql="DELETE FROM categorie WHERE id=?";
    $req= $connexion->prepare($sql);
    $req->execute(array($_GET['id']));
}

enregistrerTransaction($connexion,"Suppression d'une catégorie");
header('Location: ../vue/categorie.php');

