<?php
include 'connexion.php';
include 'function.php';

if(!empty($_POST['nom']) 
    && !empty($_POST['prenom']) 
    && !empty($_POST['telephone']) 
    && !empty($_POST['adresse']) 
    && !empty($_POST['email']) 
    && !empty($_POST['id']) 
 ){
    $sql= "UPDATE client SET nom=?, prenom=?, telephone=?, adresse=?, email=? WHERE id=?";

    //preparer la requete
    $req= $connexion->prepare($sql);

    $req->execute(array(
        $_POST['nom'],
        $_POST['prenom'],
        $_POST['telephone'],
        $_POST['adresse'],
        $_POST['email'],
        $_POST['id']   
    ));

    //verifier les nb de ligne modifiee
    if($req->rowCount()!=0){
        $_SESSION['message']['text']="client modifié avec succès!";
        $_SESSION['message']['type']= "success";

    }else{
    $_SESSION['message']['text']="Rien n'a été modifié1";
    $_SESSION['message']['type']= "warning";
    }
 }else{
    $_SESSION['message']['text']="Une information obligatoire non insérée!";
    $_SESSION['message']['type']= "danger";
    }
    enregistrerTransaction($connexion,"Modification d'un client");
    header('Location:../Vue/client.php');
 