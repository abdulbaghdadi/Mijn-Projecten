<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['gebruiker_id'])) {
    header("Location: index.php");
    exit();
}

require_once "connectie.php";

// Initialize variables
$success_message = "";

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['add_question'])) {
        // Add Question
        $question = $_POST['question'];
        try {
            $stmt = $pdo->prepare("INSERT INTO vragen (Vraag) VALUES (:question)");
            $stmt->bindParam(':question', $question);
            $stmt->execute();
            $question_id = $pdo->lastInsertId();
            $_SESSION['last_inserted_question_id'] = $question_id; // Store in session
            $success_message = "Question inserted successfully. Question ID: $question_id";
        } catch (PDOException $e) {
            $success_message = "Error: ". $e->getMessage();
        }
    } elseif (isset($_POST['add_category'])) {
        // Add Category
        $Vraag_id = $_POST['Vraag'];
        $code_id = $_POST['id']!== ""? $_POST['id'] : NULL;
        $categorie_id = $_POST['categorie_id'];
        $pijlers = $_POST['pijlers'];
        try {
            $stmt = $pdo->prepare("INSERT INTO vraag_sbi_code_id (Vraag_id, id, categorie_id, pijlers_categorie_id) VALUES (:Vraag_id, :id, :categorie_id, :pijlers)");
            $stmt->bindParam(':Vraag_id', $Vraag_id);
            $stmt->bindParam(':id', $code_id, PDO::PARAM_INT);
            $stmt->bindParam(':categorie_id', $categorie_id);
            $stmt->bindParam(':pijlers', $pijlers);
            $stmt->execute();
            $success_message = "Category added successfully.";
        } catch (PDOException $e) {
            $success_message = "Error: ". $e->getMessage();
        }
    } elseif (isset($_POST['add_answer'])) {
        // Add Answer
        $question_id = $_POST['question'];
        $stmt = $pdo->prepare("INSERT INTO mogelijkeantworden (vraag_id, Mogelijke_Antworden_tekst, Mogelijke_Antworden_procent) VALUES (:vraag_id, :Mogelijke_Antworden_tekst, :Percentage)");
        foreach ($_POST['answers'] as $key => $answer) {
            $stmt->bindParam(':vraag_id', $question_id);
            $stmt->bindParam(':Mogelijke_Antworden_tekst', $_POST['answers'][$key]);
            $stmt->bindParam(':Percentage', $_POST['percentages'][$key]);
            $stmt->execute();
        }
        $success_message = "Answers inserted successfully.";
    }
}

// Fetch questions, categories, codes, and pillars for the forms
$questions = $pdo->query("SELECT * FROM vragen")->fetchAll(PDO::FETCH_ASSOC);
$categories = $pdo->query("SELECT * FROM categorie")->fetchAll(PDO::FETCH_ASSOC);
$sbi_codes = $pdo->query("SELECT * FROM sbi_code")->fetchAll(PDO::FETCH_ASSOC);
$pijlers = $pdo->query("SELECT pc.pijlers_categorie_id, p.naam AS pijlers_naam, pc.naam AS categorie_naam FROM pijlers_categories pc INNER JOIN pijlers p ON pc.pijlers_id = p.pijlers_id")->fetchAll(PDO::FETCH_ASSOC);

// Get last inserted question ID from session
$last_inserted_question_id = isset($_SESSION['last_inserted_question_id'])? $_SESSION['last_inserted_question_id'] : null;

// Destroy session when user logs out
if (isset($_GET['logout'])) {
    session_destroy();
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="dashboard_admin.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1>Admin Panel</h1>
    <?php if (!empty($success_message)) :?>
        <p><?php echo $success_message;?></p>
    <?php endif;?>

    <!-- Add Question Form -->
    <h2>Add Question</h2>
    <form action="" method="post">
        <label for="question">Question:</label>
        <textarea id="question" name="question" rows="4" cols="50" required></textarea>
        <input type="submit" name="add_question" value="Add Question">
    </form>

    <!-- Add Category Form -->
    <h2>Add Category</h2>
    <form action="" method="post">
        <label for="Vraag">Question:</label>
        <select id="Vraag" name="Vraag">
            <?php foreach ($questions as $q) : ?>
                <option value="<?php echo $q['Vraag_id']; ?>" <?php echo ($last_inserted_question_id == $q['Vraag_id']) ? 'selected' : ''; ?>>
                    <?php echo $q['Vraag']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <label for="id">Code ID:</label>
        <select id="id" name="id">
            <option value="">-- Select Code ID --</option>
            <?php foreach ($sbi_codes as $code) : ?>
                <option value="<?php echo $code['id']; ?>"><?php echo $code['code_id']; ?></option>
            <?php endforeach; ?>
        </select>
        <label for="categorie_id">Category:</label>
        <select id="categorie_id" name="categorie_id">
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['categorie_id']; ?>"><?php echo $category['naam']; ?></option>
            <?php endforeach; ?>
        </select>
        <label for="pijlers">Pillar:</label>
        <select id="pijlers" name="pijlers">
            <?php foreach ($pijlers as $pillar) : ?>
                <option value="<?php echo $pillar['pijlers_categorie_id']; ?>"><?php echo $pillar['pijlers_naam'] . " - " . $pillar['categorie_naam']; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" name="add_category" value="Add Category">
    </form>

    <!-- Add Answer Form -->
    <h2>Add Answer</h2>
    <form action="" method="post" id="answerForm">
        <label for="question">Select a question:</label>
        <select id="question" name="question">
            <?php foreach ($questions as $q) : ?>
                <option value="<?php echo $q['Vraag_id']; ?>" <?php echo ($last_inserted_question_id == $q['Vraag_id']) ? 'selected' : ''; ?>>
                    <?php echo $q['Vraag']; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <div id="answers">
            <div class="answer-group">
                <label for="answer">Answer:</label>
                <input type="text" class="answer-text" name="answers[]"><br>
                <label for="percentage">Percentage:</label>
                <input type="text" class="percentage" name="percentages[]"><br>
            </div>
        </div>
        <button type="button" id="addAnswer">Add Answer</button><br><br>
        <input type="submit" name="add_answer" value="Submit">
    </form>

    <script>
        $(document).ready(function() {
            $("#addAnswer").click(function() {
                var newAnswer = `
                    <div class="answer-group">
                        <label for="answer">Answer:</label>
                        <input type="text" class="answer-text" name="answers[]"><br>
                        <label for="percentage">Percentage:</label>
                        <input type="text" class="percentage" name="percentages[]"><br>
                    </div>
                `;
                $("#answers").append(newAnswer);
            });
        });
    </script>
    <p><a href="rapport.php">Rapport</a></p>
    <p><a href="create_admin_user.php">voeg een admin</a></p>
    <p><a href="logout.php">uitloggen</a></p>
</body>
</html>