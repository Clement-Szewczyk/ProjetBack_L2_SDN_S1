<?php
    function Instrument($id){
        try{
            $bdd = new PDO('mysql:host=localhost;dbname=doulieu_har;charset=utf8', 'root', '', [PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION]);
        }
        catch(Exception $e){
            die('Erreur : '.$e->getMessage());
        }
        $instrument = $bdd->query('SELECT * FROM pupitre WHERE pupitre_id = '.$id);
        $instruments = $instrument->fetch();
        return $instruments['nom_pupitre'];
    }

    function present($info){
        if($info == 1){
            return 'Présent';
        }
        else if($info == 2){
            return 'Incertain';
        }
        else{
            return 'Absent';
        }
    }



    require_once '../../../PHP/bdd.php';
    require_once '../../../PHP/header.php';
    head("sortie", "ajout");
   
    if(isset($_GET['id'])){
        $id = $_GET['id'];
    }
    else{
        header('Location: ../sortie.php');
    }

    $sortie = $bdd->query('SELECT * FROM sortie WHERE id_sortie = '.$id.'');
    $sortie = $sortie->fetch();
    // On vérifie que la sortie existe bien
    if(!$sortie){
        header('Location: ../sortie.php');
    }
    // Info de la sortie
    $sortie_nom = $sortie['intitule'];
    $sortie_date = $sortie['date'];
    $sortie_lieu = $sortie['lieu'];

    // On récupère les musiciens les présences
    $presents = $bdd->query('SELECT * FROM present WHERE id_event = '.$id);
    $musiciens = $presents->fetchAll();

    



?>

<h1>Précense de la sortie : <?=$sortie_nom?></h1>

<table>
    <tr>
        <th>Nom</th>
        <th>Prénom</th>
        <th>Instrument</th>
        <th>Sortie</th>
        <th>Présence</th>
    </tr>
    <?php
        $i = 0;
        foreach($musiciens as $musicien){
            $id_musicien = $musiciens[$i]['id_user'];
            $musicien = $bdd->query('SELECT * FROM membre WHERE id = '.$id_musicien);
            $musicien = $musicien->fetch();
            $musicien_nom = $musicien['nom'];
            $musicien_prenom = $musicien['prenom'];
            $musicien_instrument = $musicien['pupitre'];
            $musicien_present = $musiciens[$i]['reponse'];
            echo '
            <tr>
                <td>'.$musicien_nom.'</td>
                <td>'.$musicien_prenom.'</td>
                <td>'.Instrument($musicien_instrument).'</td>
                <td>'.$sortie_nom.'</td>
                <td>'.present($musicien_present).'</td>
            </tr>
            ';
            $i++;
        }
    ?>
    
</table>

<?php
    require_once '../../../PHP/footer.php';
?>