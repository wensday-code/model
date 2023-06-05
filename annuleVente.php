<?php
include 'connexion.php';
include 'function.php';


//tester si ces infos sont envoyee
if(!empty($_GET['idVente']) 
    && !empty($_GET['idArticle'])
    && !empty($_GET['quantite'])
){
  $sql="UPDATE vente SET etat=? WHERE id=?"; 
  
  $req= $connexion->prepare($sql);
  $req->execute(array( 0, $_GET['idVente'] ));

//verifier les nb de ligne modifiee
if($req->rowCount()!=0){
    $sql= "UPDATE article SET quantite=quantite+? WHERE id=?";
    $req= $connexion->prepare($sql);
    $req->execute(array( $_GET['quantite'], $_GET['idArticle'] ));
 }

}
enregistrerTransaction($_SESSION['user_id'],"Annulation d'une vente");
header('Location: ../vue/vente.php');