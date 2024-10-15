<?php
// Start session to access session variables
session_start();

// Include the database connection file
require_once("connectie.php");

// Enable error reporting for debugging
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Check if user is logged in
if (!isset($_SESSION['gebruiker_id'])) {
    die("Unauthorized access");
}

// Get user ID from session
$gebruiker_id = $_SESSION['gebruiker_id'];

// Initialize arrays to store category names and percentage data
$categoryNames = [];
$percentages = [];

// SQL query to retrieve category names and adjusted percentages for the selected user
$sql = "SELECT pijlers.naam AS PijlerName, 
               pijlers_categories.naam AS CategoryName, 
               SUM(mogelijkeantworden.Mogelijke_Antworden_procent) / COUNT(vragen.vraag_id) AS AdjustedPercentage
        FROM antworden
        JOIN vragen ON antworden.Vraag_id = vragen.Vraag_id
        JOIN mogelijkeantworden ON antworden.Mogelijke_Antworden_id = mogelijkeantworden.Mogelijke_Antworden_id
        JOIN vraag_sbi_code_id ON vragen.vraag_id = vraag_sbi_code_id.vraag_id
        JOIN pijlers_categories ON vraag_sbi_code_id.pijlers_categorie_id = pijlers_categories.pijlers_categorie_id
        JOIN pijlers ON pijlers_categories.pijlers_id = pijlers.pijlers_id
        WHERE antworden.Gebruiker_id = :gebruiker_id
        GROUP BY pijlers.pijlers_id, pijlers_categories.naam";

$stmt = $pdo->prepare($sql);
$stmt->bindParam(':gebruiker_id', $gebruiker_id);
$stmt->execute();

// Fetch the data and store it in arrays
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $categoryNames[] = $row["CategoryName"];
    $percentages[] = $row["AdjustedPercentage"];
}

// Close the database connection
$pdo = null;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antwoorden</title>
    <link rel="stylesheet" href="grafiek.css">
    <script src="https://cdn.plot.ly/plotly-latest.min.js"></script>
</head>
<body>

<div class="container">
    <h2>Antwoorden</h2>

    <!-- Plotly bar chart -->
    <div id="myPlot" style="width:100%;max-width:80%;"></div>
    <script>
        // Data from PHP
        const xArray = <?php echo json_encode($categoryNames); ?>;
        const yArray = <?php echo json_encode($percentages); ?>;

        console.log("xArray:", xArray);
        console.log("yArray:", yArray);

        const layout = {title: "Resultaten van de Gebruiker"};

        const data = [{x: xArray, y: yArray, type: "bar"}];

        Plotly.newPlot("myPlot", data, layout);
    </script>

    <!-- Logout link -->
    <p><a href="logout.php">Logout</a></p>
</div>

</body>
</html>
