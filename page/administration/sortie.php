<?php
    require_once("../../PHP/header.php");
    head("Sortie", "sortie");
    require_once('../../PHP/bdd.php');
    if(!isset($_SESSION['role'])){
        header('Location: /page/connexion.php');
    }else{
        if($_SESSION['role'] != 2){
            header('Location: /');
        }
    }

    if(isset($_POST["sortie"])){
        if(!empty($_POST["intitule"]) && !empty($_POST["date"]) && !empty(["lieu"])){
            $intitule = $_POST["intitule"];
            $date = $_POST["date"];
            $lieu = $_POST["lieu"];
            $req = $bdd->prepare("INSERT INTO sortie(intitule, date, lieu) VALUES(:intitule, :date, :lieu)");
            $req->execute([
                'intitule' => $intitule,
                'date' => $date,
                'lieu' => $lieu
            ]);
            echo "Sortie ajoutée";
            //vider le $_POST
            $_POST = array();
            //rafraichir la page
            header('Location: ./sortie.php');

        }else{
            echo "Veuillez remplir tous les champs";
        }
    }

    $data = null;
   
?>
    <h1>Gestion des sorties</h1>

    <div class="add">
        <h2>Ajout d'une sortie :</h2>

        <div class="form">
            <form action="" method="POST">
                
                <div class="contenu">
                    <input type="text" placeholder="Intitule" name="intitule" required>
                    <input type="date" name="date" required>
                    <input type="text" placeholder="Lieu" name="lieu" required>
                </div>
                <div class="contenu">
                <input type="submit" name="sortie">
                </div>
                
            </form>
        </div>
    </div>

    <div class="sortie">
        <h2>Les sorties :</h2>
        <table>
            <tr>
                <th>Sortie</th>
                <th>Date</th>
                <th>Lieu</th>
            </tr>
            
            <?php
                $req2 = $bdd->query("SELECT * FROM sortie");
                $datas=$req2->fetchAll();
                foreach($datas as $data){
                    //Affiche que les sorties qui ne sont pas passées
                    if($data['date'] > date("Y-m-d")){
                        echo "<tr>";
                        echo "<td>".$data['intitule']."</td>";
                        echo "<td>".$data['date']."</td>";
                        echo "<td>".$data['lieu']."</td>";
                        echo"<td><a href='/page/administration/sortie/visu.php?id=".$data['id_sortie']."'>Présence</a></td>";
                        echo "<td><a href='./sortie/modif_sortie.php?id=".$data['id_sortie']."'>Modifier</a></td>";
                        echo "<td><a href='../../PHP/suppr_sortie.php?id=".$data['id_sortie']."'>Supprimer</a></td>";
                        echo "</tr>";
                    }
                }
            ?>

            
        </table>
    </div>
<?php
    require_once("../../PHP/footer.php");
?>