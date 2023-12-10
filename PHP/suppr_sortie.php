<?php
    session_start();
    require_once('./bdd.php');
    if($_SESSION['role'] != 2){
        header('Location: /');
    }
    echo "test1";

    if(isset($_GET["id"])){
        // On regarde si l'ID existe
        $req = $bdd->prepare("SELECT * FROM sortie WHERE id_sortie = :id");
        $req->execute([
            'id' => $_GET["id"]
        ]);
        $data = $req->fetchALL();
        if($data == null){
            header('Location: /page/administration/sortie.php');
        }
        
        // On supprime la sortie
        $req = $bdd->prepare("DELETE FROM sortie WHERE id_sortie = :id");
        $req->execute([
            'id' => $_GET["id"]
        ]);
        header('Location: /page/administration/sortie.php');

    }
    else{
        header('Location: /page/administration/sortie.php');

    }

?>