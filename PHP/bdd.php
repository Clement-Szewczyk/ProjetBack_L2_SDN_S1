<?php

    //connection BDD
    try{
        $bdd = new PDO('mysql:host=localhost;dbname=doulieu_har;charset=utf8', 'root', '', [PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION]);
    }
    catch(Exception $e){
        die('Erreur : '.$e->getMessage());
    }
?>