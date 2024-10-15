<?php
require_once('database_connection.php');

// Teams ophalen uit de database
$stmt = $db->query("SELECT * FROM teams");

$teams = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
<?php if (!empty($teams)): ?>
    <table border="1">
        <tr>
            <th>Teamnaam</th>
        </tr>
        <?php foreach ($teams as $team): ?>
            <tr>
                <td>
                    <a href="players_admin.php?team_id=<?= $team['team_id']; ?>">
                        <?= $team['team_name']; ?>
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
