    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];
        $lastname = $_POST['lastname'];
        $email = $_POST['email'];
        $message = $_POST['message'];
        
        $to = 'clement.szewczyk@gmail.com'; // Adresse e-mail de destination
        $subject = 'Demande de contact depuis le site web';
        $headers = "From: $email \r\n";
        
        // Construction du corps du message
        $email_content = "$name $lastname\n\n";
        $email_content .= "Email: $email\n\n";
        $email_content .= "Message:\n$message\n";
        
        // Envoi de l'e-mail
        if (mail($to, $subject, $email_content, $headers)) {
            $response = "Votre message a été envoyé avec succès.";
            
        } else {
            $response = "Une erreur s'est produite lors de l'envoi du message.";
            // Variable pour rajouter la class CSS "bad" à la div de la réponse
            $class = "bad";
        }
        
    }

    // Inclusion de la navbar
    require_once '../PHP/header.php';
    head("Contact", "contact2");
?>



   
        <h1>Contactez-Nous</h1>

        <!-- Pourquoi nous contacter -->
        <div class="why">
            <ul>
                <li class="option">Jeune ou adulte, vous aimeriez commencer l'apprentissage de la musique ?</li>
                <li class="option">Musicien, débutant ou confirmé, vous souhaitez partager quelques notes avec nous voire intégrer notre ensemble ?</li>
                <li class="option">Mairie, association, vous voulez nous soliciter pour une manifestation ?</li>
                <li class="option">Vous souhaitez simplement en savoir plus sur la vie de l'harmonie ?</li>
            </ul>
        </div>
        
        <!-- Formulaire de contact -->
        <div class="contact">
            <!--
                Method : POST pour ne pas afficher les données dans l'URL
            -->

            <form action="" method="post">
                <div class="info_personne">
                    <input type="text" id="name" name="name" placeholder="Prénom" required>
                    <input type="text" id="lastname" name="lastname"placeholder="Nom" required><br><br>
                </div>
                
                <input type="email" id="email" name="email" placeholder="Email" required><br><br>
                
                <textarea id="message" name="message" rows="5" cols="30" placeholder="Ici votre message ..." required></textarea><br><br>
                
                <div class="button">
                    <input class="Submit" type="submit" value="Envoyer">
                    <input class="Submit"    type="reset" value="Effacer">
                </div>
                <div class="reponse" id="reponse_container">
                    
                    <!-- Affichage de la réponse si elle existe -->
                    <?php
                        if (isset($response)) {
                            if(isset($class)){
                                echo "<p class=\"result\" class=\"". $class . "\">";
                            }else{
                                echo "<p class=\"result\">";
                                echo $response;
                                echo "</p>";
                            }   
                        }
                    ?>
                    
                </div>
            </form>
           
        </div>
<?php
    require_once '../PHP/footer.php';
?>