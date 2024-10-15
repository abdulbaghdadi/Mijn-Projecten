<?php
session_start();
require_once('database_connection.php');


// Controleer of de beheerder niet is ingelogd of niet de rol 'admin' heeft
if (!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true || $_SESSION["role"] !== 'admin') {
    // Redirect naar de inlogpagina als de voorwaarden niet zijn voldaan
    header("Location: login.php");
    exit();
}
$teams = $db->query("SELECT * FROM teams")->fetchAll(PDO::FETCH_ASSOC);
$matches = $db->query("SELECT matches.match_id, teams1.team_name as team1_name, teams2.team_name as team2_name, matches.match_date, matches.team1_results, matches.team2_results FROM matches
                     JOIN teams as teams1 ON matches.team1_id = teams1.team_id
                     JOIN teams as teams2 ON matches.team2_id = teams2.team_id")->fetchAll(PDO::FETCH_ASSOC);
?>

?>

<!DOCTYPE html>
<html lang="nl"> 
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Beheerdersdashboard</title> 
</head>
<body>
    <h2>Welkom, Admin!</h2>
    
    <ul>
        <li><a href="view_teams.php">Teams bekijken</a></li>
        <li><a href="plan_matches.php">Wedstrijden plannen</a></li>
        <li><a href="teams_admin_uitslag.php">Uitslagen invoeren</a></li>
    </ul>

    <main>
        <h2>Jouw Dashboard</h2>

        <!-- Teams weergeven -->




<h3>Wedstrijdplanning en uitslagen zien</h3>
<?php if (!empty($matches)): ?>
    <table border="1">
        <tr>
            <th>Team 1</th>
            <th>Team 2</th>
            <th>Wedstrijddatum</th>
            <th>Team 1 Resultaten</th>
            <th>Team 2 Resultaten</th>
        </tr>
        <?php foreach ($matches as $match): ?>
    <tr>
        <td><?= $match['team1_name']; ?></td>
        <td><?= $match['team2_name']; ?></td>
        <td>
            <?php
                $matchDate = new DateTime($match['match_date']);

                echo $matchDate->format('d/m/Y H:i:s');
            ?>
        </td>
        <td><?= ($match['team1_results'] == 0) ? '-' : $match['team1_results']; ?></td>
        <td><?= ($match['team2_results'] == 0) ? '-' : $match['team2_results']; ?></td>
    </tr>
<?php endforeach; ?>
    </table>
<?php else: ?>
    <p>Geen wedstrijden gevonden.</p>
    <hr> 
    <?php endif; ?>
    </main>
    
    <p><a href="logout.php">Uitloggen</a></p> 
    
    <footer>
        <p>&copy; <?= date("Y"); ?> Voetbaltoernooi</p>
        <!-- Dynamisch jaartal ingevoegd met behulp van PHP -->
    </footer>
</body>
</html>
