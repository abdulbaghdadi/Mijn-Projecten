<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['gebruiker_id'])) {
    echo "<p>Log eerst in.</p>"; // If not logged in, prompt to log in
    exit(); // Exit the script
}

require_once "connectie.php";

// Initialize variables
$success_message = '';
$error_message = '';
$question = null;
$answers = [];

// Handle form submission for adding answers
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Vraag_id'], $_POST['answers'], $_POST['percentages'])) {
        $Vraag_id = $_POST['Vraag_id'];
        $answers = $_POST['answers'];
        $percentages = $_POST['percentages'];
        
        try {
            $pdo->beginTransaction();
            $stmt = $pdo->prepare("INSERT INTO mogelijkeantworden (Vraag_id, Mogelijke_Antworden_tekst, Mogelijke_Antworden_procent) VALUES (:Vraag_id, :answer, :percentage)");
            $stmt->bindParam(':Vraag_id', $Vraag_id);
            
            foreach ($answers as $index => $answer) {
                $percentage = $percentages[$index];
                if (!is_numeric($percentage) || $percentage < 0 || $percentage > 100) {
                    throw new Exception("Percentage moet een getal tussen 0 en 100 zijn.");
                }
                $stmt->bindParam(':answer', $answer);
                $stmt->bindParam(':percentage', $percentage);
                $stmt->execute();
            }
            
            $pdo->commit();
            $success_message = "Antwoorden succesvol toegevoegd!";
        } catch (Exception $e) {
            $pdo->rollBack();
            $error_message = "Error: " . $e->getMessage();
        }
    } else {
    }
}

// Fetch question details and its answers if Vraag_id is set
if (isset($_POST['Vraag_id'])) {
    $Vraag_id = $_POST['Vraag_id'];

    // Fetch question details
    $stmt = $pdo->prepare("SELECT * FROM vragen WHERE Vraag_id = :Vraag_id");
    $stmt->bindParam(':Vraag_id', $Vraag_id);
    $stmt->execute();
    $question = $stmt->fetch(PDO::FETCH_ASSOC);

    // Fetch answers related to this question
    $stmt = $pdo->prepare("SELECT * FROM mogelijkeantworden WHERE Vraag_id = :Vraag_id");
    $stmt->bindParam(':Vraag_id', $Vraag_id);
    $stmt->execute();
    $answers = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voeg Antwoord Toe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F7ECD8;
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

        input[type=text], input[type=number] {
            width: calc(50% - 10px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .answer-group {
            display: flex;
            justify-content: space-between;
            margin-bottom: 10px;
        }

        button {
            background-color: #3C6E71;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
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

    <h1>Voeg Antwoord Toe</h1>

    <?php if ($success_message): ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
        <script>
            setTimeout(function() {
                window.location.href = 'vragen.php';
            }, 1500);
        </script>
    <?php endif; ?>

    <?php if ($error_message): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>

    <?php if ($question): ?>
        <h2>Vraag: <?php echo htmlspecialchars($question['Vraag']); ?></h2>
    <?php endif; ?>

    <form method="POST" action="">
        <input type="hidden" name="Vraag_id" value="<?php echo isset($_POST['Vraag_id']) ? htmlspecialchars($_POST['Vraag_id']) : ''; ?>">
        <div id="answers-container">
            <?php foreach ($answers as $index => $answer): ?>
                <div class="answer-group">
                    <input type="text" name="answers[]" value="<?php echo htmlspecialchars($answer['Mogelijke_Antworden_tekst']); ?>" required>
                    <input type="number" name="percentages[]" value="<?php echo htmlspecialchars($answer['Mogelijke_Antworden_procent']); ?>" min="0" max="100" required>
                </div>
            <?php endforeach; ?>
        </div>
        <button type="button" onclick="addAnswer()">Nog een antwoord toevoegen</button>
        <button type="button" onclick="addStandardAnswers()">Standaard antwoorden toevoegen</button>
        <br><br>
        <button type="submit">Toevoegen</button>
    </form>

    <p><a href="vragen.php">Terug naar Vragen</a></p>

    <script>
        let answerIndex = <?php echo count($answers); ?>;

        function addAnswer() {
            const container = document.getElementById('answers-container');
            container.innerHTML += `
                <div class="answer-group">
                    <input type="text" name="answers[]" placeholder="Antwoord" required>
                    <input type="number" name="percentages[]" placeholder="Percentage" min="0" max="100" required>
                </div>`;
            answerIndex++;
        }

        function addStandardAnswers() {
            const standardAnswers = [
                { answer: 'Nee', percentage: 0 },
                { answer: 'besproken is in het managementteam', percentage: 10 },
                { answer: 'besproken is met belanghebbende afdelingen', percentage: 15 },
                { answer: 'besproken met alle verantwoordelijken van alle afdelingen in het bedrijf', percentage: 25 },
                { answer: 'besproken, bevestig en gedeeld met het gehele personeelsbestand, waarbij 2o nodig werkomstandigheden en (werk)afspraken zijn aangepast in volledig beleidsplan', percentage: 50 },
                { answer: 'gedeeld met de stakeholders', percentage: 75 },
                { answer: 'besproken en gedeeld in de keten', percentage: 85 },
                { answer: 'besproken en gedeeld in de keten met onderliggende schriftelijke afspraken', percentage: 99 },
                { answer: 'besproken en gedeeld met afnemers ( de keten)', percentage: 100 }
            ];

            const container = document.getElementById('answers-container');
            standardAnswers.forEach(({ answer, percentage }) => {
                container.innerHTML += `
                    <div class="answer-group">
                        <input type="text" name="answers[]" value="${answer}" required>
                        <input type="number" name="percentages[]" value="${percentage}" min="0" max="100" required>
                    </div>`;
                answerIndex++;
            });
        }
    </script>
</body>
</html>
