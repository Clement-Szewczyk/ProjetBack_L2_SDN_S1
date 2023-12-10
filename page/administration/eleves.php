<?php
    require_once('../../PHP/bdd.php');
    require_once('../../PHP/header.php');
    head("Elèves", "membre");
    // On vérifie si l'utilisateur est bien un admin
    if(!isset($_SESSION['role'])){
        header('Location: /page/connexion.php');
    }else{
        if($_SESSION['role'] != 2){
            header('Location: /');
        }
    }
?>


    <h1>Les élèves </h1>

    <table>
        <thead>
            <tr>
                <th>Nom</th>
                <th>Prénom</th>
                <th>Email</th>
                <th>Tel_Fixe</th>
                <th>Tel_Portable</th>
                <th>Adresse</th>
                <th>Code_Postal</th>
                <th>Ville</th>
                <th>Date de naissance</th>
                <th>Pupitre</th>
                <th>Rôle</th>
                <th>Avancement</th>
                <th>Modifier</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // On récupère les informations de la table élèves
                $req = $bdd->query('SELECT * FROM eleves');
                // On affiche les informations de la table élèves
                while($donnees = $req->fetch()){
                    echo '<tr>';
                    echo '<td>'.$donnees['nom'].'</td>';
                    echo '<td>'.$donnees['prenom'].'</td>';
                    echo '<td>'.$donnees['email'].'</td>';
                    echo '<td>'.$donnees['tel_fixe'].'</td>';
                    echo '<td>'.$donnees['tel_port'].'</td>';
                    echo '<td>'.$donnees['adresse'].'</td>';
                    echo '<td>'.$donnees['CP'].'</td>';
                    echo '<td>'.$donnees['ville'].'</td>';
                    echo '<td>'.$donnees['date_naissance'].'</td>';
                    // On affiche le pupitre et le rôle en fonction de l'id
                    if($donnees['pupitre'] == NULL){
                        echo '<td></td>';
                    }else{
                        echo '<td>'.$bdd->query('SELECT nom_pupitre FROM pupitre WHERE pupitre_id = '.$donnees["pupitre"].'')->fetchColumn().'</td>';
                    }
                    if($donnees['role'] == NULL){
                        echo '<td></td>';
                    }else{
                        echo '<td>'.$bdd->query('SELECT nom_role FROM role WHERE id_role = '.$donnees["role"].'')->fetchColumn().'</td>';
                    }
                    echo '<td>'.$donnees['avancement'].'</td>';
                    echo '<td><a href="modif_eleves.php?id='.$donnees['eleves_id'].'">Modifier</a></td>';
                    echo '</tr>';
                }
            ?>
        </tbody>
    </table>
<?php
    require_once('../../PHP/footer.php');
?>