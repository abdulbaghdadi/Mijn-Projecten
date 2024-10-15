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
$gebruiker_id = isset($_POST['user_id']) ? $_POST['user_id'] : $_SESSION['gebruiker_id'];

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Antwoorden</title>
    <link rel="stylesheet" href="rapport.css">
</head>
<body>

<div class="container">
    <h2>Antwoorden</h2>

    <!-- Form to download Excel -->
    <form action="download.php" method="post">
        <input type="hidden" name="user_id" value="<?php echo htmlspecialchars($gebruiker_id); ?>">
        <input type="submit" name="download_excel" value="Download Excel">
    </form>

    <!-- Dropdown to select users -->
    <form action="<?php echo $_SERVER['PHP_SELF']; ?>" method="post" style="margin-bottom: 20px;">
        <label for="user_id">Kies Gebruiker:</label>
        <select name="user_id" id="user_id">
            <?php
            // Fetch and display users from database
            $sql_users = "SELECT Gebruiker_id, Bedrijfsnaam FROM gebruiker";
            $stmt_users = $pdo->query($sql_users);
            while ($row_user = $stmt_users->fetch(PDO::FETCH_ASSOC)) {
                $selected = ($gebruiker_id == $row_user['Gebruiker_id']) ? 'selected' : '';
                echo "<option value='" . $row_user['Gebruiker_id'] . "' $selected>" . htmlspecialchars($row_user['Bedrijfsnaam']) . "</option>";
            }
            ?>
        </select>
        <input type="submit" value="Selecteer">
    </form>

    <!-- Table to display questions and answers -->
    <table>
        <thead>
            <tr>
                <th>Vraag</th>
                <th>Antwoord</th>
                <th>Percentage</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // SQL query to retrieve questions, answers, and percentages for the selected user
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
        $stmt->bindParam(':gebruiker_id', $gebruiker_id);
        $stmt->execute();

        // Initialize total percentage and question count
        $totalPercentage = 0;
        $questionCount = 0;

        // Check if there are any results
        if ($stmt->rowCount() > 0) {
            // Loop through each row and display the data
            while($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr>
                        <td>" . htmlspecialchars($row["Vraag"]) . "</td>
                        <td>" . htmlspecialchars($row["Antwoord"]) . "</td>
                        <td>" . htmlspecialchars($row["TotalPercentage"]) . "%</td>
                      </tr>";
                // Add percentage to total
                $totalPercentage += intval($row["TotalPercentage"]);
                // Increment question count
                $questionCount++;
            }
        } else {
            // If no results found, display a message
            echo "<tr><td colspan='3'>Geen resultaten gevonden</td></tr>";
        }
        ?>
        </tbody>
    </table>

    <!-- Display total percentage and average percentage per question -->
    <?php
    if ($stmt->rowCount() > 0) {
        echo "<p>Totaal : " . $totalPercentage . "%</p>";
        if ($questionCount > 0) {
            $averagePercentage = $totalPercentage / $questionCount;
            echo "<p>Eind Resultaat: " . round($averagePercentage, 2) . "%</p>";
        }
    }
    ?>
    <p><a href="welcome_admin.php">terug</a></p>

    <!-- Logout link -->
    <p><a href="logout.php">Logout</a></p>

</div>

</body>
</html>

<?php
// Close the database connection
$pdo = null;
?>
