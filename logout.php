<?php
    
    include 'connexion.php';
    
    function logout(){
        unset($_SESSION['user_id']);
        unset($_SESSION['nom_complet']);
        unset($_SESSION['email']);
        unset($_SESSION['password']);
    
        session_destroy();
    
        header('Location: ../Vue/index.php');
    }
    
    logout();
    ?>
    