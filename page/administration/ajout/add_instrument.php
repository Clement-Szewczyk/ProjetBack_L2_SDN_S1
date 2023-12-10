<?php
    require_once('../../../PHP/header.php');
    head("Ajout Instrument", "add_instrument");
    require_once('../../../PHP/bdd.php');
    // On vérifie que l'utilisateur est bien connecté et qu'il est bien un administrateur
    if($_SESSION['role'] != 2){
        header('Location: /');
    }
    // Si l'utilisateur veut ajouter un instrument
    if(isset($_POST['instrument'])){
        if(!empty($_POST['serie']) && !empty($_POST['marque']) && !empty($_POST['pupitre'])){
            $serie = $_POST['serie'];
            $marque = $_POST['marque'];
            $pupitre = $_POST['pupitre'];
            $locataire_eleves = $_POST['locataire_eleves'];
            $locataire_musicien = $_POST['locataire_musicien'];
            if($pupitre == "Choisir un Pupitre"){
                $pupitre = NULL;
            }
            if($locataire_eleves == "Choisir un locataire"){
                $locataire_eleves = NULL;
            }
            if($locataire_musicien == "Choisir un locataire"){
                $locataire_musicien = NULL;
            } 
            
            if($locataire_eleves != NULL && $locataire_musicien != NULL){
                $erreur = "Un instrument ne peut pas être loué par un élève et un musicien en même temps";
            }
            else{
                $req = $bdd->prepare('INSERT INTO instrument(numero_serie, marque, pupitre, locataire_eleves, locataire_musicien) VALUES(:serie, :marque, (SELECT pupitre_id FROM pupitre WHERE nom_pupitre = :pupitre), :eleves, :musicien)');
                $req->execute([
                    'serie' => $serie,
                    'marque' => $marque,
                    'pupitre' => $pupitre,
                    'eleves' => $locataire_eleves,
                    'musicien' => $locataire_musicien
                ]); 
                header('Location: ../instrument.php');
            }
        }
    }

?>

    <div class="add_instrument">
        <h1>Ajout d'un Instrument</h1>
        <form action="" method="POST">
            <div class="info">
                <label for="serie">Serie</label>
                <input type="text" name="serie" placeholder="Numéro de série">
                <label for="marque">Marque</label>
                <input type="text" name="marque" placeholder="Marque">
                <label for="pupitre">Pupitre</label>
                <select name="pupitre" id="">
                    <option value="Choisir un Pupitre">Choisir un Pupitre</option>
                    <?php
                        $req = $bdd->prepare('SELECT * FROM pupitre');
                        $req->execute();
                        while($donnees = $req->fetch()){
                            echo '<option value="'.$donnees['nom_pupitre'].'">'.$donnees['nom_pupitre'].'</option>';
                        }
                    ?>
                </select>
            </div>    
            <div class="info">
                <label for="locataire_eleves">Locataire élèves</label>
                <select name="locataire_eleves" id="">
                    <option value="Choisir un locataire">Choisir un locataire</option>
                    <?php
                        $autres_eleves  =$bdd->query('SELECT * FROM eleves');
                        while($autre_eleve = $autres_eleves->fetch()){
                            echo('<option value="'.$autre_eleve['eleves_id'].'">'.$autre_eleve['nom'].' '.$autre_eleve['prenom'].'</option>');  
                        }
                    ?>
                </select>

                <label for="locataire_musicien">Locataire musicien</label>
                <select name="locataire_musicien" id="">
                    <option value="Choisir un locataire">Choisir un locataire</option>
                    <?php
                        $autres_musiciens  =$bdd->query('SELECT * FROM membre');
                        while($autre_musicien = $autres_musiciens->fetch()){
                            echo('<option value="'.$autre_musicien['id'].'">'.$autre_musicien['nom'].' '.$autre_musicien['prenom'].'</option>');  
                        }
                    ?>
                </select>
            </div>
            
            <input type="submit" name="instrument">    

        </form>
    </div>

    <div class="erreur">
        <?php
            if(isset($erreur)){
                echo $erreur;
            }
        ?>
    </div>
<?php
    require_once('../../../PHP/footer.php');
?>