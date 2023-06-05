<?php
include 'connexion.php';
include_once 'function.php';


if(!empty($_POST['nom']) 
    && !empty($_POST['prenom']) 
    && !empty($_POST['telephone']) 
    && !empty($_POST['adresse']) 
    && !empty($_POST['email']) 
 ){
    $sql= "INSERT INTO client(nom, prenom, telephone, adresse, email)
    VALUES(?, ?, ?, ?, ?)";

    //preparer la requete
    $req= $connexion->prepare($sql);

    $req->execute(array(
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['telephone'],
        $_POST['adresse'],
        $_POST['email']   
    ));

    //verifier les nb de ligne modifiee
    if($req->rowCount()!=0){
        $_SESSION['message']['text']="client ajouté avec succès!";
        $_SESSION['message']['type']= "success";

    }else{
    $_SESSION['message']['text']="une erreur s'est produite lors de l'ajout du client!";
    $_SESSION['message']['type']= "danger";
    }
 }else{
    $_SESSION['message']['text']="Une information obligatoire non insérée!";
    $_SESSION['message']['type']= "danger";
    }
    enregistrerTransaction($connexion,"Ajout d'un client");
    header('Location:../Vue/client.php');
 