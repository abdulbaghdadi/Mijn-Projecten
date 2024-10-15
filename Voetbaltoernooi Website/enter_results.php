<?php
require_once('database_connection.php');

// Define $matchId and set it to 0 initially
$matchId = 0;

// Check if match_id is present in the URL parameters
if (isset($_GET['match_id'])) {
    $matchId = $_GET['match_id'];
}

// Controleren of het formulier is ingediend
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verwerken van het formulier en wedstrijdresultaten bijwerken in de database
    $matchId = $_POST['match_id'];
    $team1Results = $_POST['team1_results'];
    $team2Results = $_POST['team2_results'];

    // Voorbereiden en uitvoeren van de SQL-query om wedstrijdresultaten bij te werken
    $stmt = $db->prepare("UPDATE matches SET team1_results = :team1_results, team2_results = :team2_results WHERE match_id = :match_id");
    $stmt->bindParam(':team1_results', $team1Results);
    $stmt->bindParam(':team2_results', $team2Results);
    $stmt->bindParam(':match_id', $matchId);

    try {
        $stmt->execute();
        // Redirect to another page after successful submission
        header("Location: teams_admin_uitslag.php");
        exit(); // Ensure that no other code is executed after the header
    } catch (PDOException $e) {
        echo "Fout: " . $e->getMessage();
    }
}

// Wedstrijden ophalen uit de database
$stmtMatches = $db->query("SELECT * FROM matches");
$matches = $stmtMatches->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Uitslagen Invoeren</title>
</head>
<body>
    <h2>Uitslagen Invoeren</h2>

    <form method="post" action="">
        <label for="team1_results">Team 1 Uitslagen:</label>
        <input type="number" id="team1_results" name="team1_results" required min="0">
        <br>
        <br>
        <label for="team2_results">Team 2 Uitslagen:</label>
        <input type="number" id="team2_results" name="team2_results" required min="0">
        <br>
        <br>
        <!-- Use PHP to set the value of the hidden input -->
        <input type="hidden" name="match_id" value="<?= $matchId; ?>">
        <input type="submit" value="Uitslagen Invoeren">
    </form>

    <p><a href="admin_.php">Terug naar Dashboard</a></p>
    <footer>
        <p>&copy; <?= date("Y"); ?> Voetbaltoernooi</p>
    </footer>
</body>
</html>
