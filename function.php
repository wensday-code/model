<?php
include 'connexion.php';


function getArticle($id=null, $searchDATA=array())
{
    if(!empty($id)){//recuperer un seul
        $sql= "SELECT nom_article, libelle_categorie, quantite, prix_unitaire, date_fabrication, date_expiration, id_categorie, a.id, images 
               FROM article AS a, categorie AS c
               WHERE a.id_categorie=c.id AND a.id=?";
        $req=$GLOBALS['connexion']->prepare($sql);

        $req->execute(array($id));

        return $req->fetch();
    }elseif (!empty($searchDATA)) {
        //mettre les conditions de recherche
        $search="";
        extract($searchDATA);
        if (!empty($nom_article)) $search.= "AND a.nom_article LIKE '%$nom_article%' ";
        if (!empty($id_categorie)) $search.= "AND a.id_categorie =$id_categorie";
        if (!empty($quantite)) $search.= "AND a.quantite =$quantite";
        if (!empty($prix_unitaire)) $search.= "AND a.prix_unitaire =$prix_unitaire";
        if (!empty($date_fabrication)) $search.= "AND DATE(a.date_fabrication) ='$date_fabrication' ";
        if (!empty($date_expiration)) $search.= "AND DATE(a.date_expiration) ='$date_expiration' ";

        $sql= "SELECT nom_article, libelle_categorie, quantite, prix_unitaire, date_fabrication, date_expiration, id_categorie, a.id, images 
        FROM article AS a, categorie AS c
        WHERE a.id_categorie=c.id ";
        
        if(!empty($search)){
            $sql .= $search;
        }

        $req=$GLOBALS['connexion']->prepare($sql);

        $req->execute();

        return $req->fetchAll();
    }else{//recuperer tous les articles
        $sql= "SELECT nom_article, libelle_categorie, quantite, prix_unitaire, date_fabrication, date_expiration, id_categorie, a.id, images 
        FROM article AS a, categorie AS c
        WHERE a.id_categorie=c.id";

        $req=$GLOBALS['connexion']->prepare($sql);

        $req->execute();

        return $req->fetchAll();
    }
}




function getClient($id=null)
{
    if(!empty($id)){//recuperer un seul
        $sql= "SELECT * FROM client WHERE id=?";
        $req=$GLOBALS['connexion']->prepare($sql);

        $req->execute(array($id));

        return $req->fetch();
    }else{//recuperer tous
        $sql= "SELECT * FROM client";

        $req=$GLOBALS['connexion']->prepare($sql);

        $req->execute();

        return $req->fetchAll();
    }
}



function getVente($id=null)
{
    if(!empty($id)){//recuperer un seul
        $sql= "SELECT nom_article, nom, prenom, v.quantite, prix, date_vente, v.id, prix_unitaire, adresse, telephone, etat_livraison, mode_livraison
               FROM client AS c, vente AS v, article AS a WHERE v.id_article=a.id AND v.id_client=c.id AND v.id=? AND etat=? ";
        $req=$GLOBALS['connexion']->prepare($sql);

        $req->execute(array($id,1));

        return $req->fetch();

    }else{//recuperer tous 
        $sql= "SELECT nom_article, nom, prenom, v.quantite, prix, date_vente, v.id, a.id AS idArticle,  etat_livraison, mode_livraison
        FROM client AS c, vente AS v, article AS a WHERE v.id_article=a.id AND v.id_client=c.id AND etat=? "; 

        $req=$GLOBALS['connexion']->prepare($sql);

        $req->execute(array(1));

        return $req->fetchAll();
    }
}


function getFournisseur($id=null)
{
    if(!empty($id)){//recuperer un seul
        $sql= "SELECT * FROM fournisseur WHERE id=?";
        $req=$GLOBALS['connexion']->prepare($sql);

        $req->execute(array($id));

        return $req->fetch();
    }else{//recuperer tous 
        $sql= "SELECT * FROM fournisseur";

        $req=$GLOBALS['connexion']->prepare($sql);

        $req->execute();

        return $req->fetchAll();
    }
}


