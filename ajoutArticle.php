<?php
include 'connexion.php';
include_once 'function.php';


if(!empty($_POST['nom_article']) 
    && !empty($_POST['id_categorie']) 
    && !empty($_POST['quantite']) 
    && !empty($_POST['prix_unitaire']) 
    && !empty($_POST['date_fabrication']) 
    && !empty($_POST['date_expiration'])
    && !empty($_FILES['images']) 
 ){
    if ($quantite <= 0) {
        echo '<div class="alert error">La quantité ne peut pas être négative!</div>';
        }else{
    $sql= "INSERT INTO $nom_base_de_donne.article(nom_article, id_categorie, quantite, prix_unitaire, date_fabrication, date_expiration, images)
    VALUES(?, ?, ?, ?, ?, ?, ?)";

    //preparer la requete
    $req= $connexion->prepare($sql);

    $name=$_FILES['images']['name'];
    $tmp_name=$_FILES['images']['tmp_name'];

    //variablecontient le dossier ou se trouve l'image
    $folder="../public/images/";
    $destination="../public/images/$name";//c'est ou l'image est deplace

    if (!is_dir($folder)) { //si le dossier n'existe pas il faut la cree
        mkdir($folder, 0777, true);
    }

    if (move_uploaded_file($tmp_name, $destination)) {//permet de deplacer une image du 1er rep vers le 2eme
        $req->execute(array(
            $_POST['nom_article'],
            $_POST['id_categorie'],
            $_POST['quantite'],
            $_POST['prix_unitaire'],
            $_POST['date_fabrication'],
            $_POST['date_expiration'],
            $destination  
        ));
    
        //verifier les nb de ligne modifiee
        if($req->rowCount()!=0){
            $_SESSION['message']['text']="article ajouté avec succès!";
            $_SESSION['message']['type']= "success";
    
        }else{
        $_SESSION['message']['text']="une erreur s'est produite lors de l'ajout de l'article!";
        $_SESSION['message']['type']= "danger";
        }
    }else {
        $_SESSION['message']['text']="une erreur s'est produite lors de l'importation de l'image de l'article!";
        $_SESSION['message']['type']= "danger";
    }
} 
 }else{
    $_SESSION['message']['text']="Une informtion obligatoire non insérée!";
    $_SESSION['message']['type']= "danger";
    }
    //enregistrerTransaction($connexion,"Ajout d'un article");
    header('Location:../Vue/article.php');
 