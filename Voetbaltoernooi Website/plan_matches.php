<?php
// Vereisen van het bestand met databaseverbinding
require_once('database_connection.php');

// Controleren of het formulier is ingediend via de POST-methode
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Verwerken van het formulier en wedstrijddetails invoegen in de database
    $team1Id = $_POST['team1'];
    $team2Id = $_POST['team2'];
    $matchDate = $_POST['match_date'];

    // Voorbereiden en uitvoeren van de SQL-query om de wedstrijd in de database in te voegen
    $stmt = $db->prepare("INSERT INTO matches (team1_id, team2_id, match_date) VALUES (:team1_id, :team2_id, :match_date)");
    $stmt->bindParam(':team1_id', $team1Id);
    $stmt->bindParam(':team2_id', $team2Id);
    $stmt->bindParam(':match_date', $matchDate);

    try {
        $stmt->execute();
        // Redirect to another page after successful submission
        header("Location: admin_.php");
        exit(); // Ensure that no other code is executed after the header
    } catch (PDOException $e) {
        echo "Fout: " . $e->getMessage();
    }
}

// Teams ophalen uit de database
$stmtTeams = $db->query("SELECT * FROM teams");
$teams = $stmtTeams->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Wedstrijden Plannen</title>
</head>
<body>
    <h2>Wedstrijden Plannen</h2>

    <form method="post" action="">
        <label for="team1">Team 1:</label>
        <select id="team1" name="team1" required>
            <?php foreach ($teams as $team): ?>
                <!-- Opties voor selectie met team-ID's en namen uit de database -->
                <option value="<?php echo $team['team_id']; ?>"><?php echo $team['team_name']; ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <br>

        <label for="team2">Team 2:</label>
        <select id="team2" name="team2" required>
            <?php foreach ($teams as $team): ?>
                <!-- Opties voor selectie met team-ID's en namen uit de database -->
                <option value="<?php echo $team['team_id']; ?>"><?php echo $team['team_name']; ?></option>
            <?php endforeach; ?>
        </select>
        <br>
        <br>

        <label for="match_date">Wedstrijddatum:</label>
        <input type="datetime-local" id="match_date" name="match_date" required>
        <br>
        <br>

        <input type="submit" value="Wedstrijd Plannen">
    </form>

    <p><a href="admin_.php">Terug naar Dashboard</a></p>
    <footer>
        <p>&copy; <?= date("Y"); ?> Voetbaltoernooi</p>
    </footer>
</body>
</html>
