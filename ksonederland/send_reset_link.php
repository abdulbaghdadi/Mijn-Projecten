<?php
session_start();
require_once 'connectie.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];

    // Generate a unique token
    $token = bin2hex(random_bytes(32));

    // Set token expiry (e.g., 1 hour from now)
    $tokenExpiry = date('Y-m-d H:i:s', strtotime('+1 hour'));

    // Update database with token and expiry
    $stmt = $pdo->prepare("UPDATE gebruiker SET reset_token = :token, reset_token_expiry = :expiry WHERE Emailadres = :email");
    $stmt->execute(['token' => $token, 'expiry' => $tokenExpiry, 'email' => $email]);

    // Send email with reset link
    $resetLink = "http://monitor.globalgoalsmonitor.nl/reset_password.php?token=" . $token;
    $to = $email;
    $subject = 'Wachtwoord Reset Link';
    $message = "Klik op deze link om uw wachtwoord te resetten: $resetLink";
    $headers = "From: info@keurmerksociaalondernemen.nl\r\n";
    $headers .= "Content-Type: text/html; charset=UTF-8\r\n";

    mail($to, $subject, $message, $headers);

    // Redirect to a confirmation page
    header('Location: password_reset_sent.php');
    exit;
}
?>
