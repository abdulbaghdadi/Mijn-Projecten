<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['gebruiker_id'])) {
    echo "<p>log in eerst.</p>"; // If not logged in, prompt to log in
    exit(); // Exit the script
}

require_once "connectie.php";

// Handle form submission for deleting a question
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['Vraag_id'])) {
        $vraag_id = $_POST['Vraag_id'];
        try {
            // Begin a transaction
            $pdo->beginTransaction();

            // Delete from vraag_sbi_code_id first
            $stmt = $pdo->prepare("DELETE FROM vraag_sbi_code_id WHERE Vraag_id = :vraag_id");
            $stmt->bindParam(':vraag_id', $vraag_id);
            $stmt->execute();

            // Delete from mogelijkeantworden
            $stmt = $pdo->prepare("DELETE FROM mogelijkeantworden WHERE Vraag_id = :vraag_id");
            $stmt->bindParam(':vraag_id', $vraag_id);
            $stmt->execute();

            // Delete from vragen
            $stmt = $pdo->prepare("DELETE FROM vragen WHERE Vraag_id = :vraag_id");
            $stmt->bindParam(':vraag_id', $vraag_id);
            $stmt->execute();

            // Commit the transaction
            $pdo->commit();

            header("Location: vragen.php"); // Redirect to the questions page after deletion
            exit();
        } catch (PDOException $e) {
            // Rollback the transaction if something failed
            $pdo->rollBack();
            echo "Error: " . $e->getMessage();
        }
    }
} else {
    echo "Invalid request method.";
}
?>
