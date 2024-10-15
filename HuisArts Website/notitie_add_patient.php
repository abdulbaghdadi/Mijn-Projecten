<?php
// Inclusief het PHP-bestand voor databaseverbinding
require_once "database.php";

// Controleer of het formulier is ingediend voor het toevoegen van een nieuwe notitie
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Haal het patient_id op uit de URL
        $patientId = $_GET['id'] ?? null;

        // Controleer of de patiënt bestaat voordat de notitie wordt toegevoegd
        $checkPatient = $pdo->prepare("SELECT * FROM patient WHERE patient_id = :patient_id");
        $checkPatient->bindParam(':patient_id', $patientId);
        $checkPatient->execute();

        if ($checkPatient->rowCount() > 0) {
            // Patiënt bestaat, ga verder met het invoegen van de notitie
            $stmt = $pdo->prepare("INSERT INTO notities (patient_id, onderwerp, datum, tekst) VALUES (:patient_id, :onderwerp, :datum, :tekst)");

            // Koppel parameters met formulierwaarden
            $stmt->bindParam(':patient_id', $patientId);
            $stmt->bindParam(':onderwerp', $_POST['onderwerp']);
            $stmt->bindParam(':datum', $_POST['datum']);
            $stmt->bindParam(':tekst', $_POST['tekst']);

            // Voer de instructie uit
            $stmt->execute();

            // Redirect naar de pagina met de lijst van patiënten na het toevoegen van een nieuwe notitie
            header("location: patient.php");
            exit();
        } else {
            // Patiënt bestaat niet, handel dienovereenkomstig (toon een foutmelding, doorverwijzen, enz.)
            echo "Patiënt bestaat niet.";
        }
    } catch (PDOException $e) {
        die("Fout: " . $e->getMessage());
    }
}

// Toon het formulier voor het toevoegen van een nieuwe notitie
?>

<!DOCTYPE html>
<html lang="nl">
<head>
    <!-- Set het karakter set voor het document -->
    <meta charset="UTF-8">
    
    <!-- Zet het viewport voor betere responsiviteit op verschillende apparaten -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Link naar een extern stylesheet voor de opmaak -->
    <link rel="stylesheet" href="style.css">
    
    <!-- Titel van het document -->
    <title>Notitie Toevoegen</title>
</head>
<body>

    <!-- Navigatiemenu -->
    <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="patient.php">Patiënten</a></li>
        <li style="float:right"><a class="active" href="zoeken.php"><img src="images/search.png" alt="" srcset=""></a></li>
    </ul>

    <!-- Formulier voor het toevoegen van een notitie -->
    <div class="note-form">
        <h2>Notitie Toevoegen</h2>
        <form action="" method="post">
            <!-- Voeg een verborgen invoerveld toe voor patient_id -->
            <input type="hidden" name="patient_id" value=""> <!-- Vervang door het werkelijke patient_id -->

            <label for="onderwerp">Onderwerp:</label>
            <input type="text" name="onderwerp" required>

            <label for="datum">Datum:</label>
            <input type="date" name="datum" required>

            <label for="tekst">Tekst:</label>
            <input type="text" name="tekst" required>

            <button type="submit">Opslaan</button>
        </form>
    </div>

</body>
</html>
