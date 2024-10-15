<?php
// Start the session
session_start();
// Check if the user is logged in
if (!isset($_SESSION['gebruiker_id'])) {
    echo "U bent niet ingelogd.";
    exit;
}

require_once 'connectie.php'; // Include your database connection file

// Get the user ID from the session
$userId = $_SESSION['gebruiker_id'];

try {
    // Prepare a SQL statement to fetch the user's first name
    $stmt = $pdo->prepare('SELECT Voornaam FROM gebruiker WHERE gebruiker_id = :username');
    $stmt->execute(['username' => $userId]);
    $user = $stmt->fetch();

    // Check if the user exists
    if ($user) {
        // Set the $Voornaam variable to the user's first name
        $Voornaam = htmlspecialchars($user['Voornaam'], ENT_QUOTES, 'UTF-8');
    } else {
        // Set the $Voornaam variable to an empty string or a default value
        $Voornaam = '';
    }



} catch (PDOException $e) {
    echo 'Error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="welcome_admin.css">
    <title>Welcome</title>
    
</head>
<body>
    <div class="welcome-box">
        <h2>Welkom admin !</h2>
        <form action="vragen.php" method="post">
            <input type="submit" value="Vragen beheeren">
        </form>
        <form action="rapport.php" method="post">
            <input type="submit" value="Rapporten bekijken">
        </form>
        <form action="activate.php" method="post">
            <input type="submit" value="Activate accounts">
        </form>
        <form action="admin_reset_form.php" method="post">
            <input type="submit" value="Reset vragen">
        </form>
        <p><a href="logout.php" >Logout</a></p>
        

    </div>
</body>
</html>