function getCommande($id=null)
{
    if(!empty($id)){//recuperer un seul
        $sql= "SELECT nom_article, nom_cmd, nom, prenom, co.quantite_total, montant_total, date_cmd, co.id, prix_unitaire, adresse, telephone
               FROM fournisseur AS f, commande AS co, article AS a WHERE co.id_fournisseur=f.id AND co.id=? AND etat=?";
        $req=$GLOBALS['connexion']->prepare($sql);

        $req->execute(array($id,1));

        return $req->fetch();

    }else{//recuperer tous 
        $sql= "SELECT nom_article, nom_cmd, nom, prenom, co.quantite_total , montant_total, date_cmd, co.id, a.id AS idArticle 
        FROM fournisseur AS f, commande AS co, article AS a WHERE co.id_fournisseur=f.id AND etat=?"; 

        $req=$GLOBALS['connexion']->prepare($sql);

        $req->execute(array(1));

        return $req->fetchAll();
    }
}

function getDetailCommande($id=null)
{
    if(!empty($id)){//recuperer un seul
        $sql= "SELECT nom_article, nom, prenom, det_co.quantite, prix, date_detail_cmd, det_co.id, prix_unitaire, adresse, telephone
               FROM fournisseur AS f, details_cmd AS det_co, article AS a WHERE det_co.id_article=a.id AND det_co.id_fournisseur=f.id AND det_co.id=?";
        $req=$GLOBALS['connexion']->prepare($sql);

        $req->execute();

        return $req->fetch();

    }else{//recuperer tous 
        $sql= "SELECT nom_article, nom, prenom, det_co.quantite, prix, date_detail_cmd, det_co.id, a.id AS id_Article 
        FROM fournisseur AS f, details_cmd AS det_co, article AS a WHERE det_co.id_article=a.id AND det_co.id_fournisseur=f.id"; 

        $req=$GLOBALS['connexion']->prepare($sql);

        $req->execute();

        return $req->fetchAll();
    }
}

function getAllCommande(){
    $sql="SELECT COUNT(*) AS nbr FROM commande WHERE etat='1'";

    $req=$GLOBALS['connexion']->prepare($sql);

        $req->execute();

        return $req->fetch();
}

function getAllVente(){
    $sql="SELECT COUNT(*) AS nbr FROM vente WHERE etat='1'";

    $req=$GLOBALS['connexion']->prepare($sql);

        $req->execute();

        return $req->fetch();
}

function getAllArticle(){
    $sql="SELECT COUNT(*) AS nbr FROM article";

    $req=$GLOBALS['connexion']->prepare($sql);

        $req->execute();

        return $req->fetch();
}

function getCA(){
    $sql="SELECT SUM(prix) AS prix FROM vente WHERE etat='1'";

    $req=$GLOBALS['connexion']->prepare($sql);

        $req->execute();

        return $req->fetch();
}


function getLastVente()
{
    //recuperer tous les articles
        $sql= "SELECT nom_article, nom, prenom, v.quantite, prix, date_vente, v.id, a.id AS idArticle 
        FROM client AS c, vente AS v, article AS a WHERE v.id_article=a.id AND v.id_client=c.id AND etat=?
        ORDER BY date_vente DESC LIMIT 10"; 

        $req=$GLOBALS['connexion']->prepare($sql);

        $req->execute(array(1));

        return $req->fetchAll();
    
}


function getPlusVente()
{
    //recuperer tous les articles
        $sql= "SELECT nom_article, SUM(prix) AS prix
        FROM client AS c, vente AS v, article AS a WHERE v.id_article=a.id AND v.id_client=c.id AND etat=?
        GROUP BY a.id
        ORDER BY SUM(prix) DESC LIMIT 10"; 

        $req=$GLOBALS['connexion']->prepare($sql);

        $req->execute(array(1));

        return $req->fetchAll();
    
}

