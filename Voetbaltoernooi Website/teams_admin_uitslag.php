<?php
require_once('database_connection.php');

// Teams ophalen uit de database, inclusief alle relevante informatie
$stmt = $db->query("SELECT m.match_id, t1.team_name AS team1_name, t2.team_name AS team2_name, m.match_date, m.team1_results, m.team2_results
                    FROM matches m
                    INNER JOIN teams t1 ON m.team1_id = t1.team_id
                    INNER JOIN teams t2 ON m.team2_id = t2.team_id");

$matches = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Teams Bekijken</title>
</head>
<body>
    <h3>Teams bekijken</h3>
    
    <?php if (!empty($matches)): ?>
        <table border="1">
            <tr>
                <th>Team 1</th>
                <th>Team 2</th>
                <th>Wedstrijddatum</th>
                <th>Team 1 Resultaten</th>
                <th>Team 2 Resultaten</th>
                <th></th> 
            </tr>
            <?php foreach ($matches as $match): ?>
                <tr>
                    <td style="color: white;"><?= $match['team1_name']; ?></td>
                    <td style="color: white;"><?= $match['team2_name']; ?></td>
                    <td style="color: white;"><?= $match['match_date']; ?></td>
                    <td style="color: white;"><?= $match['team1_results']; ?></td>
                    <td style="color: white;"><?= $match['team2_results']; ?></td>
                    <td>
                        <a href="enter_results.php?match_id=<?= $match['match_id']; ?>">
                            Enter Results
                        </a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    <?php else: ?>
        <p>Geen teams gevonden.</p>
    <?php endif; ?>

    <p><a href="admin_.php">Terug naar Dashboard</a></p>
</body>
</html>
