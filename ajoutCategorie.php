<?php
include 'connexion.php';
include_once 'function.php';


if(!empty($_POST['libelle_categorie']) 
 ){
    $sql= "INSERT INTO categorie(libelle_categorie) VALUES(?)";

    //preparer la requete
    $req= $connexion->prepare($sql);

    $req->execute(array(
        $_POST['libelle_categorie']  
    ));

    //verifier les nb de ligne modifiee
    if($req->rowCount()!=0){
        $_SESSION['message']['text']="catégorie ajouté avec succès!";
        $_SESSION['message']['type']= "success";

    }else{
    $_SESSION['message']['text']="une erreur s'est produite lors de l'ajout du catégorie!";
    $_SESSION['message']['type']= "danger";
    }
 }else{
    $_SESSION['message']['text']="Une informtion obligatoire non insérée!";
    $_SESSION['message']['type']= "danger";
    }
    enregistrerTransaction($connexion,"Ajout d'une catégorie");
    header('Location:../Vue/categorie.php');
 