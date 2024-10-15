<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['gebruiker_id'])) {
    echo "<p>Log in eerst.</p>"; // If not logged in, prompt to log in
    exit(); // Exit the script
}

// Include the database connection
require_once 'connectie.php';

// Initialize variables
$question_id = '';
$question_text = '';
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Vraag_id']) && isset($_POST['Vraag'])) {
        // Handle the update form submission
        $question_id = $_POST['Vraag_id'];
        $question_text = $_POST['Vraag'];

        try {
            $stmt = $pdo->prepare("UPDATE vragen SET Vraag = :Vraag WHERE Vraag_id = :Vraag_id");
            $stmt->bindParam(':Vraag', $question_text);
            $stmt->bindParam(':Vraag_id', $question_id);
            $stmt->execute();
            $success_message = "Vraag succesvol bijgewerkt!";
            header("Location: vragen.php");

        } catch (PDOException $e) {
            $error_message = "Error: " . $e->getMessage();
        }
    } elseif (isset($_POST['Vraag_id'])) {
        // Fetch the existing question details to edit
        $question_id = $_POST['Vraag_id'];
        try {
            $stmt = $pdo->prepare("SELECT Vraag FROM vragen WHERE Vraag_id = :Vraag_id");
            $stmt->bindParam(':Vraag_id', $question_id);
            $stmt->execute();
            $question = $stmt->fetch(PDO::FETCH_ASSOC);
            $question_text = $question['Vraag'];
        } catch (PDOException $e) {
            $error_message = "Error: " . $e->getMessage();
        }
    }
   

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vraag Bewerken</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F7ECD8;
            padding: 20px;
        }

        h1 {
            color: #333;
            text-align: center;
        }

        form {
            background-color: #fff;
            padding: 20px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        label {
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
        }

        input[type=text] {
            width: 100%;
            padding: 8px;
            margin-bottom: 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        button {
            background-color: #284B63;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        button:hover {
            background-color: #45a049;
        }

        .message {
            margin-top: 20px;
            padding: 10px;
            border-radius: 5px;
        }

        .success {
            background-color: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .error {
            background-color: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
        }
        p a {
    display: inline-block;
    padding: 10px 20px;
    background-color: #3C6E71;
    text-decoration: none;
    color: #fff;
    border-radius: 5px;
    transition: background-color 0.3s ease;
}

    </style>
</head>
<body>
    <h1>Vraag Bewerken</h1>

    <?php if ($success_message): ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
        <a href="vragen.php">Terug naar Vragen</a>
    <?php elseif ($error_message): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php else: ?>
        <form method="POST" action="edit_question.php">
            <input type="hidden" name="Vraag_id" value="<?php echo htmlspecialchars($question_id); ?>">
            <label for="Vraag">Vraag:</label>
            <input type="text" id="Vraag" name="Vraag" value="<?php echo htmlspecialchars($question_text); ?>" required>
            <button type="submit">Bijwerken</button>
        </form>
       <p> <a href="vragen.php">Terug naar Vragen</a></p>
    <?php endif; ?>
</body>
</html>
