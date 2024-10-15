<?php
// Start the session
session_start();

// Include the database connection file
require_once 'connectie.php';

// Function to verify password
function controleerWachtwoord($ingevoerdWachtwoord, $opgeslagenWachtwoord) {
    return password_verify($ingevoerdWachtwoord, $opgeslagenWachtwoord);
}

// If the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get user input from the form
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];

    // Search for the user in the database based on the email address
    $stmt = $pdo->prepare("SELECT * FROM gebruiker WHERE Emailadres = :email");
    $stmt->execute(['email' => $email]);
    $gebruiker = $stmt->fetch();

    // Check if the user is found and if the password matches
    if ($gebruiker && controleerWachtwoord($wachtwoord, $gebruiker['Wachtwoord'])) {
        // Check if the user is an admin
        if ($gebruiker['IsAdmin'] == 1) {
            // Set session variables for admin
            $_SESSION['gebruiker_id'] = $gebruiker['Gebruiker_id'];
            header('Location: welcome_Admin.php');
            exit;
        } else {
            // For regular users, check activation status
            if ($gebruiker['activated'] == 1) {
                // Check activation date against current date
                if ($gebruiker['activation_date'] !== null) {
                    $activationDate = new DateTime($gebruiker['activation_date']);
                    $currentDate = new DateTime();
                    $difference = $currentDate->diff($activationDate);
                    
                    // Check if activation is over a year ago
                    if ($difference->y >= 1) {
                        echo '<p>Uw account is verlopen. Neem contact op met info@keurmerksociaalondernemen.nl.</p>';
                    } else {
                        // Proceed with login for accounts within activation period
                        $_SESSION['gebruiker_id'] = $gebruiker['Gebruiker_id'];
                        header('Location: welcome.php');
                        exit;
                    }
                } else {
                    echo '<p>Geen activeringsdatum gevonden voor uw account.</p>';
                }
            } else {
                echo '<p>Uw account is niet geactiveerd. Neem contact op met info@keurmerksociaalondernemen.nl</p>';
            }
        }
    } else {
        echo '<p>Onjuist e-mailadres of wachtwoord!</p>';
    }
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inloggen</title>
    <link rel="stylesheet" href="style_home.css">
</head>
<body>
    <div class="login-box">
        <!-- Add the logo here -->
        <img src="Logo-KSO 2021.png" alt="Logo" class="logo">
        
        <h2>Inloggen</h2>
        <form method="post">
            <div class="user-box">    
                <label for="email">E-mailadres</label>
                <input type="email" id="email" name="email" required>
            
            </div>
            <div class="user-box">    
                <label for="wachtwoord">Wachtwoord</label>
                <input type="password" id="wachtwoord" name="wachtwoord" required>
            
            </div>
           
           <a> <input type="submit" value="Inloggen"></a>
        
            <a href="register.php" class="register-link">Geen Account?</a>
            <a href="forgot_password.php" class="forgot_password">wachtwoord Vergeten?</a>

        </form>
    </div>
</body>
</html>
