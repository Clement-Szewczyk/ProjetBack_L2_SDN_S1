<?php
    head();
?>

<!-- Fichier contenant la Navbar du site. Il sera inclus dans chaque page du site. -->
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- CSS -->
    <link rel="stylesheet" href="/CSS/navbar.css">

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
            <?php
                if(isset($_SESSION['role']) && $_SESSION['role'] == 2 || isset($_SESSION['role']) && $_SESSION['role'] == 1){
                    echo'
                    <li class="nav-item with-dropdown">
                        Espace Membre
                        <ul class="dropdown">
                            <li onclick="Espace()">Vos informations</li>
                            <li onclick="sortieuser()">Présence sortie</li>
                        </ul>
                    </li>
                    ';
                }else{
                    echo '<li class="nav-item" onclick="Espace()">Espace Membre</li>';
                }
            ?>
            
            <li class="nav-item" onclick="Contact()">Contact</li>
            <?php
                if(isset($_SESSION['role']) && $_SESSION['role'] == 2){
                    echo '
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
            ?>
            <div class="connect">
                <!-- Modification de l'affichage si l'utilisateur est connecté-->
                
                
                <?php
                    if(isset($_SESSION['pseudo'])){
                        echo $_SESSION['pseudo'];
                        echo '<a style="margin-left=10px;" href="../../PHP/deconnect.php">Déconnexion</a>';
                    }else{
                        echo'
                        <form action="../../PHP/connect.php" method="POST">
                        <input type="text" placeholder="Pseudo" name="pseudo" required>
                        <input type="password" placeholder="Mot de passe" name="mdp" required>
                        <input type="submit" value="Connexion" name="submit">
                        </form>
                        ';
                    
                    }
                ?>
                

            </div>
        </ul>
    </nav>
    
</body>
</html>