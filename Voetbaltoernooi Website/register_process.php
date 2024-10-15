<?php
// Vereisen van het bestand met databaseverbinding
require_once('database_connection.php');

// Controleren of het formulier is ingediend via de POST-methode
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Ontvangen van gebruikersgegevens en teaminformatie uit het formulier
    $username = $_POST['username'];
    $password = $_POST['password'];
    $teamName = $_POST['team_name'];
    $players = $_POST['players'];

    // Wachtwoord hashen voor beveiliging
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Voorbereiden en uitvoeren van de SQL-query om de gebruiker in de database in te voegen
    $stmtUser = $db->prepare("INSERT INTO users (username, password_hash) VALUES (:username, :password_hash)");
    $stmtUser->bindParam(':username', $username);
    $stmtUser->bindParam(':password_hash', $hashedPassword);

    try {
        $db->beginTransaction();

        $stmtUser->execute();

        // Haal de gebruikers-ID op van de zojuist ingevoegde gebruiker
        $userId = $db->lastInsertId();

        // Voorbereiden en uitvoeren van de SQL-query om het team in de database in te voegen
        $stmtTeam = $db->prepare("INSERT INTO teams (team_name, user_id) VALUES (:team_name, :user_id)");
        $stmtTeam->bindParam(':team_name', $teamName);
        $stmtTeam->bindParam(':user_id', $userId);
        $stmtTeam->execute();

        // Haal het team-ID op van het zojuist ingevoegde team
        $teamId = $db->lastInsertId();

        // Voorbereiden en uitvoeren van de SQL-query om spelers in de database in te voegen
        $stmtPlayers = $db->prepare("INSERT INTO players (player_name, team_id) VALUES (:player_name, :team_id)");
        $stmtPlayers->bindParam(':team_id', $teamId);

        foreach ($players as $playerName) {
            $stmtPlayers->bindParam(':player_name', $playerName);
            $stmtPlayers->execute();
        }

        // Bevestig de transactie als alles succesvol is
        $db->commit();

        // Geef een succesbericht weer en doorverwijzen naar de inlogpagina
        header("Location: login.php");

    } catch (PDOException $e) {
        // Maak de transactie ongedaan in geval van een fout en geef een foutmelding weer
        $db->rollBack();
        echo "Fout: " . $e->getMessage();
    }
}
?>
