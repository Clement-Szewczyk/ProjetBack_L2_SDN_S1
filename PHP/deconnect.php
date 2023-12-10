<?php
    // On Démare la session
    session_start();
    // On détruit la session
    session_destroy();
    // On redirige vers la page d'accueil
    header('Location: /');
?>