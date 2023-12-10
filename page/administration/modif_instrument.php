<?php
    require_once("../../php/bdd.php");
    require_once("../../PHP/header.php");
    head("Modifier Instrument", "modif_user");
    $erreur = NULL;
    if(!isset($_SESSION['role'])){
        header('Location: /page/connexion.php');
    }else{
        if($_SESSION['role'] != 2){
            header('Location: /');
        }
    }
    if(isset($_GET['id'])){
        $id = $_GET['id'];
        $req = $bdd->prepare('SELECT * FROM instrument WHERE id_instrument = :id');
        $req->execute(['id' => $id]);
        $donnees = $req->fetch();
        if($donnees == false){
            header('Location: ./instrument.php');
        }
    }
    else{
        header('Location: ./instrument.php');
    }


    if(isset($_POST['modifier'])){
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
            }else{

                $maj = $bdd->prepare('UPDATE instrument SET numero_serie = :serie, marque = :marque, pupitre = (SELECT pupitre_id FROM pupitre WHERE nom_pupitre = :pupitre), locataire_eleves = :locataire_eleves, locataire_musicien = :locataire_musicien WHERE id_instrument = :id');
                $maj->execute([
                    'serie' => $serie,
                    'marque' => $marque,
                    'pupitre' => $pupitre,
                    'locataire_eleves' => $locataire_eleves,
                    'locataire_musicien' => $locataire_musicien,
                    'id' => $id
                ]);
                header('Location: ./instrument.php');
            }
        }else{
            $erreur = "Veuillez remplir tous les champs";
        }
    }

    if(isset($_POST['supprimer'])){
        $supprimer = $bdd->prepare('DELETE FROM instrument WHERE id_instrument = :id');
        $supprimer->execute(['id' => $id]);
        header('Location: ./instrument.php');
    }

?>

    <h1>Modification de l'instrument <?= $donnees["numero_serie"]?></h1>

    <form action="" method="POST">
        <div class="info">
            <label for="serie">Serie</label>
            <input type="text" name="serie" placeholder="Numéro de série" value="<?= $donnees["numero_serie"] ?>">
            <label for="marque">Marque</label>
            <input type="text" name="marque" placeholder="Marque" value="<?= $donnees["marque"]?>">
        </div>
        <div class="info">
            <label for="pupitre">Pupitre :</label>
            <!-- On réalise un select pour sélectionner le pupitre en fonction de ce qui est créer -->
            <Select name="pupitre" >
                <?php
                    $pupitres  =$bdd->query('SELECT * FROM pupitre');
                    if($donnees["pupitre"] == NULL){
                        echo('<option  selected>Choisir un Pupitre</option>');
                        while($pupitre = $pupitres->fetch()){
                            echo("<option>".$pupitre['nom_pupitre']."</option>");  
                            
                        }
                    }
                    else{
                        
                        echo('<option  selected>'.$bdd->query('SELECT nom_pupitre FROM pupitre WHERE pupitre_id = '.$donnees["pupitre"].'')->fetchColumn().'</option>');
                        // On affiche la réponse par défaut 
                        echo('<option  >Choisir un Pupitre</option>');
                        
                        while($pupitre = $pupitres->fetch()){
                            // On affiche les autres villes en évitant de répéter la ville de l'héro (déjà affiché au dessus)
                            if($pupitre['pupitre_id'] != $donnees["pupitre"]){
                                echo("<option>".$pupitre['nom_pupitre']."</option>");
                            }   
                            
                        }
                    }
                    
                ?>
            </Select>
            <label for="locataire_eleves">Locataire eleves :</label>
            <!-- On réalise un select pour sélectionner le locataire en fonction de ce qui est créer dans la table éleves -->
            <Select name="locataire_eleves" >
                <?php 
                    if($donnees['locataire_eleves'] != NULL){
                        $eleve = $bdd->prepare('SELECT * FROM eleves WHERE eleves_id = :id');
                        $eleve->execute(['id' => $donnees['locataire_eleves']]);
                        $eleves = $eleve->fetch();
                        
                        echo('<option  selected value="'.$eleves['eleves_id'].'">'.$eleves['nom'].' '.$eleves['prenom'].'</option>');
                        
                        $autres_eleves  =$bdd->query('SELECT * FROM eleves');
                        while($autre_eleve = $autres_eleves->fetch()){
                            if($autre_eleve['eleves_id'] != $donnees['locataire_eleves']){
                                echo('<option value="'.$autre_eleve['eleves_id'].'">'.$autre_eleve['nom'].' '.$autre_eleve['prenom'].'</option>');
                            }   
                        }
                        
                        // On affiche la réponse par défaut 
                        echo('<option  >Choisir un locataire</option>');
                    }
                    else{
                        echo('<option  selected>Choisir un locataire</option>');
                        $autres_eleves  =$bdd->query('SELECT * FROM eleves');
                        while($autre_eleve = $autres_eleves->fetch()){
                            echo('<option value="'.$autre_eleve['eleves_id'].'">'.$autre_eleve['nom'].' '.$autre_eleve['prenom'].'</option>');  
                        }
                    }
                ?>
            </Select>
            <label for="locataire_musicien">locataire musicien</label>
            <!-- On réalise un select pour sélectionner le locataire en fonction de ce qui est créer dans la table membre -->
            <Select name="locataire_musicien" >
                
                <?php
                    if($donnees['locataire_musicien'] != NULL){
                        $musicien = $bdd->prepare('SELECT * FROM membre WHERE id = :id');
                        $musicien->execute(['id' => $donnees['locataire_musicien']]);
                        $musiciens = $musicien->fetch();
                        
                        echo('<option  selected value="'.$musiciens['id'].'">'.$musiciens['nom'].' '.$musiciens['prenom'].'</option>');
                        
                        $autres_musiciens  =$bdd->query('SELECT * FROM membre');
                        while($autre_musicien = $autres_musiciens->fetch()){
                            if($autre_musicien['id'] != $donnees['locataire_musicien']){
                                echo('<option value="'.$autre_musicien['id'].'">'.$autre_musicien['nom'].' '.$autre_musicien['prenom'].'</option>');
                            }   
                        }
                        
                        // On affiche la réponse par défaut 
                        echo('<option  >Choisir un locataire</option>');
                    }
                    else{
                        echo('<option  selected>Choisir un locataire</option>');
                        $autres_musiciens  =$bdd->query('SELECT * FROM membre');
                        while($autre_musicien = $autres_musiciens->fetch()){
                            echo('<option value="'.$autre_musicien['id'].'">'.$autre_musicien['nom'].' '.$autre_musicien['prenom'].'</option>');  
                        }
                    }
                    
                ?>
            </Select>
            
        </div>
        
        <div class="button">
            <input type="submit" name="modifier" value="Modifier">
            <input type="submit" name="supprimer" value="Supprimer">
        </div>
        
        <div class="erreur">
            <?php
                if($erreur != NULL){
                    echo $erreur;
                }
            ?>
        </div>
        
    </form>
<?php

    require_once("../../PHP/footer.php");

?>