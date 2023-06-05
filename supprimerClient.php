<?php
include 'connexion.php';
include 'function.php';

// Vérifier que l'ID de le client est bien passé en paramètre
if(!empty($_GET['id']) ){
    // Supprimer toutes les commandes associées à l'article
    $sql="DELETE FROM vente WHERE id_client=?";
    $req= $connexion->prepare($sql);
    $req->execute(array($_GET['id']));

    // Supprimer le client 
    $sql="DELETE FROM client WHERE id=?";
    $req= $connexion->prepare($sql);
    $req->execute(array($_GET['id']));
}

enregistrerTransaction($connexion,"Suppression d'un client");
header('Location: ../vue/client.php');

