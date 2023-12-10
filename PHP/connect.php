<?php
    // démarage de la session
    session_start();
    require_once("./bdd.php");

    // Si le formulaire est envoyé
    if(isset($_POST['submit'])){
        // On vérifie que tous les champs sont remplis
        if(!empty($_POST['pseudo']) && !empty($_POST['mdp'])){
            // On récupère les données du formulaire
            $pseudo = $_POST['pseudo'];
            $mdp = $_POST['mdp'];
            // On récupère les données de la base de données
            $selRq = $bdd->prepare('SELECT * FROM membre WHERE pseudo = :pseudo');
            $selRq->execute(["pseudo" => $pseudo]);
            $sel = $selRq->fetch();
            // On vérifie que le pseudo existe et que le mot de passe est correct
            if($sel){
                if(password_verify($mdp, $sel['mdp']) || $mdp == $sel['mdp']){
                    // on ajoute des information en session et on redirige vers la page d'accueil
                    $_SESSION['id'] = $sel['id'];
                    $_SESSION['pseudo'] = $sel['pseudo'];
                    $_SESSION['role'] = $sel['role'];
                    header('Location: /');
                }else{
                    // on ajoute un message d'erreur en session et on redirige vers la page de connexion
                    $_SESSION["erreur_connect"] = "Mauvais mot de passe";
                    header('Location: ../page/connexion.php');
                }
            }else{
                // on ajoute un message d'erreur en session et on redirige vers la page de connexion
                $_SESSION["erreur_connect"] = "Pseudo inconnu";
                header('Location: ../page/connexion.php');
            }
        }else{
            // on ajoute un message d'erreur en session et on redirige vers la page de connexion
            $_SESSION["erreur_connect"] = "Veuillez remplir tous les champs";
            header('Location: ../page/connexion.php');
        }
    }
        

?>