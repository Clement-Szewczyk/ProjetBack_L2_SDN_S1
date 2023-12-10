<?php
    // On démarre la session
    require_once('../../PHP/bdd.php');
    // On inclut le template de la navbar
    require_once("../../PHP/header.php");
    head("Membre", "membre");
    // On vérifie que l'utilisateur est bien un administrateur
    if(!isset($_SESSION['role'])){
        header('Location: /page/connexion.php');
    }else{
        if($_SESSION['role'] != 2){
            header('Location: /');
        }
    }
?>


    <h1>Les Musiciens </h1>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Pseudo</th>
                <th>Email</th>
                <th>Tel_Fixe</th>
                <th>Tel_Portable</th>
                <th>Adresse</th>
                <th>Code_Postal</th>
                <th>Ville</th>
                <th>Date de naissance</th>
                <th>Date Entrée Doulieu</th>
                <th>Date entrée Fédé</th>
                <th>Pupitre</th>
                <th>Rôle</th>
                <th>Modifier</th>
            </tr>
        </thead>
        <tbody>
            <?php
                // On récupère les données de la base de données
                $req = $bdd->query('SELECT * FROM membre');
                // On affiche chaque entrée une à une
                while($donnees = $req->fetch()){
                    if($donnees['pseudo'] == "sadmin"){
                        // passe au suivant sans afficher
                        continue;
                    }
                    echo '<tr>';
                    echo '<td>'.$donnees['nom'].'</td>';
                    echo '<td>'.$donnees['prenom'].'</td>';
                    echo '<td>'.$donnees['pseudo'].'</td>';
                    echo '<td>'.$donnees['email'].'</td>';
                    echo '<td>'.$donnees['tel_fixe'].'</td>';
                    echo '<td>'.$donnees['tel_port'].'</td>';
                    echo '<td>'.$donnees['adresse'].'</td>';
                    echo '<td>'.$donnees['CP'].'</td>';
                    echo '<td>'.$donnees['ville'].'</td>';
                    echo '<td>'.$donnees['date_naissance'].'</td>';
                    echo '<td>'.$donnees['date_doulieu'].'</td>';
                    echo '<td>'.$donnees['date_fede'].'</td>';
                    
                    if($donnees['pupitre'] == NULL){
                        echo '<td></td>';
                    }else{
                        // On récupère le nom du pupitre en fonction de son id
                        echo '<td>'.$bdd->query('SELECT nom_pupitre FROM pupitre WHERE pupitre_id = '.$donnees["pupitre"].'')->fetchColumn().'</td>';
                    }
                    if($donnees['role'] == NULL){
                        echo '<td></td>';
                    }else{
                        // On récupère le nom du role en fonction de son id
                        echo '<td>'.$bdd->query('SELECT nom_role FROM role WHERE id_role = '.$donnees["role"].'')->fetchColumn().'</td>';
                    }
                    // Création du lien pour modifier le musicien
                    echo '<td><a href="modif_user.php?id='.$donnees['id'].'">Modifier</a></td>';
                    echo '</tr>';
                }
            ?>
        </tbody>
    </table>
<?php
    // On inclut le template du footer
    require_once("../../PHP/footer.php");
?>