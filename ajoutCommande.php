<?php
include 'connexion.php';
include_once 'function.php';


if(!empty($_POST['id_article']) 
    && !empty($_POST['id_fournisseur']) 
    && !empty($_POST['quantite']) 
    && !empty($_POST['prixUnitaire']) 
    && !empty($_POST['prix']) 
){
  
        $sql= "INSERT INTO details_cmd(id_article, id_fournisseur, quantite, prixUnitaire, prix)
        VALUES(?, ?, ?, ?, ?)";
    
    //preparer la requete
        $req= $connexion->prepare($sql);
    
        $req->execute(array(
            $_POST['id_article'],
            $_POST['id_fournisseur'],
            $_POST['quantite'],
            $_POST['prixUnitaire'],
            $_POST['prix']  
        ));
    
        //verifier les nb de ligne modifiee
        if($req->rowCount()!=0){

            //requette de distraire la quantite vendue du stock
            $sql="UPDATE article SET quantite=quantite+? WHERE id=?";
            
             //preparer la requete
            $req= $connexion->prepare($sql);
    
             $req->execute(array(
                $_POST['quantite'], 
                $_POST['id_article'],
            ));


            //tester si au moins une seul ligne a ete modifie
            if ($req->rowCount()!=0) {
                $_SESSION['message']['text']="commande effectué avec succès!";
                $_SESSION['message']['type']= "success";    
            } else {
                $_SESSION['message']['text']="Impossible d'effectuer cette commande!";
                $_SESSION['message']['type']= "danger";
            }
        
        }else{
        $_SESSION['message']['text']="une erreur s'est produite lors de la commande!";
        $_SESSION['message']['type']= "danger";
        }
    
   
 
}else{
    $_SESSION['message']['text']="Une information obligatoire non insérée!";
    $_SESSION['message']['type']= "danger";
    }
    enregistrerTransaction($connexion,"effectuation d'une commande");
    header('Location:../Vue/commande.php');