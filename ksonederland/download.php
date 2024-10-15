<?php
// Start session to access session variables
session_start();

// Include the database connection file
require_once("connectie.php");

// Check if user is logged in
if (!isset($_SESSION['gebruiker_id'])) {
    die("Unauthorized access");
}

// Get user ID from POST data or session
$user_id = isset($_POST['user_id']) ? $_POST['user_id'] : $_SESSION['gebruiker_id'];

// SQL query to retrieve Bedrijfsnaam
$sql_bedrijfsnaam = "SELECT Bedrijfsnaam FROM gebruiker WHERE Gebruiker_id = :gebruiker_id";
$stmt_bedrijfsnaam = $pdo->prepare($sql_bedrijfsnaam);
$stmt_bedrijfsnaam->bindParam(':gebruiker_id', $user_id);
$stmt_bedrijfsnaam->execute();

if ($stmt_bedrijfsnaam->rowCount() > 0) {
    $row_bedrijfsnaam = $stmt_bedrijfsnaam->fetch(PDO::FETCH_ASSOC);
    $bedrijfsnaam = $row_bedrijfsnaam['Bedrijfsnaam'];
} else {
    die("Bedrijfsnaam not found for user ID: $user_id");
}

// SQL query to retrieve data
$sql = "SELECT gebruiker.Bedrijfsnaam AS Bedrijfsnaam, 
               vragen.vraag AS Vraag,
               mogelijkeantworden.Mogelijke_Antworden_tekst AS Antwoord,
               SUM(mogelijkeantworden.Mogelijke_Antworden_procent) AS TotalPercentage
        FROM antworden
        JOIN gebruiker ON antworden.Gebruiker_id = gebruiker.Gebruiker_id
        JOIN vragen ON antworden.Vraag_id = vragen.Vraag_id
        JOIN mogelijkeantworden ON antworden.Mogelijke_Antworden_id = mogelijkeantworden.Mogelijke_Antworden_id
        WHERE gebruiker.Gebruiker_id = :gebruiker_id
        GROUP BY gebruiker.Bedrijfsnaam, vragen.vraag";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':gebruiker_id', $user_id);

$stmt->execute();

// Check for SQL errors
if ($stmt->errorCode() !== '00000') {
    $errors = $stmt->errorInfo();
    die("SQL error: " . $errors[2]);
}

// Output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="' . $bedrijfsnaam . '.csv"');

// Create a file pointer connected to the output stream
$fp = fopen('php://output', 'w');

// Output column headers (optional)
fputcsv($fp, ['Bedrijfsnaam', 'Vraag', 'Antwoord', 'Percentage']);

// Fetch data and output each row as a CSV line
while ($row_data = $stmt->fetch(PDO::FETCH_ASSOC)) {
    fputcsv($fp, [
        $row_data['Bedrijfsnaam'],
        $row_data['Vraag'],
        $row_data['Antwoord'],
        $row_data['TotalPercentage'].'%'
    ]);
}

// Close the file pointer
fclose($fp);
exit;
?>
