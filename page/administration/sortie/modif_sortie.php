<?php
    require_once('../../../PHP/header.php');
    head("Modification d'une sortie", "sortie");
    require_once('../../../PHP/bdd.php');
    if($_SESSION['role'] != 2){
        header('Location: /');
    }

    $id = $_GET['id'];
    $req = $bdd->prepare("SELECT * FROM sortie WHERE id_sortie = :id");
    $req->execute([
        'id' => $id
    ]);
    $data = $req->fetchALL();

    if(isset($_POST["sortie"])){
        if(!empty($_POST["intitule"]) && !empty($_POST["date"]) && !empty(["lieu"])){
            $intitule = $_POST["intitule"];
            $date = $_POST["date"];
            $lieu = $_POST["lieu"];
            
            $req = $bdd->prepare("UPDATE sortie SET intitule = :intitule, date = :date, lieu = :lieu WHERE id_sortie = :id");
            $req->execute([
                'intitule' => $intitule,
                'date' => $date,
                'lieu' => $lieu,
                'id' => $id
            ]);
            header('Location: ../sortie.php');
        }
    }
?>
    
<div class="add">
        <h2>Modification d'une sortie :</h2>

        <div class="form">
            <form action="" method="POST">
                
                <div class="contenu">
                    <input type="text" placeholder="Intitule" name="intitule" value="<?= $data[0]["intitule"]?> " required>
                    <input type="date" name="date" value="<?= $data[0]["date"]?>" required>
                    <input type="text" placeholder="Lieu" name="lieu" value="<?= $data[0]["lieu"] ?>" required>
                </div>
                <div class="contenu">
                <input type="submit" name="sortie">
                </div>
                
            </form>
        </div>
    </div>
    
<?php
    require_once("../../../PHP/footer.php");
?>