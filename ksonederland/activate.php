<?php
// Start the session
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['gebruiker_id'])) {
    echo "U bent niet ingelogd.";
    exit;
}

// Database connection
require_once 'connectie.php'; 

// Get the user ID from the session
$userId = $_SESSION['gebruiker_id'];

// Check if the logged-in user is an admin (assuming there's a column `is_admin`)
$stmt = $pdo->prepare('SELECT IsAdmin FROM gebruiker WHERE gebruiker_id = :userid');
$stmt->execute(['userid' => $userId]);
$user = $stmt->fetch();

if (!$user || $user['IsAdmin'] != 1) {
    echo "U bent geen admin.";
    exit;
}

try {
    // Fetch all users
    $stmt = $pdo->prepare('SELECT gebruiker_id, Bedrijfsnaam, Voornaam, activated, extra_vragen FROM gebruiker');
    $stmt->execute();
    $users = $stmt->fetchAll();

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
    <title>Admin Panel</title>
    <link rel="stylesheet" href="vragen.css">
</head>
<body>
    <div class="admin-box">
        <h2>Welkom Admin!</h2>
        <form action="update_users.php" method="post">
    <table>
        <thead>
            <tr>
                <th>Gebruiker ID</th>
                <th>Bedrijfsnaam</th>
                <th>Activated</th>
                <th>Extra Vragen</th>
                <th>Reset</th>
                <th>Actie</th>

            </tr>
        </thead>
        <tbody>
            <?php foreach ($users as $user) { ?>
            <tr>
                <td><?php echo htmlspecialchars($user['gebruiker_id'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td><?php echo htmlspecialchars($user['Bedrijfsnaam'], ENT_QUOTES, 'UTF-8'); ?></td>
                <td>
                    <select name="activated[<?php echo $user['gebruiker_id']; ?>]">
                        <option value="1" <?php echo $user['activated'] == 1 ? 'selected' : ''; ?>>Activate</option>
                        <option value="0" <?php echo $user['activated'] == 0 ? 'selected' : ''; ?>>Deactivate</option>
                    </select>
                </td>
                <td>
                    <input type="checkbox" name="extra_vragen[<?php echo $user['gebruiker_id']; ?>]" <?php echo $user['extra_vragen'] == 1 ? 'checked' : ''; ?>>
                </td>
                <td>
                <input type="checkbox" name="reset_activation_date[<?php echo $user['gebruiker_id']; ?>]"> Reset Activeringsdatum

                </td>
                <td>
                    <input type="submit" value="Anpassen">
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</form>
        <p><a href="welcome_admin.php">Terug</a></p>
    </div>
</body>
</html>
