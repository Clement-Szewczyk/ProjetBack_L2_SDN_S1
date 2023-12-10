<?php
    session_start();
    function head($title, $css){
        //session_start();
        echo'
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>'.$title.'</title>

            <!-- CSS -->
            <link rel="stylesheet" href="/CSS/navbar.css">
            <link rel="stylesheet" href="/CSS/bibliotheque.css">
            '.css($css).'

            <!-- JS -->
            <script src="/JS/navbar.js"></script>
        </head>
        <body>
        <nav>
        
        <ul class="navbar">
            <img src="/img/logo_harmonie.svg" alt="Logo" onclick="Accueil()">
            <li class="nav-item with-dropdown">
                Harmonie
                <ul class="dropdown">
                    <li onclick="Historique()">Historique</li>
                    <li onclick="Direction()">La Direction Musicale</li>
                    <li onclick="Commission()">La Commission Administrative</li>
                    <li onclick="Repetition()">Les Répétitions</li>
                    <li onclick="Calendrier()">Le Calendrier des sorties</li>
                </ul>
            </li>
            <li class="nav-item" onclick="Ecole()">Ecole de musique</li>
            '.
                membre()
            .'
            
            <li class="nav-item" onclick="Contact()">Contact</li>
            '.
                admin()
            .'
            <div class="connect">
               
                
                
                '.
                    connect()
                .'
                

            </div>
        </ul>
    </nav>
        
        ';
    }

    function membre(){
        if(isset($_SESSION['role']) && $_SESSION['role'] == 2 || isset($_SESSION['role']) && $_SESSION['role'] == 1){
            return'
            <li class="nav-item with-dropdown">
                Espace Membre
                <ul class="dropdown">
                    <li onclick="Espace()">Vos informations</li>
                    <li onclick="sortieuser()">Présence sortie</li>
                </ul>
            </li>
            ';
        }else{
            return '<li class="nav-item" onclick="Espace()">Espace Membre</li>';
        }
    }

    function admin(){
        if(isset($_SESSION['role']) && $_SESSION['role'] == 2){
            return '
            <li class="nav-item with-dropdown">
                Administration
                <ul class="dropdown">
                    <li onclick="Musicien()">Musicien</li>
                    <li onclick="Eleves()">Eleves</li>
                    <li onclick="Instrument()">Instrument</li>
                    <li onclick="Ajout()">Ajout personne</li>
                    <li onclick="Sortie()">Sortie</li>
                    
                </ul>
            </li>
            
            ';
        }
    }

    function connect(){
        if(isset($_SESSION['pseudo'])){
            return $_SESSION['pseudo'] . '<a style="margin-left=10px;" href="../../PHP/deconnect.php">Déconnexion</a>';
        }else{
            return'
            <form action="../../PHP/connect.php" method="POST">
            <input type="text" placeholder="Pseudo" name="pseudo" required>
            <input type="password" placeholder="Mot de passe" name="mdp" required>
            <input type="submit" value="Connexion" name="submit">
            </form>
            ';
        
        }
    }

    function css($css){
        if($css == null){
            return;
        }
        else{
            return '<link rel="stylesheet" href="/CSS/'.$css.'.css">';
        }
    }
?>

