<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Spelers</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
<?php

// Inclusief het bestand voor de databaseverbinding
require_once 'database_connection.php';

// Stel dat er een functie is om spelers op te halen op basis van team-ID
function getPlayersByTeamId($teamId, $db) {
    $stmt = $db->prepare("SELECT player_name FROM players WHERE team_id = :team_id");
    $stmt->bindParam(':team_id', $teamId);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Controleer of team_id is opgegeven in de URL
if (isset($_GET['team_id'])) {
    $teamId = $_GET['team_id'];

    // Haal spelers op voor het geselecteerde team
    $players = getPlayersByTeamId($teamId, $db);

    // Toon spelers binnen een container
    if (!empty($players)) {
        echo "<div class='players-container'>";
        echo "<h3>Spelers bekijken</h3>";
        foreach ($players as $player) {
            // Toon elke speler binnen zijn eigen container
            echo "<div class='player-card'>";
            echo "<p>{$player['player_name']}</p>";
            echo "</div>";
        }
        echo "</div>";
    } else {
        echo "<p>Geen spelers gevonden.</p>";
    }

    // Sluit de databaseverbinding
    $db = null;

    // Voeg een link toe om terug te gaan naar het dashboard
    echo '<a class="back-to-dashboard" href="user_dashboard.php">Terug naar Dashboard</a>';
}

?>
</body>
</html>
