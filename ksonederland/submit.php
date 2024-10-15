<?php
session_start();

require_once 'connectie.php';

// Check if the user is logged in
if (isset($_SESSION['gebruiker_id'])) {
    $gebruiker_id = $_SESSION['gebruiker_id'];

    // Check if the user has already submitted the form in the database
    $stmt_check_submit = $pdo->prepare("SELECT form_submitted FROM gebruiker WHERE Gebruiker_id = :gebruiker_id");
    $stmt_check_submit->bindParam(':gebruiker_id', $gebruiker_id);
    $stmt_check_submit->execute();
    $user_data = $stmt_check_submit->fetch(PDO::FETCH_ASSOC);

   

    // Loop through the submitted answers
    foreach ($_POST['antwoord'] as $vraag_id => $Mogelijke_Antworden_id) {
        // Check if the user has already answered this question
        $stmt_check = $pdo->prepare("SELECT * FROM antworden WHERE vraag_id = :vraag_id AND Gebruiker_id = :gebruiker_id");
        $stmt_check->bindParam(':vraag_id', $vraag_id);
        $stmt_check->bindParam(':gebruiker_id', $gebruiker_id);
        $stmt_check->execute();
        
        $existing_answer = $stmt_check->fetch(PDO::FETCH_ASSOC);

        if ($existing_answer) {
            // Update the existing answer
            $stmt_update = $pdo->prepare("UPDATE antworden SET Mogelijke_Antworden_id = :Mogelijke_Antworden_id WHERE vraag_id = :vraag_id AND Gebruiker_id = :gebruiker_id");
            $stmt_update->bindParam(':Mogelijke_Antworden_id', $Mogelijke_Antworden_id);
            $stmt_update->bindParam(':vraag_id', $vraag_id);
            $stmt_update->bindParam(':gebruiker_id', $gebruiker_id);
            $stmt_update->execute();
        } else {
            // Insert a new answer
            $stmt_insert = $pdo->prepare("INSERT INTO antworden (vraag_id, Mogelijke_Antworden_id, Gebruiker_id) VALUES (:vraag_id, :Mogelijke_Antworden_id, :gebruiker_id)");
            $stmt_insert->bindParam(':vraag_id', $vraag_id);
            $stmt_insert->bindParam(':Mogelijke_Antworden_id', $Mogelijke_Antworden_id);
            $stmt_insert->bindParam(':gebruiker_id', $gebruiker_id);
            $stmt_insert->execute();
        }
    }

    // Update the database to mark the form as submitted
    $stmt_update_submit = $pdo->prepare("UPDATE gebruiker SET form_submitted = 1 WHERE Gebruiker_id = :gebruiker_id");
    $stmt_update_submit->bindParam(':gebruiker_id', $gebruiker_id);
    $stmt_update_submit->execute();

    // Redirect to a thank you page or another appropriate page
    header("Location: grafiek.php");
    exit;
} else {
    // If user is not logged in
    echo "U bent niet ingelogd.";
}
?>
