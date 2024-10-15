<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Questions and Answers</title>
    <link rel="stylesheet" href="dashboard_Style.css">
</head>
<body>
    
<div class="container">
    <h1>Vragen</h1>
    <div class="progress-bar-container">
        <div class="progress-bar"></div>
    </div>

    <?php
    // Start the session to use session variables
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['gebruiker_id'])) {
        echo "<p>Log in eerst.</p>"; // If not logged in, prompt to log in
        exit; // Exit the script
    }

    // Include the database connection
    require_once 'connectie.php';

    try {
        // Prepare and execute the query to get the sector and extra_vragen of the logged-in user
        $stmt = $pdo->prepare("SELECT sector, extra_vragen FROM gebruiker WHERE gebruiker_id = :gebruiker_id");
        $stmt->bindParam(':gebruiker_id', $_SESSION['gebruiker_id']);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if the sector and extra_vragen were found for the logged-in user
        if ($row) {
            $gebruiker_sector = $row['sector'];
            $extra_vragen = $row['extra_vragen'];

            // Prepare and execute the query to get questions and categories based on the user's sector
            // Include extra questions if the user has the "extra_vragen" flag set to true
            $query = "
                SELECT vraag_sbi_code_id.id, vraag_sbi_code_id.Vraag_id, vragen.Vraag, vraag_sbi_code_id.pijlers_categorie_id, pijlers_categories.naam
                FROM vraag_sbi_code_id
                LEFT JOIN vragen ON vraag_sbi_code_id.Vraag_id = vragen.Vraag_id
                LEFT JOIN pijlers_categories ON vraag_sbi_code_id.pijlers_categorie_id = pijlers_categories.pijlers_categorie_id
                LEFT JOIN sbi_code ON vraag_sbi_code_id.id = sbi_code.id
                LEFT JOIN gebruiker ON sbi_code.code_id = gebruiker.sector
                WHERE gebruiker.sector = :sector OR vraag_sbi_code_id.id IS NULL";

            if ($extra_vragen == 1) {
                $query .= " OR pijlers_categories.pijlers_id = 4";
            } else {
                $query .= " AND pijlers_categories.pijlers_id != 4";
            }

            $query .= " ORDER BY vraag_sbi_code_id.pijlers_categorie_id";

            $stmt_questions = $pdo->prepare($query);
            $stmt_questions->bindParam(':sector', $gebruiker_sector);
            $stmt_questions->execute();

            // Check if there are any questions
            if ($stmt_questions->rowCount() > 0) {
                $current_category = null; // To keep track of the current category
                $firstCategory = true; // Flag for the first category
                $categoryCount = 0; // Counter for the number of categories

                // Start the form
                echo "<form id='questionForm' action='submit.php' method='post' onsubmit='return confirmSubmission()'>";

                // Loop through the questions
                while ($row = $stmt_questions->fetch(PDO::FETCH_ASSOC)) {
                    // If the category changes, create a new category div
                    if ($row['pijlers_categorie_id'] != $current_category) {
                        if (!$firstCategory) {
                            echo "</div>"; // Close previous category div
                        }
                        echo "<div class='category' id='category_" . htmlspecialchars($row['pijlers_categorie_id']) . "' style='display: " . ($firstCategory ? 'block' : 'none') . ";'>";
                        $current_category = $row['pijlers_categorie_id'];
                        echo "<h2>" . htmlspecialchars($row['naam']) . "</h2>";
                        $firstCategory = false; // Set the flag to false after the first category
                        $categoryCount++; // Increment the category count
                    }
                    // Display the question
                    echo "<h3>" . htmlspecialchars($row["Vraag"]) . "</h3>";
                    $vraag_id = $row["Vraag_id"];

                    // Prepare and execute the query to get the possible answers for the question
                    $stmt_opties = $pdo->prepare("SELECT * FROM mogelijkeantworden WHERE vraag_id = :vraag_id");
                    $stmt_opties->bindParam(':vraag_id', $vraag_id);
                    $stmt_opties->execute();

                    // Check if there are any possible answers
                    if ($stmt_opties->rowCount() > 0) {
                        echo "<ul>"; // Start the list of possible answers
                        while ($row_opties = $stmt_opties->fetch(PDO::FETCH_ASSOC)) {
                            // Display each possible answer as a radio button
                            echo "<li><input type='radio' name='antwoord[" . htmlspecialchars($vraag_id) . "]' value='" . htmlspecialchars($row_opties["Mogelijke_Antworden_id"]) . "'>" . htmlspecialchars($row_opties["Mogelijke_Antworden_tekst"]) . "</li>";
                        }
                        echo "</ul>"; // End the list of possible answers
                    }
                }

                // Hidden input to store the count of categories
                echo "<input type='hidden' id='categoryCount' value='$categoryCount'>";
                echo "</form>"; // Close the form
            } else {
                // If no questions are found
                echo "No questions found.";
            }
        } else {
            // Handle case where no sector is found for the user
            echo "Sector not found for this user.";
        }
    } catch (PDOException $e) {
        // Handle database errors
        echo "Error: " . $e->getMessage();
    }
    ?>


    <!-- Button to submit the form -->
    <button class='next' onclick='showNextCategory()'>verzenden</button>
</div>

<!-- Button to show the next category -->
<button class='next' onclick='showNextCategory()'>Next</button>

<!-- Logout link -->
<p><a href="logout.php" style="margin-top: 40px; display: block; text-align: center; text-decoration: none; color: white; letter-spacing: 0px; text-transform: none;">Logout</a></p>

<!-- JavaScript to handle category navigation, form submission confirmation, and progress bar -->
<script>
    var currentCategoryIndex = 1; // Index of the current category being displayed
    var categoryCount = parseInt(document.getElementById('categoryCount').value); // Total number of categories
    var categories = document.querySelectorAll('.category'); // All category elements
    var progressBar = document.querySelector('.progress-bar'); // Progress bar element

    // Function to show the next category
    function showNextCategory() {
        categories[currentCategoryIndex - 1].style.display = 'none'; // Hide the current category
        currentCategoryIndex = (currentCategoryIndex % categoryCount) + 1; // Move to the next category
        categories[currentCategoryIndex - 1].style.display = 'block'; // Show the next category

        // Update progress bar
        var progress = (currentCategoryIndex / categoryCount) * 100;
        progressBar.style.width = progress + '%';
    }

    // Function to confirm form submission
    function confirmSubmission() {
        var confirmed = confirm("Weet je zeker?"); // Display a confirmation dialog
        return confirmed; // Return the result of the confirmation
    }
</script>
</body>
</html>
