<?php
// On démarre la session
session_start();
// On inclut la connexion à la base
require_once("./bdd.php");

// On vérifie qu'il a la permission d'être ici
if($_SESSION['role'] != 2){
    // Sinon on le redirige vers la page d'accueil
    header('Location: /');
}

// On vérifie si la variable existe
if(isset($_POST['eleves'])){
    // On initialise une variable de session pour retourner un message à l'utilisateur
    $_SESSION['error_eleves'] = null;
    // On vérifie si les champs sont bien remplis
    if(!empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email']) && !empty($_POST['naissance']) &&  !empty($_POST['tel_portable']) && !empty($_POST['role'])){ 
        
        // On récupère les données du formulaire
        $nom = $_POST['nom'];
        $prenom = $_POST['prenom'];
        $email = $_POST['email'];

        //ON vérifie si c'est bien un email
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $_SESSION['error_eleves'] = "Veuillez entrer un email valide";
            header('Location: /page/administration/ajout.php');
        }

        $naissance = $_POST['naissance'];
        $adresse = $_POST['adresse'];
        $ville = $_POST['ville'];
        $code_postal = $_POST['code_postal'];
        $tel_fixe = $_POST['tel_fixe'];
        $tel_portable = $_POST['tel_portable'];
        $pupitre = $_POST['pupitre'];
        $role = $_POST['role'];
        $avancement = $_POST['avancement'];

        // Si c'est la valeur par défaut on met à null
        if($pupitre == "Choisir un Pupitre"){
            $pupitre = null;
        }

        // On prépare la requête
        $req = $bdd->prepare('INSERT INTO eleves(nom, prenom, email, date_naissance, adresse, ville, CP, tel_fixe, tel_port, pupitre, role, avancement) VALUES(:nom, :prenom, :email, :naissance, :adresse, :ville, :code_postal, :tel_fixe, :tel_portable, (SELECT pupitre_id From pupitre WHERE nom_pupitre = :pupitre),(SELECT id_role From role WHERE nom_role = :role), :avancement )');
        // On execute la requête
        $req ->execute(["nom" => $nom,"prenom" => $prenom,"email" => $email,"naissance" => $naissance,"adresse" => $adresse,"ville" => $ville,"code_postal" => $code_postal,"tel_fixe" => $tel_fixe,"tel_portable" => $tel_portable,"pupitre" => $pupitre,"role" => $role, "avancement" => $avancement]);
        
        // On redirige avec un message de confirmation
        header('Location: /page/administration/eleves.php');

    }else{
        // Sinon on redirige avec un message d'erreur et on redirige vers la page d'ajout
        $_SESSION['error_eleves'] = "Veuillez remplir tous les champs obligatoires lors de l'inscription d'un élève";
        header('Location: /page/administration/ajout.php');
    }
}

?>