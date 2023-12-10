<!-- AJOUT Musicien -->
<?php
    require_once("./bdd.php");
    if(isset($_POST['musicien'])){
        // On vérifie que tous les champs sont remplis
        if(!empty($_POST['nom']) AND !empty($_POST['prenom']) AND !empty($_POST['pseudo']) AND !empty($_POST['email']) AND !empty($_POST['naissance']) AND !empty($_POST['doulieu']) AND !empty($_POST['fede']) AND !empty($_POST['mdp']) AND !empty($_POST['pupitre']) AND !empty($_POST['role'])){

            // On récupère les données du formulaire
            $nom = $_POST['nom'];
            $prenom = $_POST['prenom'];
            $pseudo = $_POST['pseudo'];
            $email = $_POST['email'];
            $fixe = $_POST['fixe'];
            $port = $_POST['port'];
            $adresse = $_POST['adresse'];
            $CP = $_POST['CP'];
            $ville = $_POST['ville'];
            $naissance = $_POST['naissance'];
            $doulieu = $_POST['doulieu'];
            $fede = $_POST['fede'];
            $mdp = $_POST['mdp'];
            $pupitre = $_POST['pupitre'];
            $role = $_POST['role'];
            
            // On hash le mot de passe
            $mdp2 = password_hash($mdp, PASSWORD_DEFAULT);
            
            // On insère les données dans la base de données
            $req = $bdd->prepare('INSERT INTO membre(nom, prenom, pseudo, email, adresse, CP, ville, tel_fixe, tel_port, date_naissance, date_doulieu, date_fede, mdp, pupitre, role) VALUES(:nom, :prenom, :pseudo, :email, :adresse, :CP, :ville, :fixe, :port, :naissance, :doulieu, :fede, :mdp, (SELECT pupitre_id From pupitre WHERE nom_pupitre = :pupitre),(SELECT id_role From role WHERE nom_role = :role) )');
            $req ->execute(["nom" => $nom,"prenom" => $prenom,"pseudo" => $pseudo,"email" => $email,"adresse" => $adresse,"CP" => $CP,"ville" => $ville,"fixe" => $fixe,"port" => $port,"naissance" => $naissance,"doulieu" => $doulieu,"fede" => $fede,"mdp" => $mdp2,"pupitre" => $pupitre,"role" => $role]);
            
            // Envoit email de confirmation
            $to = $email;
            $subject = "Inscription à l'harmonie Les Amis Réunis de Le Doulieu";
            $message = "Bonjour ".$prenom." ".$nom.",\n\nNous vous confirmons votre inscription à l'harmonie Les Amis Réunis de Le Doulieu.\n\nVotre identifiant est : ".$pseudo."\nVotre mot de passe est : ".$mdp."\n\n
            Vous pouvez changer votre Mot de Passe dans votre espace personnel.\n\n
            Vous pouvez vous connecter à l'adresse suivante : http://localhost:8888/page/connexion.php\n\nA bientôt !\n\nL'harmonie Les Amis Réunis de Le Doulieu";
            $headers = "From: $email \r\n";
            
            mail($to, $subject, $message, $headers);

            //retourne sur la page musicien.php
            header('Location: /page/administration/musicien.php');
        }
        else{
            //retourne un message sur la page add_musicien.php
            $_SESSION['error_musicien'] = "Veuillez remplir tous les champs obligatoires lors de l'inscription d'un musicien";
            header('Location: /page/administration/ajout.php?error=1');
        }
    }
?>