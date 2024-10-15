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
    // Prepare a SQL statement to fetch the user's first name, activation status, and form submission status
    $stmt = $pdo->prepare('SELECT Voornaam, activated, form_submitted FROM gebruiker WHERE gebruiker_id = :userid');
    $stmt->execute(['userid' => $userId]);
    $user = $stmt->fetch();

    // Check if the user exists
    if ($user) {
        // Check if the user is activated
        if ($user['activated'] != 1) {
            echo "Uw account is niet geactiveerd. Neem contact op met de beheerder.";
            exit;
        }

        // Set the $Voornaam variable to the user's first name
        $Voornaam = htmlspecialchars($user['Voornaam'], ENT_QUOTES, 'UTF-8');

        // Set the form submission status
        $formSubmitted = $user['form_submitted'] == 1;
    } else {
        echo "Gebruiker niet gevonden.";
        exit;
    }
} catch (PDOException $e) {
    echo 'Error: ' . htmlspecialchars($e->getMessage(), ENT_QUOTES, 'UTF-8');
    exit;
}
?>
<!DOCTYPE html>
<html lang="nl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="welcome_style.css">
    <title>Welcome</title>

    <script>
        function handleSubmit(formSubmitted) {
            if (formSubmitted) {
                alert('U heeft dit formulier al ingediend. U wordt nu doorgestuurd naar de grafiek.');
                window.location.href = 'grafiek.php';
                return false; // Prevent form submission
            }
            return true; // Allow form submission
        }
    </script>
</head>
<body>
    <div class="welcome-box">
        <h2>Welkom, <?php echo $Voornaam; ?>!</h2>
        <form action="dashboard.php" method="post" onsubmit="return handleSubmit(<?php echo $formSubmitted ? 'true' : 'false'; ?>);">
            <input type="submit" value="Starten">
        </form>
    </div>
</body>
</html>
