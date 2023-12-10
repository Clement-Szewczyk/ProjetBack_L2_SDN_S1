<?php
    // On inclut la connexion à la base
    require_once("../../PHP/bdd.php");
    // On inclut la navbar 
    require_once("../../PHP/header.php");
    head("Présence", "presence");
    // On vérifie si l'utilisateur à le droit d'être sur cette page
    if(!isset($_SESSION['role'])){
        header('Location: /page/connexion.php');
    }
    $pseudo_session = $_SESSION['pseudo'];
    $role_session = $_SESSION['role'];

    // On vérifie si l'utilisateur à les droits d'être sur cette page
    if($role_session != 2 && $role_session != 1){
        header('Location: /');
    }

    // On récupère les informations des sorties 
    $req = $bdd->prepare("SELECT * FROM sortie");
    $req->execute();
    $sorties = $req->fetchAll();
    
   // On récupère les informations des présences
    if(isset($_GET['Present'])){
        //affiche tout ce qui est dans le tableau $_GET
        var_dump($_GET);
        foreach($_GET as $key=>$present){
            if($key != "Present"){
                $ID_event = explode("_", $key);
                //print_r($present);
                //print_r($ID_event[1]);
                //echo "<br>";

                $suppr = $bdd->prepare("DELETE FROM present WHERE id_event = :id_sortie AND id_user = :id_user");
                $suppr->execute([
                    'id_sortie' => $ID_event[1],
                    'id_user' => $_SESSION['id']
                ]);

                $req = $bdd->prepare("INSERT INTO present(id_user, id_event, reponse) VALUES(:id_user, :id_sortie, :id_presence)");
                $req->execute([
                    'id_user' => $_SESSION['id'],
                    'id_sortie' => $ID_event[1],
                    'id_presence' => $present
                ]);

                header('Location: /page/espace_membre/presence_sortie.php');
            }
        }
    }

    
?>

    <h1>Présences Aux Sorties</h1>

    <div class="tab">
        <form method="GET">
            <table>
                <tr>
                    <!-- Mettre 2 th vide pour laisser un espace entre les 2 th -->
                    <th></th>
                    <th></th>
                    <th class="th"><span>Présent</span></th>
                    <th class="th"><span>Incertain</span></th>
                    <th class="th"><span>absent</span></th>
                </tr>
                <?php
                        foreach($sorties as $sortie){
                            echo "<tr>";
                            echo "<td>".$sortie['date']."</td>";
                            echo "<td>".$sortie['intitule']." (".$sortie['lieu'].")</td>";
                            $pre= $bdd->prepare("SELECT * FROM present WHERE id_event = :id_sortie AND id_user = :id_user");
                            $pre->execute([
                                'id_sortie' => $sortie['id_sortie'],
                                'id_user' => $_SESSION['id']
                            ]);
                            $presence = $pre->fetch();
                            if($presence['reponse'] == 1){
                                echo "<td><input type='radio' name='presence_".$sortie['id_sortie']."' id='present' value='1' checked></td>";
                                echo "<td><input type='radio' name='presence_".$sortie['id_sortie']."' id='incertain' value='2'></td>";
                                echo "<td><input type='radio' name='presence_".$sortie['id_sortie']."' id='absent' value='0'></td>";
                            }elseif($presence['reponse'] == 2){
                                echo "<td><input type='radio' name='presence_".$sortie['id_sortie']."' id='present' value='1'></td>";
                                echo "<td><input type='radio' name='presence_".$sortie['id_sortie']."' id='incertain' value='2' checked></td>";
                                echo "<td><input type='radio' name='presence_".$sortie['id_sortie']."' id='absent' value='0'></td>";
                            }elseif($presence['reponse'] == 0){
                                echo "<td><input type='radio' name='presence_".$sortie['id_sortie']."' id='present' value='1'></td>";
                                echo "<td><input type='radio' name='presence_".$sortie['id_sortie']."' id='incertain' value='2'></td>";
                                echo "<td><input type='radio' name='presence_".$sortie['id_sortie']."' id='absent' value='0' checked></td>";
                            }else{
                            echo "<td><input type='radio' name='presence_".$sortie['id_sortie']."' id='present' value='1'></td>";
                            echo "<td><input type='radio' name='presence_".$sortie['id_sortie']."' id='incertain' value='2'></td>";
                            echo "<td><input type='radio' name='presence_".$sortie['id_sortie']."' id='absent' value='0'></td>";
                            echo "</tr>";
                            }
                        }
                    ?>
                    
            </table>
            <input type="submit" value="Mettre à jour" name="Present">
            
        </form>
    </div>
    
    
<?php
    require_once("../../PHP/footer.php");  
?>