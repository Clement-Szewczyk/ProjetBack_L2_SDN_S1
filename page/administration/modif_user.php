<?php
    require_once('../../PHP/bdd.php');
    require_once("../../PHP/header.php");
    head("Modifier User", "modid_user");
    if(!isset($_SESSION['role'])){
        header('Location: /page/connexion.php');
    }else{
        if($_SESSION['role'] != 2){
            header('Location: /');
        }
    }
    // On vérifie que l'id est bien présent
    if(!isset($_GET['id'])){
        header('Location: ./musicien.php');
    }

    $id = $_GET['id'];
    // On récupère les données de la base de données
    $req = $bdd->prepare('SELECT * FROM membre   WHERE id = :id');
    $req->execute(['id' =>$id]);
    $donnees = $req->fetch();
    // On vérifie que l'id existe bien
    if($donnees == false){
        header('Location: ./musicien.php');
    }
    
    $error_msg = "";
    // Code permettant de traiter la requête Post
    if(isset($_POST['modif'])){
        if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['port']) && !empty($_POST['naissance']) && !empty($_POST['doulieu']) && !empty($_POST['fede']) && !empty($_POST['pupitre']) &&!empty($_POST['role'])){

            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $email = $_POST['email'];

            //vérifie si c'est bien un email
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $error_msg = "Veuillez entrer un email valide";
            }
            
            $fixe = $_POST['fixe'];
            $port = $_POST['port'];
            $adresse = $_POST['adresse'];
            $CP = $_POST['CP'];
            $ville = $_POST['ville'];
            $naissance = $_POST['naissance'];
            $doulieu = $_POST['doulieu'];
            $fede = $_POST['fede'];
            $pupitre = $_POST['pupitre'];
            $role = $_POST['role'];
            $pseudo = $_POST['pseudo'];
            
            // Si c'est la valeur par défaut on met à NULL
            if($role == "Choisir un rôle"){
                $role = NULL;
            }
            if($pupitre == "Choisir un Pupitre"){
                $pupitre = NULL;
            }
            
            // On prépare la requête
            $req = $bdd->prepare('UPDATE membre SET nom = :nom, prenom = :prenom, pseudo = :pseudo, email = :email, tel_fixe = :fixe, tel_port = :port, adresse = :adresse, CP = :CP, ville = :ville, date_naissance = :naissance, date_doulieu = :doulieu, date_fede = :fede, pupitre = (SELECT pupitre_id FROM pupitre WHERE nom_pupitre = :pupitre), role = (SELECT id_role FROM role WHERE nom_role = :role) WHERE id = :id');
            // On execute la requête
            $req->execute([
                'nom' => $nom,
                'prenom' => $prenom,
                'pseudo' => $pseudo,
                'email' => $email,
                'fixe' => $fixe,
                'port' => $port,
                'adresse' => $adresse,
                'CP' => $CP,
                'ville' => $ville,
                'naissance' => $naissance,
                'doulieu' => $doulieu,
                'fede' => $fede,
                'pupitre' => $pupitre,
                'role' => $role,
                'id' => $id
            ]);
            // On redirige vers la page membre.php
            header('Location: ./musicien.php');
        }
        else{
            error_msg("Veuillez remplir tous les champs");
        }
    }
    // Code permettant de traiter la requête Post de la suppression
    if(isset($_POST["suppr"])){

        // On regarde s'il est présent dans la table instruments
        $req = $bdd->prepare('SELECT * FROM instrument WHERE locataire_musicien = :id');
        $req->execute(['id' => $id]);
        $donnees = $req->fetch();

        // Si il est présent on le supprime
        if($donnees != false){
            $req = $bdd->prepare('UPDATE instrument SET locataire_musicien = NULL WHERE locataire_musicien = :id');
            $req->execute(['id' => $id]);
        }

        // On supprime l'élève
        $req = $bdd->prepare('DELETE FROM membre WHERE id = :id');
        $req->execute(['id' => $id]);
        // On redirige vers la page membre.php
        header('Location: ./musicien.php');
    }
?>


    <h1>Modifier le Membre</h1>
    <h2><?= $donnees["nom"]?> <?= $donnees["prenom"]?></h2>
    <form action="" method="POST">
        <div class="info">
            <label for="nom">Nom :</label>
            <input type="text" placeholder="Nom" name="nom" value="<?= $donnees["nom"]?>">
            <label for="prenom">Prénom :</label>
            <input type="text" placeholder="Prénom" name="prenom" value="<?= $donnees["prenom"]?>">
            <label for="pseudo">Pseudo</label>
            <input type="text" placeholder="Pseudo" name="pseudo" value="<?= $donnees["pseudo"]?>">
        </div>
        <div class="info">
            <label for="email">Email :</label>
            <input type="text" placeholder="Email" name="email" value="<?= $donnees["email"]?>">
            <label for="Tel_Fixe">Téléphone fixe :</label>
            <input type="text" placeholder="Tel_Fixe" name="fixe" value="<?= $donnees["tel_fixe"]?>">
            <label for="Tel_Port">Téléphone portable :</label>
            <input type="text" placeholder="Tel_Port" name="port" value="<?= $donnees["tel_port"]?>">
        </div>
        <div class="info">
            <label for="adresse">Adresse :</label>
            <input type="text" placeholder="Adresse" name="adresse" value="<?= $donnees["adresse"]?>">
            <label for="CP">Code Postale :</label>
            <input type="text" placeholder="Code_Postal" name="CP" value="<?= $donnees["CP"]?>">
            <label for="ville">Ville :</label>
            <input type="text" placeholder="Ville" name="ville" value="<?= $donnees["ville"]?>">
        </div>
        <div class="info">
            <label for="naissanec">Date de naissance :</label>
            <input type="date" placeholder="Date de naissance" name="naissance" value="<?= $donnees["date_naissance"]?>">
            <label for="doulieu">Date d'entrée à Le Doulieu :</label>
            <input type="date" placeholder="Date Entrée Doulieu" name="doulieu" value="<?= $donnees["date_doulieu"]?>">
            <label for="fede">Date entrée Fédération :</label>
            <input type="date" placeholder="Date entrée Fédé" name="fede" value="<?= $donnees["date_fede"]?>">
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
            <label for="role">Rôle :</label>
            <!-- Pareil que le pupitre mais pour les rôles -->
            <Select name="role" >
                <?php
                    $roles  =$bdd->query('SELECT * FROM role');
                    if($donnees["role"] == NULL){
                        echo('<option  selected>Choisir un rôle</option>');
                        while($role = $roles->fetch()){
                            echo("<option>".$role['nom_role']."</option>");  
                            
                        }
                    }
                    else{
                        
                        echo('<option  selected>'.$bdd->query('SELECT nom_role FROM role WHERE id_role = '.$donnees["role"].'')->fetchColumn().'</option>');
                        // On affiche la réponse par défaut 
                        echo('<option  >Choisir un rôle</option>');
                        
                        while($role = $roles->fetch()){
                            // On affiche les autres villes en évitant de répéter la ville de l'héro (déjà affiché au dessus)
                            if($role['id_role'] != $donnees["role"]){
                                echo("<option>".$role['nom_role']."</option>");
                            }   
                            
                        }
                    }
                    
                ?>
            </Select>
        </div>
        

        <input type="submit" value="Modifier" name="modif">
    </form>
    
    <form action="" method="Post">
        <input type="submit" value="Supprimer" name="suppr">
    </form>
    
    <div class="erreur">
        <?= $error_msg ?>
    </div>
    
    
</body>
</html>
