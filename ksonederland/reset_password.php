<?php
session_start();
require_once 'connectie.php';

// Validate token from URL
if (!isset($_GET['token'])) {
    // Handle invalid token
    die('Ongeldige reset link.');
}

$token = $_GET['token'];

// Check if token is valid and not expired
$stmt = $pdo->prepare("SELECT * FROM gebruiker WHERE reset_token = :token AND reset_token_expiry >= NOW()");
$stmt->execute(['token' => $token]);
$gebruiker = $stmt->fetch();

if (!$gebruiker) {
    // Handle expired or invalid token
    die('Ongeldige reset link of link is verlopen.');
}

// Process password reset form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $newPassword = $_POST['new_password'];

    // Hash and update password in database
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $stmt = $pdo->prepare("UPDATE gebruiker SET Wachtwoord = :password, reset_token = NULL, reset_token_expiry = NULL WHERE Gebruiker_id = :id");
    $stmt->execute(['password' => $hashedPassword, 'id' => $gebruiker['Gebruiker_id']]);

    // Redirect to login page or confirmation page
    header('Location: password_reset_success.php');
    exit;
}
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Wachtwoord Resetten</title>
    <link rel="stylesheet" href="style_home.css">
</head>
<body>
    <div class="login-box">
        <img src="Logo-KSO 2021.png" alt="Logo" class="logo">
        
        <h2>Wachtwoord Resetten</h2>
        <form method="post">
            <div class="user-box">    
                <label for="new_password">Nieuw Wachtwoord</label>
                <input type="password" id="new_password" name="new_password" required>
            </div>
           
            <button type="submit">Wachtwoord Resetten</button>
        
            <a href="index.php" class="register-link">Terug naar Inloggen</a>
        </form>
    </div>
</body>
</html>
