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
    <title>Welcome</title>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: sans-serif;
            background: linear-gradient(#141e30, #243b55);
            height: 100vh; /* Ensure full height */
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .welcome-box {
            width: 400px;
            padding: 40px;
            background: rgba(0, 0, 0, 0.5);
            box-shadow: 0 15px 25px rgba(0, 0, 0, 0.6);
            border-radius: 10px;
            box-sizing: border-box;
            text-align: center;
        }
        
        .welcome-box h2 {
            margin: 0 0 30px;
            padding: 0;
            color: #fff;
            font-size: 24px;
        }
        
        .welcome-box input[type="submit"] {
            padding: 10px 20px;
            color: #fff;
            font-size: 16px;
            text-decoration: none;
            text-transform: uppercase;
            overflow: hidden;
            transition: 0.5s;
            letter-spacing: 2px;
            background-color: transparent;
            border: 3px solid #03e9f4;
            border-radius: 5px;
            cursor: pointer;
        }
        
        .welcome-box input[type="submit"]:hover {
            background: #03e9f4;
            border-color: #03e9f4;
            box-shadow: 0 0 5px #03e9f4, 0 0 25px #03e9f4, 0 0 50px #03e9f4, 0 0 100px #03e9f4;
        }
    </style>
</head>
<body>
    <div class="welcome-box">
        <h2>Bedankt, <?php echo $Voornaam; ?>!</h2>
        <form action="logout.php" method="post">
            <input type="submit" value="Logout">
        </form>
    </div>
</body>
</html>