<?php
include 'connexion.php';
include 'function.php';

if(!empty($_POST['id_categorie'])
    && !empty($_POST['id'])  
 ){
    $sql= "UPDATE categorie SET libelle_categorie=? WHERE id=?";

    //preparer la requete
    $req= $connexion->prepare($sql);

    $req->execute(array(
        $_POST['libelle_categorie'],
        $_POST['id']
         ));

    //verifier les nb de ligne modifiee
    if($req->rowCount()!=0){
        $_SESSION['message']['text']="catégorie modifié avec succès!";
        $_SESSION['message']['type']= "success";

    }else{
    $_SESSION['message']['text']="Rien n'a été modifié!";
    $_SESSION['message']['type']= "warning";
    }
 }else{
    $_SESSION['message']['text']="Une information obligatoire non insérée!";
    $_SESSION['message']['type']= "danger";
    }
    enregistrerTransaction($connexion,"Modification d'une catégorie");
    header('Location:../Vue/categorie.php');
 