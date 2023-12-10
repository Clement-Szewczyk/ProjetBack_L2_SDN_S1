<?php
    require_once('../../PHP/bdd.php');
    require_once('../../PHP/header.php');
    head("Ajout", "ajout");
    // On vérifie si l'utilisateur est bien un admin
    if(!isset($_SESSION['role'])){
        header('Location: /page/connexion.php');
    }else{
        if($_SESSION['role'] != 2){
            header('Location: /');
        }
    }
    
?>

    <div class="form" id="Form">
        <h1>Ajout</h1>
        <form action="" method="POST">
            <div class="bloc">
                <div class="info">
                    <label for="">Elèves</label>
                    <input type="radio" placeholder="Elèves" name="info" value='1'>                    
                </div>
                <div class="info">
                    <label>Musicien</label>
                    <input type="radio" placeholder="Musicien" name="info" value='2'>
                </div>
                <div class="info">
                    <label for="">Professeur</label>
                    <input type="radio" placeholder="Professeur" name="info" value='3'>
                </div>
            </div>

            <input type="submit" name="submit">

        </form>    
    </div>
    <?php
        // On analyse le formulaire et on vérifie qu'il est bien rempli
        if(isset($_POST['submit']) || !empty($_POST['info'])){
            // On ajoute le formulaire correspondant au radio button
            if($_POST['info'] == 1){
                echo '<div class="add">';
                    require_once('./ajout/add_eleve.php');
                echo '</div>';
                // Cacher la div d'id Form
                echo '<script>document.getElementById("Form").style.display = "none";</script>';
            }else if($_POST['info'] == 2){
                echo '<div class="add">';
                    require_once('./ajout/add_musicien.php');
                echo '</div>';

        
                // Cacher la div d'id Form
                echo '<script>document.getElementById("Form").style.display = "none";</script>';
            }else if($_POST['info'] == 3){
                header('Location: /page/administration/ajout_professeur.php');
                // Cacher la div d'id Form
                echo '<script>document.getElementById("Form").style.display = "none";</script>';
            }
                
        }
    ?>

    <div class="error_message">
        <?php
            if(isset($_SESSION['error_eleves'])){
                echo "<p>";
                echo($_SESSION['error_eleves']);
                $_SESSION['error_eleves'] = null;
                echo "</p>";
            }
        ?>
    </div>
<?php
    require_once('../../PHP/footer.php');
?>

