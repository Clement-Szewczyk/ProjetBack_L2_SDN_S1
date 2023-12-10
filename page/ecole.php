
    <?php 
        // Inclusion de la navbar
        require_once '../PHP/header.php';
        head("Ecole de Musique", "ecole");
    ?>
    <!-- Information sur l'école de musique -->
    <h1>Ecole de Musique</h1>
    <div class="ecole">
        <p>
        Les cours sont ouverts aux enfants à partir de 7 ans et aux adultes (cours spécifiques). Cette formation a pour perspective de rentrer à l'harmonie dès la fin de la troisième année d'étude.
        <br><br>
        L'élève suit une première année de formation musicale (solfège-théorie) et formation instrumentale.
        <br><br>
        Les instruments enseignés à l'école de musique font partie des familles d'instruments à vent et percussions : Flûte, clarinette, saxophone, trompette, trombone, basse, batterie, tambour, timbales, xylophone...
        <br><br>
        Pour les plus jeunes (4-6 ans), nous proposons depuis 2021 une classe d'éveil musical.
        <br><br>
        Cette formation musicale et instrumentale est dispensée par une équipe de professeurs compétents et soucieux de transmettre à chaque élève leur savoir-faire et passion.
        <br><br>
        Au mois de mai ou juin chaque élève passe les examens afin de valider le niveau d'acquisition des connaissances. L'élève se voit alors remettre un diplôme à l'occasion de l'arbre de Noël de l'école de musique.
        <br><br>
        Les inscriptions ont lieu pendant le mois de septembre mais restent possible durant toute lannée.
        </p>
    </div>

    <!-- Tarifs -->
    <div class="tarifs">
        <h2>Tarifs</h2>
        <div class="table">
            <table>
                <tr>
                    <th>Adhésion</th>
                    <th>Prix</th>
                    
                </tr>
                <tr >
                    <td>Solfège + Instrument</td>
                    <td >75€</td>
                    
                </tr>
                <tr>
                    <td>Instrument Seul</td>
                    <td>60€</td>
            
                </tr>
                <tr>
                    <td>Eveil Musicale</td>
                    <td >60€</td>
                    
                </tr>
                <tr>
                    <td>Location Instrument</td>
                    <td>25€ /an</td>
                    
                </tr>
            </table>
        </div>
    </div>


    <!-- L'équipe pédagogique -->
    <h2>L'équipe Pédagogique</h2>
    <div class="table">
        <table>
                
            <tr>
                <td>Solfège</td>
                <td >René Sinnaeve</td>
            </tr>
            <tr>
                <td>Flûte</td>
                <td>Céline Blondiau</td>
            </tr>
            <tr>
                <td>Clarinette</td>
                <td>René Sinnaeve</td>
            </tr>
            <tr>
                <td>Saxophone</td>
                <td>Trystan Canis</td>
            </tr>
            <tr>
                <td>Trompette / Cornet </td>
                <td>Maxence Leborgne</td>
            </tr>
            <tr>
                <td>Trombone</td>
                <td>Julien Marichez</td>
            </tr>
            <tr>
                <td>Percusion</td>
                <td>Lionel Obin</td>
            </tr>

        </table>
    </div>
<?php
    // Inclusion du footer
    require_once '../PHP/footer.php';
?>