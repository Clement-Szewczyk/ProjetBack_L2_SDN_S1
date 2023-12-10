
    <?php
        // Inclusion de la navbar
        require_once '../PHP/header.php';
        head("Connexion", "connexion");  
    ?>
    <h1>Se Connecter</h1>
    <div class="connect page">
        <!-- Formulaire de connexion   qui renvoie vers une page de traitement en méthod post-->
        <form action="../PHP/connect.php" method="POST">
            <input type="text" placeholder="Pseudo" name="pseudo" required>
            <input type="password" placeholder="Mot de passe" name="mdp" required>
            <input type="submit" value="Connexion" name="submit">
        </form>
    </div>

    <!-- Affichage d'une potentiel erreur de connexion -->
    <?php
        if(isset($_SESSION["erreur_connect"])){
            echo '<div class="result">';
            echo $_SESSION["erreur_connect"];
            unset($_SESSION["erreur_connect"]);
            echo '</div>';
        }

        require_once '../PHP/footer.php';
        
    ?>