function getCategorie($id=null)
{
    if(!empty($id)){//recuperer un seul
        $sql= "SELECT * FROM categorie WHERE id=?";
        $req=$GLOBALS['connexion']->prepare($sql);

        $req->execute(array($id));

        return $req->fetch();
    }else{//recuperer tous 
        $sql= "SELECT * FROM categorie ";

        $req=$GLOBALS['connexion']->prepare($sql);

        $req->execute();

        return $req->fetchAll();
    }
}


// Fonction d'enregistrement de transaction
/*function enregistrerTransaction($userID, $description) {
    global $connexion; // Rendre la variable $connexion accessible dans la portée de la fonction
    // Récupérer l'ID de l'utilisateur actuel 
    $userID = $_SESSION['user_id'];;

    $sql="INSERT INTO transactions (user_id, transaction_date, description) VALUES (:userID, NOW(), :description)";
    // Insérer une nouvelle ligne dans la table des transactions
    $stmt = $connexion->prepare($sql);
    $stmt->bindParam(':userID', $userID);
    $stmt->bindParam(':description', $description);
    $stmt->execute();
    var_dump($stmt->errorInfo());
}*/


function getTransaction($id=null) {
    if(!empty($id)){//recuperer un seul
        $sql= "SELECT description, transaction_date, u.nom_complet, u.email
               FROM transactions AS t, utilisateurs AS u
               WHERE t.user_id=u.id AND t.id=?";
        $req=$GLOBALS['connexion']->prepare($sql);

        $req->execute(array($id));

        return $req->fetch();
    }else{//recuperer tous 
        $sql= "SELECT description, transaction_date, u.nom_complet, u.email
                FROM transactions AS t, utilisateurs AS u
                WHERE t.user_id=u.id
                ORDER BY t.transaction_date DESC";

        $req=$GLOBALS['connexion']->prepare($sql);

        $req->execute();

        return $req->fetchAll();

    }
}

 function createUserSession($user){
        

   // Stocker l'ID de l'utilisateur dans la session
    $_SESSION['user_id'] = $user['id'];
    $_SESSION['nom_complet'] = $user['nom_complet'];
    $_SESSION['tel'] =$user['tel'];
    $_SESSION['adresse'] = $user['adresse'];
    $_SESSION['email'] =$user['email'];
    $_SESSION['password'] = $user['password'];

     // Redirection vers la page dashboard après une connexion réussie
   header('Location: ../Vue/dashboard.php');
}

 
function getUtilisateurs(){
    $sql= "SELECT nom_complet, email, tel, adresse FROM utilisateurs";
    $req=$GLOBALS['connexion']->prepare($sql);
    $req->execute();
    return $req->fetchAll();
}

function countArticle($searchDATA = array())
{

   if (!empty($searchDATA)) {
        $search = "";
        extract($searchDATA);
        if (!empty($nom_article)) $search .= " AND a.nom_article LIKE '%$nom_article%' ";
        if (!empty($id_categorie)) $search .= " AND a.id_categorie = $id_categorie ";
        if (!empty($quantite)) $search .= " AND a.quantite = $quantite ";
        if (!empty($prix_unitaire)) $search .= " AND a.prix_unitaire = $prix_unitaire ";
        if (!empty($date_fabrication)) $search .= " AND DATE(a.date_fabrication) = '$date_fabrication' ";
        if (!empty($date_expiration)) $search .= " AND DATE(a.date_expiration) = '$date_expiration' ";

        $sql = "SELECT COUNT(*) AS total FROM article AS a, categorie AS c WHERE c.id=a.id_categorie $search";

        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute();

        return $req->fetch();
    } else {
        $sql = "SELECT COUNT(*) AS total 
        FROM article AS a, categorie AS c WHERE c.id=a.id_categorie";
        $req = $GLOBALS['connexion']->prepare($sql);

        $req->execute();
        return $req->fetch();
    }
}