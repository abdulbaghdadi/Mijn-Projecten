<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['gebruiker_id'])) {
    echo "<p>log in eerst.</p>"; // If not logged in, prompt to log in
    exit(); // Exit the script
}

require_once "connectie.php";

// Handle form submission for adding a question
$success_message = '';
$error_message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['new_question'])) {
        $question = $_POST['new_question'];
        try {
            $stmt = $pdo->prepare("INSERT INTO vragen (vraag) VALUES (:question)");
            $stmt->bindParam(':question', $question);
            $stmt->execute();
            $success_message = "Vraag succesvol toegevoegd!";
        } catch (PDOException $e) {
            $error_message = "Error: " . $e->getMessage();
        }
    }
}

// Fetch all questions with their corresponding category names and pijlers names from the database
$query = "
    SELECT v.Vraag_id, v.Vraag, p.naam AS pijlers_naam, pc.naam AS categorie_naam
    FROM vragen v
    LEFT JOIN vraag_sbi_code_id vs ON v.Vraag_id = vs.Vraag_id
    LEFT JOIN pijlers_categories pc ON vs.pijlers_categorie_id = pc.pijlers_categorie_id
    LEFT JOIN pijlers p ON pc.pijlers_id = p.pijlers_id
";
$questions = $pdo->query($query)->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vragen</title>
    <link rel="stylesheet" href="vragen.css">
</head>
<body>
    <h1>Vragen</h1>

    <?php if ($success_message): ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php endif; ?>

    <?php if ($error_message): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <table border="1">
        <thead>
            <tr>
                <th>Vraag</th>
                <th>Pijlers Naam</th>
                <th>Categorie</th>
                <th>Acties</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($questions as $question) : ?>
                <tr>
                    <td><?php echo htmlspecialchars($question['Vraag']); ?></td>
                    <td><?php echo htmlspecialchars($question['pijlers_naam']); ?></td>
                    <td><?php echo htmlspecialchars($question['categorie_naam']); ?></td>
                    <td>
                        <form style="display:inline;" method="POST" action="edit_question.php">
                            <input type="hidden" name="Vraag_id" value="<?php echo htmlspecialchars($question['Vraag_id']); ?>">
                            <button type="submit">Bewerk</button>
                        </form>
                        <form style="display:inline;" method="POST" action="delet_question.php">
                            <input type="hidden" name="Vraag_id" value="<?php echo htmlspecialchars($question['Vraag_id']); ?>">
                            <button type="submit">Verwijder</button>
                        </form>
                        <form style="display:inline;" method="POST" action="add_answer.php">
                            <input type="hidden" name="Vraag_id" value="<?php echo htmlspecialchars($question['Vraag_id']); ?>">
                            <button type="submit">Voeg antwoord toe</button>
                        </form>
                        <form style="display:inline;" method="POST" action="add_category.php">
                            <input type="hidden" name="Vraag_id" value="<?php echo htmlspecialchars($question['Vraag_id']); ?>">
                            <button type="submit">Voeg categorie toe</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <h2>Voeg een nieuwe vraag toe</h2>
    <form method="POST" action="">
        <label for="new_question">Vraag:</label>
        <textarea id="new_question" name="new_question" rows="4" cols="50" required></textarea>
        <button type="submit">Toevoegen</button>
    </form>
    <p><a href="welcome_admin.php">Terug</a></p>

    <p><a href="logout.php">uitloggen</a></p> 

</body>
</html>
