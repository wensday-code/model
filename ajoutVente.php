<?php

include 'connexion.php';
include 'function.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
//var_dump($_POST);
//die();


if(!empty($_POST['id_article']) 
    && !empty($_POST['id_client']) 
    && !empty($_POST['quantite']) 
    && !empty($_POST['prix']) 
    && !empty($_POST['etat_livraison']) 
    && !empty($_POST['mode_livraison'])
 ){
  
    //recuperer l'article en fct de son identifiant
  $article=getArticle($_POST['id_article']); 
   
   //tester si n'est pas vide et la quantite disponible
   if(!empty($article)&& is_array($article)){
    if($_POST['quantite']>$article['quantite']){
        $_SESSION['message']['text']="la quantité à vendre n'est pas disponible";
        $_SESSION['message']['type']= "danger";
    }else{
        $sql= "INSERT INTO vente(id_article, id_client, quantite, prix, etat_livraison, mode_livraison)
        VALUES(?, ?, ?, ?, ?, ?)";
    
    //preparer la requete
        $req= $connexion->prepare($sql);
    
        $req->execute(array(
            $_POST['id_article'],
            $_POST['id_client'],
            $_POST['quantite'],
            $_POST['prix'],
            $_POST['etat_livraison'],
            $_POST['mode_livraison'] 
        ));
    
        //verifier les nb de ligne modifiee
        if($req->rowCount()!=0){

            //requette de distraire la quantite vendue du stock
            $sql="UPDATE article SET quantite=quantite-? WHERE id=?";
            
             //preparer la requete
            $req= $connexion->prepare($sql);
    
             $req->execute(array(
                $_POST['quantite'], 
                $_POST['id_article'],
            ));


            //tester si au moins une seul ligne a ete modifie
            if ($req->rowCount()!=0) {
                $_SESSION['message']['text']="vente effectué avec succès!";
                $_SESSION['message']['type']= "success";  
                enregistrerTransaction($connexion, "Ajout d'une vente");
            } else {
                $_SESSION['message']['text']="Impossible d'effectuer cette vente!";
                $_SESSION['message']['type']= "danger";
            }
        
        }else{
        $_SESSION['message']['text']="une erreur s'est produite lors de la vente!";
        $_SESSION['message']['type']= "danger";
        }
    } 
   }
 }else{
    $_SESSION['message']['text']="Une information obligatoire non insérée!";
    $_SESSION['message']['type']= "danger";
    }
    header('Location:../Vue/vente.php');