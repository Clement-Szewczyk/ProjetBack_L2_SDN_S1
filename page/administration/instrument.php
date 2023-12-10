<?php
    require_once('../../PHP/bdd.php');
    echo '<link rel="stylesheet" href="/CSS/membre.css">';
    require_once("../../PHP/header.php");
    head("Instrument", "instrument");
    //Ajouter un fichier css

    // On vérifie que l'utilisateur est bien un administrateur 
    if(!isset($_SESSION['role'])){
        header('Location: /page/connexion.php');
    }else{
        if($_SESSION['role'] != 2){
            header('Location: /');
        }
    }
    
    // Ajout d'un instrument -->
        if(isset($_POST['ajout'])){ 
            header('Location: ./ajout/add_instrument.php');
        }
?>

    <!-- Navbar -->
    
    <div class="visu" id="visu">
    <h1>Les Instruments en location</h1>

    <!-- Affichage des instruments -->
    
    <table>
        <tr>
            <th>Numéro de Série</th>
            <th>Marque</th>
            <th>Pupitre</th>
            <th>Locataire</th>
            <th>Modifier</th>
        </tr>
        <?php
            $req = $bdd->prepare('SELECT * FROM instrument');
            $req->execute();
            while($donnees = $req->fetch()){
                if($donnees['pupitre'] == NULL){
                    $pupitres = NULL;
                }else{
                    $pupitre = $bdd->prepare('SELECT * FROM pupitre WHERE pupitre_id = :id');
                    $pupitre->execute(['id' => $donnees['pupitre']]);
                    $pupitre = $pupitre->fetch(); 
                    $pupitres = $pupitre['nom_pupitre'];
                }
                

                if($donnees['locataire_musicien'] == NULL && $donnees['locataire_eleves'] != NULL){
                    $locataire = $bdd->prepare('SELECT * FROM eleves WHERE eleves_id = :id');
                    $locataire->execute(['id' => $donnees['locataire_eleves']]);
                    $locataire = $locataire->fetch();
                    $locataires = $locataire['nom'].' '.$locataire['prenom'];
                }
                else if($donnees['locataire_eleves'] == NULL && $donnees['locataire_musicien'] != NULL){
                    $locataire = $bdd->prepare('SELECT * FROM membre WHERE id = :id');
                    $locataire->execute(['id' => $donnees['locataire_musicien']]);
                    $locataire = $locataire->fetch();
                    $locataires = $locataire['nom'].' '.$locataire['prenom'];
                }
                else{
                    $locataires = NULL;
                }

                echo '<tr>';
                echo '<td>'.$donnees['numero_serie'].'</td>';
                echo '<td>'.$donnees['marque'].'</td>';
                echo '<td>'.$pupitres.'</td>';
                echo '<td>'.$locataires.'</td>';
                echo '<td><a href="modif_instrument.php?id='.$donnees['id_instrument'].'">Modifier</a></td>';
                echo '</tr>';
                
            }
           
            
        ?>
    </table>
    
    <div class="button">
        <form action="" method="POST">
            <input type="submit" name="ajout" value="ajout">
        </form>
    </div>
    

    </div>
    
    
    
<?php
    require_once("../../PHP/footer.php");
?>
