<?php
session_start();
require_once 'connectie.php';

// Check if the user is logged in
if (isset($_SESSION['gebruiker_id'])) {
    // Validate and sanitize gebruiker_id input
    if (isset($_GET['gebruiker_id']) && is_numeric($_GET['gebruiker_id'])) {
        $gebruiker_id_to_update = intval($_GET['gebruiker_id']);

        // Check if the form is already submitted for the user
        $stmt_check_submit = $pdo->prepare("SELECT form_submitted FROM gebruiker WHERE Gebruiker_id = :gebruiker_id");
        $stmt_check_submit->bindParam(':gebruiker_id', $gebruiker_id_to_update, PDO::PARAM_INT);
        $stmt_check_submit->execute();
        $user_data = $stmt_check_submit->fetch(PDO::FETCH_ASSOC);

        if ($user_data) {
            // Toggle the form_submitted value
            $new_form_status = $user_data['form_submitted'] == 1 ? 0 : 1;

            // Begin a transaction for atomicity
            $pdo->beginTransaction();

            try {
                // Update the database to change the form_submitted status
                $stmt_update_submit = $pdo->prepare("UPDATE gebruiker SET form_submitted = :new_form_status WHERE Gebruiker_id = :gebruiker_id");
                $stmt_update_submit->bindParam(':new_form_status', $new_form_status, PDO::PARAM_INT);
                $stmt_update_submit->bindParam(':gebruiker_id', $gebruiker_id_to_update, PDO::PARAM_INT);
                $stmt_update_submit->execute();

                // Delete records from 'antworden' table for the selected gebruiker_id
                $stmt_delete_antworden = $pdo->prepare("DELETE FROM antworden WHERE Gebruiker_id = :gebruiker_id");
                $stmt_delete_antworden->bindParam(':gebruiker_id', $gebruiker_id_to_update, PDO::PARAM_INT);
                $stmt_delete_antworden->execute();

                // Commit the transaction if all queries succeed
                $pdo->commit();

                // Redirect back to admin dashboard with success message
                header("Location: welcome_Admin.php?success=1");
                exit;
            } catch (PDOException $e) {
                // Rollback the transaction on error
                $pdo->rollBack();
                echo "Error: " . $e->getMessage();
            }
        } else {
            // User not found, handle error
            echo "Gebruiker niet gevonden.";
        }
    } else {
        // Invalid or missing gebruiker_id parameter
        echo "Ongeldige gebruiker ID.";
    }
} else {
    // If user is not logged in
    echo "U bent niet ingelogd.";
    header("Location: index.php?");
}
?>
