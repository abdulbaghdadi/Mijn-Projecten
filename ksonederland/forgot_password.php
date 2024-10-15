<!-- forgot_password.php -->
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wachtwoord Vergeten</title>
    <link rel="stylesheet" href="style_home.css">
</head>
<body>
    <div class="login-box">
        <img src="Logo-KSO 2021.png" alt="Logo" class="logo">
        
        <h2>Wachtwoord Vergeten</h2>
        <form method="post" action="send_reset_link.php">
            <div class="user-box">    
                <label for="email">E-mailadres</label>
                <input type="email" id="email" name="email" required>
            </div>
           
            <button type="submit">Reset Link Versturen</button>
        
            <a href="index.php" class="register-link">Terug naar Inloggen</a>
        </form>
    </div>
</body>
</html>
