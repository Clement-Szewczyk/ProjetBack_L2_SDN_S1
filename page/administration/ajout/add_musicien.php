<?php
// On vérifie que l'utilisateur est bien connecté et qu'il est admin
    if($_SESSION['role'] != 2){
        header('Location: /');
    }
?>
    <h1>Ajout d'un musicien</h1>
    <!-- Form pour ajouter un Musicien -->
    <div class="add_musicien">
        <!-- On envoie les données du formulaire à la page /PHP/musicien.php -->
        <form action="/PHP/musicien.php" method="POST">
            <div class="info">
                <label for="nom">Nom :</label>
                <input type="text" placeholder="Nom" name="nom" required  >
                <label for="prenom">Prénom :</label>
                <input type="text" placeholder="Prénom" name="prenom" required>
                <label for="pseudo">Pseudo</label>
                <input type="text" placeholder="Pseudo" name="pseudo" required>
            </div>
            <div class="info">
                <label for="email">Email :</label>
                <input type="text" placeholder="Email" name="email" required>
                <label for="Tel_Fixe">Téléphone fixe :</label>
                <input type="text" placeholder="Tel_Fixe" name="fixe" >
                <label for="Tel_Port">Téléphone portable :</label>
                <input type="text" placeholder="Tel_Port" name="port" required>
            </div>
            <div class="info">
                <label for="adresse">Adresse :</label>
                <input type="text" placeholder="Adresse" name="adresse" >
                <label for="CP">Code Postale :</label>
                <input type="text" placeholder="Code_Postal" name="CP" >
                <label for="ville">Ville :</label>
                <input type="text" placeholder="Ville" name="ville" >
            </div>
            <div class="info">
                <label for="naissanec">Date de naissance :</label>
                <input type="date" placeholder="Date de naissance" name="naissance" required >
                <label for="doulieu">Date d'entrée à Le Doulieu :</label>
                <input type="date" placeholder="Date Entrée Doulieu" name="doulieu" required>
                <label for="fede">Date entrée Fédération :</label>
                <input type="date" placeholder="Date entrée Fédé" name="fede" required>
            </div>
            <div class="info">
                <label for="mdp">Mot de Passe</label>
                <input type="password" placeholder="Mot de Passe" name="mdp" required>
                <label for="pupitre">Pupitre :</label>
                <!-- On réalise un select pour sélectionner le pupitre en fonction de ce qui est créer -->
                <Select name="pupitre" required>
                    <?php
                        $pupitres  =$bdd->query('SELECT * FROM pupitre');
                        echo('<option  selected>Choisir un Pupitre</option>');
                        while($pupitre = $pupitres->fetch()){
                            echo("<option>".$pupitre['nom_pupitre']."</option>");  
                        
                        }
                            
                    ?>
                </Select>
                <label for="role">Rôle :</label>
                <!-- Pareil que le pupitre mais pour les rôles -->
                <Select name="role" required >
                    <?php
                        $roles  =$bdd->query('SELECT * FROM role');
                        echo('<option  selected>Choisir un rôle</option>');
                        while($role = $roles->fetch()){
                            if ($role['nom_role'] == "Musicien"){
                                echo("<option selected>".$role['nom_role']."</option>");
                            }
                            else{
                                echo("<option>".$role['nom_role']."</option>");  
                            }  
                           
                                     
                        }       
                            
                            
                ?>
            </Select>
            </div>
            <div class="button">            
                <input type="submit" value="Ajouter" name="musicien">
            </div>
        </form>
    </div>

    
<?php
    require_once("../../PHP/footer.php");
?>

