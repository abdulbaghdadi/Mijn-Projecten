<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Log in</title>
</head>

<body>
    <h2>Log in</h2>
    <form method="post" action="login_process.php">
    Gebruikersnaam: <input type="text" name="username"><br>
    Wachtwoord: <input type="password" name="password_hash"><br>
        <input type="submit" value="Log in">
    </form>

    <a href="register.php">Registreer hier</a>
    <footer>
        <p>&copy; <?= date("Y"); ?> Voetbaltoernooi</p>
    </footer>
</body>
</html>
