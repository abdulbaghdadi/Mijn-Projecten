<?php
require_once "database.php";

if (isset($_GET['id'])) {
    $patientId = $_GET['id'];

    try {
        $stmt = $pdo->prepare("SELECT * FROM patient WHERE patient_id = :patient_id");
        $stmt->bindParam(':patient_id', $patientId);
        $stmt->execute();

        $patient = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($patient) {
            ?>

            <!DOCTYPE html>
            <html lang="en">
            <head>
                <meta charset="UTF-8">
                <meta name="viewport" content="width=device-width, initial-scale=1.0">
                <link rel="stylesheet" href="style.css">
                <title>Edit Patient</title>
            </head>
            <body>

                <ul>
                    <li><a href="index.html">Home</a></li>
                    <li><a href="patient.php">Patienten</a></li>
                    <li style="float:right"><a class="active" href="zoeken.php"><img src="images/search.png" alt="" srcset=""></a></li>
                </ul>

                <div class="patient-form">
                    <h2>Edit Patient</h2>
                    <form action="update_patient.php" method="post">
                        <input type="hidden" name="patient_id" value="<?php echo $patient['patient_id']; ?>">

                        <label for="voor_naam">Voornaam:</label>
                        <input type="text" name="voor_naam" value="<?php echo $patient['voor_naam']; ?>" required>

                        <label for="achter_naam">Achternaam:</label>
                        <input type="text" name="achter_naam" value="<?php echo $patient['achter_naam']; ?>" required>

                        <label for="adress">Adres:</label>
                        <input type="text" name="adress" value="<?php echo $patient['adress']; ?>" required>

                        <label for="huis_nummer">Huisnummer:</label>
                        <input type="text" name="huis_nummer" value="<?php echo $patient['huis_nummer']; ?>" required>

                        <label for="postcode">Postcode:</label>
                        <input type="text" name="postcode" value="<?php echo $patient['postcode']; ?>" required>

                        <label for="plaats">Plaats:</label>
                        <input type="text" name="plaats" value="<?php echo $patient['plaats']; ?>" required>

                        <label for="telefoon_nummer">Telefoonnummer:</label>
                        <input type="text" name="telefoon_nummer" value="<?php echo $patient['telefoon_nummer']; ?>" required>

                        <label for="patient_foto">Patientfoto:</label>
                        <input type="text" name="patient_foto" value="<?php echo $patient['patient_foto']; ?>" required>

                        



                        <button type="submit">Opslaan</button>
                    </form>
                </div>

            </body>
            </html>

            <?php
        } else {
            echo "Patient not found.";
        }
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
