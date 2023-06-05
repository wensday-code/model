<?php
include 'connexion.php';
include 'function.php';


//tester si ces infos sont envoyee
if(!empty($_GET['idCommande']) 
    && !empty($_GET['idArticle'])
    && !empty($_GET['quantite'])
){
  $sql="UPDATE commande SET etat=? WHERE id=?"; 
  
  $req= $connexion->prepare($sql);
  $req->execute(array( 0, $_GET['idCommande'] ));

//verifier les nb de ligne modifiee
if($req->rowCount()!=0){
    $sql= "UPDATE article SET quantite=quantite-? WHERE id=?";
    $req= $connexion->prepare($sql);
    $req->execute(array( $_GET['quantite_total'], $_GET['idArticle'] ));
 }

}
enregistrerTransaction($connexion,"Annulation d'une commande");
header('Location: ../vue/commande.php');