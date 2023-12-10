
    <?php require_once("../../PHP/header.php"); 
    head("Répétitions", "repetition");
?>  
    <h1>Les répétitions :</h1>
    
    <div class="info">
        <p>Afin de préparer les programmes pour chaque concert et représentation, nous nous retrouvons tous les mercredis de l'année (hors juillet/aout & fêtes de fin d'année) pour une répétition de 20H00 à 21H30.
        <br><br>
        Nous répétons dans la maison communale de Le Doulieu : soyez curieux, n'hésitez pas à venir nous rendre visite pendant l'une de nos répétitions... et peut-être <a href="./ecole.php">intégrer nos rangs...</a>
        </p>
    </div>

    <?php
        // Tableaux de noms de mois et de jours en français
        $months = [
            1 => "Janvier",
            2 => "Février",
            3 => "Mars",
            4 => "Avril",
            5 => "Mai",
            6 => "Juin",
            7 => "Juillet",
            8 => "Août",
            9 => "Septembre",
            10 => "Octobre",
            11 => "Novembre",
            12 => "Décembre"
        ];

        $days = [
            0 => "Dimanche",
            1 => "Lundi",
            2 => "Mardi",
            3 => "Mercredi",
            4 => "Jeudi",
            5 => "Vendredi",
            6 => "Samedi"
        ];

        // Définir la date de la prochaine répétition (aujourd'hui)
        $nextRehearsalDate = new DateTime();

        // Vérifier si aujourd'hui est un mercredi
        if ($nextRehearsalDate->format('N') != 3) { // 3 correspond à mercredi (1 pour lundi, 2 pour mardi, etc.)
            // Si ce n'est pas un mercredi, avancer jusqu'au prochain mercredi
            $nextRehearsalDate->modify('next Wednesday');
        }

        // Définir l'heure de la répétition à 20h
        $nextRehearsalDate->setTime(20, 0);

        // Formater la date de la prochaine répétition en utilisant les tableaux de noms de mois et de jours en français
        $formattedDate = $days[$nextRehearsalDate->format('w')] . ' ' . $nextRehearsalDate->format('d') . ' ' . $months[$nextRehearsalDate->format('n')] . ' ' . $nextRehearsalDate->format('Y \à H:i');

        // Afficher la date de la prochaine répétition au format souhaité
        echo '<h3 class="prochain">La prochaine répétition aura lieu le ' . $formattedDate . "</h3>";


    ?>






<?php
    require_once("../../PHP/footer.php");
?>