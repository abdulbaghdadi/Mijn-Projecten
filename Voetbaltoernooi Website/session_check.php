<?php
// Start de PHP-sessie
session_start();

// Functie om te controleren of een gebruiker is ingelogd
function checkLoggedIn() {
    // Als de gebruikers-ID niet is ingesteld in de sessie, doorverwijzen naar de inlogpagina
    if (!isset($_SESSION['user_id'])) {
        header("Location: index.php");
        exit();
    }
}
?>
