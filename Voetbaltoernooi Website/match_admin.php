<?php
// Vereist het bestand voor databaseverbinding
require_once('database_connection.php');

// Controleren of match_id is opgegeven in de URL
if (isset($_GET['match_id'])) {
    $match_id = $_GET['match_id'];

    // Query om details van de geselecteerde wedstrijd op te halen
    $stmt = $db->prepare("SELECT * FROM matches WHERE match_id = :match_id");
    $stmt->bindParam(':match_id', $match_id);
    $stmt->execute();

    $selectedMatch = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$selectedMatch) {
        echo "Wedstrijd niet gevonden.";
        // Je kunt ook overwegen de gebruiker door te verwijzen of een foutmelding weer te geven.
    }
} else {
    echo "Match ID niet opgegeven in de URL.";
    // Je kunt ook overwegen de gebruiker door te verwijzen of een foutmelding weer te geven.
}

// Verwerken van het formulier
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Aannemen dat je een process_results.php bestand hebt voor het verwerken van het formulier
    // Pas deze logica aan op basis van de structuur van jouw applicatie
    $team1_results = isset($_POST['team1_results']) ? $_POST['team1_results'] : null;
    $team2_results = isset($_POST['team2_results']) ? $_POST['team2_results'] : null;

    // Verwerken en bijwerken van de database met de resultaten
    // Voeg hier je database-update logica toe met $match_id, $team1_results en $team2_results
    // Doorverwijzen of een succesbericht weergeven na verwerking
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Wedstrijd Details</title>
</head>
<body>

    <h3>Wedstrijd Details</h3>

    <?php if (isset($selectedMatch)): ?>
        <p>Match ID: <?= $selectedMatch['match_id']; ?></p>
        <form method="post" action="">
            <input type="hidden" name="match_id" value="<?= $selectedMatch['match_id']; ?>">
            <br>
            <label for="team1_results">Team 1 Uitslagen:</label>
            <input type="number" id="team1_results" name="team1_results" required min="0">
            <br>
            <label for="team2_results">Team 2 Uitslagen:</label>
            <input type="number" id="team2_results" name="team2_results" required min="0">
            <br>
            <input type="submit" value="Uitslagen Invoeren">
        </form>
        <p><a href="teams_admin_uitslag.php">Terug naar Matches</a></p>
    <?php endif; ?>

</body>
</html>
