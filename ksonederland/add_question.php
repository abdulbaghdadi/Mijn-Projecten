<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['gebruiker_id'])) {
    echo "<p>log in eerst.</p>"; // If not logged in, prompt to log in
    exit(); // Exit the script
}

// Include the database connection
require_once 'connectie.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['new_question'])) {
        // Add Question
        $question = $_POST['new_question'];
        try {
            $stmt = $pdo->prepare("INSERT INTO vragen (vraag) VALUES (:question)");
            $stmt->bindParam(':question', $question);
            $stmt->execute();
            $success_message = "Vraag succesvol toegevoegd!";
        } catch (PDOException $e) {
            $success_message = "Error: " . $e->getMessage();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vraag Toevoegen</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            padding: 20px;
        }

        h1 {
            color: #333;
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
            background-color: #4CAF50;
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
        </style>
</head>
<body>
    <h1><?php echo isset($success_message) ? $success_message : "Nieuwe Vraag Toevoegen"; ?></h1>
    <form method="POST" action="add_question.php">
        <label for="new_question">Vraag:</label>
        <input type="text" id="new_question" name="new_question" required>
        <button type="submit">Toevoegen</button>
    </form>
    <a href="vragen.php">Terug naar Vragen</a>
</body>
</html>
