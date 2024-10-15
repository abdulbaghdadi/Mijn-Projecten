<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $admindata = [
        'email' => $_POST['email'],
        'password' => $_POST['password']
    ];

    // Create a hash from the user's password
    $password_hash = password_hash($admindata['password'], PASSWORD_BCRYPT);

    // Set up the database connection
    require_once 'connectie.php';

    // Prepare and execute the SQL query to insert the the admin user into the database
    $stmt = $pdo->prepare("INSERT INTO `gebruiker` (`Emailadres`, `Wachtwoord`, `IsAdmin`, `categorie`) VALUES (?, ?, ?, NULL)");
    $stmt->execute([
        $admindata['email'],
        $password_hash,
        true // or any other value used to identify an admin user in the `IsAdmin` column
    ]);
    

    echo "Admin user has been created.";

    // Close the database connection
    $pdo = null;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Admin User</title>
</head>
<body>
    <h1>Create Admin User</h1>
    <form action="create_admin_user.php" method="post">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <button type="submit">Create Admin User</button>
    </form>
</body>
        <p><a href="admin_dashboard.php">Terug</a></p>

</html>