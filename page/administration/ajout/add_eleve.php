<?php
    // On vérifie que l'utilisateur est admin
    if($_SESSION['role'] != 2){
        header('Location: /');
    }
?>

    <div class="add_musicien">
        <h1>Ajout d'un élève</h1>
    <!-- Form pour ajouter un eleves qui envoie les données à la page /PHP/eleves.php -->
    <form action="/PHP/eleves.php" method="POST">
        <div class="info">
            <label for="nom">Nom</label>
            <input type="text" name="nom" placeholder="Nom" required>
            <label for="prenom">Prénom</label>
            <input type="text" name="prenom" placeholder="Prenom" required>
        </div>
        <div class="info">
            <label for="email">Email</label>
            <input type="email" name="email" placeholder="Email" required>
            <label for="naissance">Date de Naissance</label>
            <input type="date" name="naissance" placeholder="Date de Naissance" required>
        </div>
        <div class="info">
            <label for="adresse">Adresse</label>
            <input type="text" name="adresse" placeholder="Adresse">
            <label for="ville">Ville</label>
            <input type="text" name="ville" placeholder="Ville">
            <label for="code_postal">Code Postal</label>
            <input type="text" name="code_postal" placeholder="Code Postal">
        </div>
        <div class="info">
            <label for="tel_fixe">Téléphone Fixe</label>
            <input type="text" name="tel_fixe" placeholder="Téléphone Fixe">
            <label for="tel_portable">Téléphone Portable</label>
            <input type="text" name="tel_portable" placeholder="Téléphone Portable" required>
        </div>
       
        <div class="info">
            <label for="pupitre">Pupitre :</label>
            <!-- On réalise un select pour sélectionner le pupitre en fonction de ce qui est créer -->
            <Select name="pupitre" >
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
                    echo('<option >Choisir un rôle</option>');
                    while($role = $roles->fetch()){
                        if ($role['nom_role'] == "Eleves"){
                            echo("<option selected>".$role['nom_role']."</option>");
                        }
                        else{
                            echo("<option>".$role['nom_role']."</option>");  
                        }  
                       
                                 
                    }                
                ?>
            </Select>
            
            
        </div>
        
        <div class="info">
            <label for="avancement">Avancement</label>
            <input type="text" name="avancement" placeholder="Avancement">
        </div>

        <div class="button">            
                <input type="submit"  name="eleves">
        </div>
    </form>
    </div> 
