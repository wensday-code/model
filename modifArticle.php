<?php
include 'connexion.php';
include 'function.php';

if(!empty($_POST['nom_article']) 
    && !empty($_POST['id_categorie']) 
    && !empty($_POST['quantite']) 
    && !empty($_POST['prix_unitaire']) 
    && !empty($_POST['date_fabrication']) 
    && !empty($_POST['date_expiration'])
    && !empty($_FILES['images']) 
    && !empty($_POST['id']) 
 ){
    if (!empty($_FILES['images']['name'])) { // si une nouvelle image a été téléchargée
        $name=$_FILES['images']['name'];
        $tmp_name=$_FILES['images']['tmp_name'];
    
        // variable contenant le dossier où se trouve l'image
        $folder="../public/images/";
        $destination="../public/images/$name";// c'est où l'image est déplacée
    
        if (!is_dir($folder)) { // si le dossier n'existe pas il faut le créer
            mkdir($folder, 0777, true);
        }
        
    
        if (move_uploaded_file($tmp_name, $destination)) {// permet de déplacer une image du 1er rep vers le 2eme
            $image_path = $destination;
        }
    } else { // si aucune nouvelle image n'a été téléchargée
        $image_path = $_POST['old_image_path']; // utiliser le chemin d'accès à l'image existante
    }
    
    // Exécuter la requête avec le chemin d'accès à l'image mis à jour
    $sql= "UPDATE article SET nom_article=?, id_categorie=?, quantite=?, prix_unitaire=?, date_fabrication=?, date_expiration=?, images=? WHERE id=?";
    $req= $connexion->prepare($sql);
    $req->execute(array(
        $_POST['nom_article'],
        $_POST['id_categorie'],
        $_POST['quantite'],
        $_POST['prix_unitaire'],
        $_POST['date_fabrication'],
        $_POST['date_expiration'], 
        $image_path,  
        $_POST['id']
    ));

    //verifier les nb de ligne modifiee
    if($req->rowCount()!=0){
        $_SESSION['message']['text']="article modifié avec succès!";
        $_SESSION['message']['type']= "success";

    }else{
    $_SESSION['message']['text']="Rien n'a été modifié!";
    $_SESSION['message']['type']= "warning";
    }
}else{
    $_SESSION['message']['text']="Une information obligatoire non insérée!";
    $_SESSION['message']['type']= "danger";
    }
    //enregistrerTransaction($connexion,"Modification d'un article");
    header('Location:../Vue/article.php');
 