<?php
    // On inclut la connexion à la base
    require_once("../../PHP/bdd.php");
    // On inclut la navbar 
    require_once("../../PHP/header.php");
    head("Information User", "maj_user");
    if(!isset($_SESSION['role'])){
        header('Location: /page/connexion.php');
    }else{
        // On récupère l'internaute connecté
        $pseudo_session = $_SESSION['pseudo'];
        $role_session = $_SESSION['role'];

        // On vérifie si l'utilisateur à les droits d'être sur cette page
        if($role_session != 2 && $role_session != 1){
            header('Location: /');
        }
    }
    
    // On initialise les variables pour les retours de messages
    $erreur = "";
    $succes = "";
    // On vérifie si l'utilisateur existe
    if(isset($_SESSION['pseudo'])){
        // On récupère les informations de l'utilisateur
        $req = $bdd->prepare('SELECT * FROM membre WHERE pseudo = :pseudo');
        $req ->execute(["pseudo" => $pseudo_session]);
        $user = $req->fetch();
        

    }else{
        header('Location: /page/connexion.php');
    }

    // On vérifie si l'utilisateur a cliqué sur le bouton de mise à jour
    if(isset($_POST['MAJ'])){
        // On récupère les informations du formulaire
        $adresse= $_POST['adresse'];
        $CP= $_POST['CP'];
        $ville= $_POST['ville'];
        $email= $_POST['email'];
        $fixe= $_POST['fixe'];
        $port= $_POST['port'];

        // On prépare la requête
        $req = $bdd->prepare('UPDATE membre SET adresse = :adresse, CP = :CP, ville = :ville, email = :email, tel_fixe = :fixe, tel_port = :port WHERE pseudo = :pseudo');
        // On execute la requête
        $req ->execute([
            "adresse" => $adresse,
            "CP" => $CP,
            "ville" => $ville,
            "email" => $email,
            "fixe" => $fixe,
            "port" => $port,
            "pseudo" => $pseudo_session]);
        // On affiche un message de confirmation
        $succes = "Vos informations ont bien été mises à jour";
    }

    // On vérifie si l'utilisateur a cliqué sur le bouton de changement de mot de passe
    if(isset($_POST['change_mdp'])){
        // On vérifie que les champs ne sont pas vides
      if(!empty($_POST['mdp']) AND !empty($_POST['mdp2']) AND !empty($_POST['mdp3'])){
        // On récupère les informations du formulaire
        $old = $_POST['mdp'];
        $new = $_POST['mdp2'];
        $new2 = $_POST['mdp3'];

        // On prépare la requête
        $selRq = $bdd->prepare('SELECT * FROM membre WHERE pseudo = :pseudo');
        // On execute la requête
        $selRq->execute(["pseudo" =>  $pseudo_session]);
        // On récupère les informations de l'utilisateur
        $sel = $selRq->fetch();
        // On vérifie si le mot de passe actuel est correct
        if($sel){
            // On vérifie si le nouveau mot de passe et l'ancien sont identiques
          if(password_verify($old, $sel['mdp']) ){
            // On vérifie si les deux nouveaux mots de passe sont identiques
            if($new == $new2){
                // On hash le nouveau mot de passe
              $new = password_hash($new, PASSWORD_DEFAULT);
                // On prépare la requête
              $req = $bdd->prepare('UPDATE membre SET mdp = :mdp WHERE pseudo = :pseudo');
                // On execute la requête
              $req ->execute([
                "mdp" => $new,
                "pseudo" => $pseudo_session
              ]);
                // On affiche un message de confirmation
                $succes = "Votre mot de passe a bien été changé";
            }else{
                // Sinon on affiche un message d'erreur pour la vérication des mots de passe (les 2 nouveaux)
              $erreur = "Les mots de passe ne correspondent pas";
            }
          }else{
                // Sinon on affiche un message d'erreur pour la vérification du mot de passe actuel
            $erreur = "Mot de passe actuel incorrect";
          }
        }else{
            // Sinon on affiche un message d'erreur si tous les champs ne sont pas remplis
          $erreur = "Veuillez remplir tous les champs";
        }
      }
    }
    ?>


    
    <h1>Vos Information : <?= $user["nom"]. " ". $user["prenom"] ?></h1>

    <div class="information">
        
       <form action="" method="POST">
            <div class="infos">
                <div class="info">
                    <label for="nom">Nom :</label>
                    <input type="text" name="nom" id="nom" value="<?= $user["nom"] ?>" disabled class="bloque">
                    <label for="prenom">Prénom :</label>
                    <input type="text" name="prenom" id="prenom" value="<?= $user["prenom"] ?>" disabled class="bloque">
                </div>

                <div class="info">
                    <label for="adresse">Adresse </label>
                    <input type="text" name="adresse" id="adresse" value="<?= $user["adresse"] ?>">
                    <label for="CP">Code Postal :</label>
                    <input type="text" name="CP" id="CP" value="<?= $user["CP"] ?>">
                    <label for="ville">Ville :</label>
                    <input type="text" name="ville" id="ville" value="<?= $user["ville"] ?>">
                </div>
                
                <div class="info">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email" value="<?= $user["email"] ?>">
                    <label for="fixe">Téléphone Fixe :</label>
                    <input type="text" name="fixe" id="fixe" value="<?= $user["tel_fixe"] ?>">
                    <label for="port">Téléphone Portable :</label>
                    <input type="text" name="port" id="port" value="<?= $user["tel_port"] ?>">
                </div>
                
                <div class="info">
                    <label for="naissance">Date de Naissance :</label>
                    <input type="date" name="naissance" id="naissance" value="<?= $user["date_naissance"] ?>" disabled class="bloque">
                    <label for="doulieu">Date d'arrivée à l'harmonie :</label>
                    <input type="date" name="doulieu" id="doulieu" value="<?= $user["date_doulieu"] ?>" disabled class="bloque">
                    <label for="fede">Date de Fédération :</label>
                    <input type="date" name="fede" id="fede" value="<?= $user["date_fede"] ?>" disabled class="bloque">
                </div>
                
                

            </div>
            
            <div class="info">
                <input type="submit" value="Mettre à jour" name="MAJ">
            </div>
            
       </form>

    </div>
    
    <div class="mdp">
      <!-- Changer le Mot de passe -->

      <form action="" method="POST">
        <div class="info">
            <label for="mdp">Ancien mot de passe :</label>
            <input type="password" name="mdp" id="mdp" placeholder="Ancien mot de passe" required>
            <label for="mdp">Mot de passe :</label>
            <input type="password" name="mdp2" id="mdp2" placeholder="Mot de passe" required>
            <label for="mdp2">Confirmer le mot de passe :</label>
            <input type="password" name="mdp3" id="mdp3" placeholder="Confirmer le mot de passe" required>
        </div>
        <div class="info">
            <input type="submit" value="Changer le mot de passe" name="change_mdp" class="mdp_submit">
        </div>

    </div>
    
    <!-- Affichage des messages d'erreur et de succès  s'il existe-->

    <div class="error">
        <?php
        
            if(isset($erreur)){
                echo $erreur;
            }
        ?>
    </div>

    <div class="succes">
        <?php
            if(isset($succes)){
                echo $succes;
            }
        ?>
    </div>
    

    
<?php
    // On inclut le footer
    require_once("../../PHP/footer.php");
?>