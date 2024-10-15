<?php
// Vereisen van het bestand met databaseverbinding
require_once('database_connection.php');

// Starten van de PHP-sessie
session_start();

// Controleren of het formulier is ingediend via de POST-methode
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ontvangen van gebruikersnaam en gehasht wachtwoord uit het formulier
    $username = $_POST['username'];
    $password = $_POST['password_hash'];

    // Gebruiker ophalen uit de database op basis van gebruikersnaam
    $stmt = $db->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->bindParam(':username', $username);
    $stmt->execute();
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // Verifiëren van het wachtwoord en de rol van de gebruiker
    if ($user && password_verify($password, $user['password_hash']) && $user['role'] == 'admin') {
        // Als het een beheerder is, sessievariabelen instellen en doorverwijzen naar het beheerdersdashboard
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;
        $_SESSION["role"] = 'admin';

        header("Location: admin_.php");
        exit();
    } elseif ($user && password_verify($password, $user['password_hash']) && $user['role'] == 'user') {
        // Als het een gebruiker is, sessievariabelen instellen en doorverwijzen naar het gebruikersdashboard
        $_SESSION["loggedin"] = true;
        $_SESSION["username"] = $username;
        $_SESSION["role"] = 'user';

        header("Location: user_dashboard.php");
        exit();
    } else {
        // Als authenticatie mislukt, doorverwijzen naar het inlogscherm en een foutmelding weergeven
        header("Location: login.php");
        echo "Ongeldige gebruikersnaam, wachtwoord of rol.";
    }
}
?>
