<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['gebruiker_id'])) {
    echo "<p>Log in eerst.</p>"; // If not logged in, prompt to log in
    exit(); // Exit the script
}

require_once "connectie.php";

// Handle form submission for adding or updating categories
$success_message = '';
$error_message = '';

// Check if the form is submitted
if (isset($_POST['add_category'])) {
    // Retrieve form data
    $Vraag_id = $_POST['Vraag_id'];
    $code_id = isset($_POST['id']) && $_POST['id'] !== "" ? $_POST['id'] : NULL;
    $categorie_id = isset($_POST['categorie_id']) && $_POST['categorie_id'] !== "" ? $_POST['categorie_id'] : NULL;
    $pijlers = isset($_POST['pijlers']) && $_POST['pijlers'] !== "" ? $_POST['pijlers'] : NULL;

    try {
        // Prepare and execute the query to insert or update data in the database
        $stmt = $pdo->prepare(
            "INSERT INTO vraag_sbi_code_id (Vraag_id, id, categorie_id, pijlers_categorie_id) 
            VALUES (:Vraag_id, :id, :categorie_id, :pijlers)
            ON DUPLICATE KEY UPDATE
            id = VALUES(id),
            categorie_id = VALUES(categorie_id),
            pijlers_categorie_id = VALUES(pijlers_categorie_id)"
        );
        $stmt->bindParam(':Vraag_id', $Vraag_id);
        $stmt->bindParam(':id', $code_id, PDO::PARAM_INT);
        $stmt->bindParam(':categorie_id', $categorie_id);
        $stmt->bindParam(':pijlers', $pijlers);
        $stmt->execute();
        
        $success_message = "Category added or updated successfully.";
        // Use JavaScript to redirect after 3 seconds
        echo "<meta http-equiv='refresh' content='1;url=vragen.php'>";
    } catch (PDOException $e) {
        $error_message = "Error: " . $e->getMessage();
    }
}

$categories = $pdo->query("SELECT * FROM categorie")->fetchAll(PDO::FETCH_ASSOC);
$sbi_codes = $pdo->query("SELECT * FROM sbi_code")->fetchAll(PDO::FETCH_ASSOC);
$pijlers = $pdo->query("SELECT pc.pijlers_categorie_id, p.naam AS pijlers_naam, pc.naam AS categorie_naam FROM pijlers_categories pc INNER JOIN pijlers p ON pc.pijlers_id = p.pijlers_id")->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voeg categorie Toe</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #F7ECD8;
            padding: 20px;
        }

        h2 {
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

        select, input[type=text], input[type=number] {
            width: calc(100% - 10px);
            padding: 8px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            box-sizing: border-box;
        }

        input[type=submit] {
            background-color: #4CAF50;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }

        input[type=submit]:hover {
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
input[type="submit" i] {
    background-color: #284B63;
    color: #fff;
    border: none;
    padding: 15px 25px;
    cursor: pointer;

}
    </style>
</head>
<body>
    <h2>Add or Update Category</h2>

    <form action="" method="post">
        <input type="hidden" name="Vraag_id" value="<?php echo isset($_POST['Vraag_id']) ? htmlspecialchars($_POST['Vraag_id']) : ''; ?>">
        <label for="id">Code ID:</label>
        <select id="id" name="id">
            <option value="">-- Select Code ID --</option>
            <?php foreach ($sbi_codes as $code) : ?>
                <option value="<?php echo $code['id']; ?>"><?php echo $code['code_id']; ?></option>
            <?php endforeach; ?>
        </select>
        <label for="categorie_id">Category:</label>
        <select id="categorie_id" name="categorie_id">
        <option value="">-- Select Category --</option>
            <?php foreach ($categories as $category) : ?>
                <option value="<?php echo $category['categorie_id']; ?>"><?php echo $category['naam']; ?></option>
            <?php endforeach; ?>
        </select>
        <label for="pijlers">Pillar:</label>
        <select id="pijlers" name="pijlers">
        <option value="">-- Select Pillar --</option>

            <?php foreach ($pijlers as $pillar) : ?>
                <option value="<?php echo $pillar['pijlers_categorie_id']; ?>"><?php echo $pillar['pijlers_naam'] . " - " . $pillar['categorie_naam']; ?></option>
            <?php endforeach; ?>
        </select>
        <input type="submit" name="add_category" value="Add or Update Category">
    </form>   
    <?php if ($success_message): ?>
        <p style="color: green;"><?php echo $success_message; ?></p>
    <?php endif; ?>

    <?php if ($error_message): ?>
        <p style="color: red;"><?php echo $error_message; ?></p>
    <?php endif; ?>
    <p><a href="vragen.php">Terug naar Vragen</a></p>

</body>
</html>
