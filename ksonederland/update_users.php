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

// Check if the logged-in user is an admin
$stmt = $pdo->prepare('SELECT IsAdmin FROM gebruiker WHERE gebruiker_id = :userid');
$stmt->execute(['userid' => $userId]);
$user = $stmt->fetch();

if (!$user || $user['IsAdmin'] != 1) {
    echo "U bent geen admin.";
    exit;
}

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Loop through the activated statuses
    foreach ($_POST['activated'] as $gebruiker_id => $activated) {
        // Check if the extra_vragen checkbox is set for this user
        $extra_vragen = isset($_POST['extra_vragen'][$gebruiker_id]) ? 1 : 0;

        // Determine the activation date
        $activation_date = null; // Default to null if not activated
        if ($activated == 1) {
            // Check if reset activation date checkbox is checked
            if (isset($_POST['reset_activation_date'][$gebruiker_id])) {
                $activation_date = date('Y-m-d H:i:s'); // Set to current date
            } else {
                // Keep existing activation date if not resetting
                $stmt = $pdo->prepare('SELECT activation_date FROM gebruiker WHERE gebruiker_id = :gebruiker_id');
                $stmt->execute(['gebruiker_id' => $gebruiker_id]);
                $existing_activation_date = $stmt->fetchColumn();

                if ($existing_activation_date) {
                    $activation_date = $existing_activation_date; // Keep existing activation date
                } else {
                    $activation_date = date('Y-m-d H:i:s'); // Set to current date as fallback
                }
            }
        }

        // Update the user status and activation date
        $stmt = $pdo->prepare('UPDATE gebruiker SET activated = :activated, extra_vragen = :extra_vragen, activation_date = :activation_date WHERE gebruiker_id = :gebruiker_id');
        $stmt->execute([
            'activated' => $activated,
            'extra_vragen' => $extra_vragen,
            'activation_date' => $activation_date,
            'gebruiker_id' => $gebruiker_id
        ]);
    }
    echo "Gebruikersstatussen bijgewerkt.";
    header("Location: welcome_admin.php");
    exit;
}
?>
