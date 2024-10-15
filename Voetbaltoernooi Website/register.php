<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Spelerregistratie</title>
</head>
<body>
    <h2>Spelerregistratie</h2>
    <form action="register_process.php" method="post">
        <label for="username">Gebruikersnaam:</label>
        <input type="text" id="username" name="username" required>

        <label for="password">Wachtwoord:</label>
        <input type="password" id="password" name="password" required>

        <label for="team_name">Teamnaam:</label>
        <input type="text" id="team_name" name="team_name" required>

        <label for="player1">Speler 1:</label>
        <input type="text" id="player1" name="players[]" required>

        <label for="player2">Speler 2:</label>
        <input type="text" id="player2" name="players[]" required>

        <label for="player3">Speler 3:</label>
        <input type="text" id="player3" name="players[]" required>

        <label for="player4">Speler 4:</label>
        <input type="text" id="player4" name="players[]" required>

        <label for="player5">Speler 5:</label>
        <input type="text" id="player5" name="players[]" required>

        <input type="submit" value="Registreren">
    </form>
</body>
</html>
