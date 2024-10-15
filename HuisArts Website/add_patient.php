<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css">
    <title>Add New Patient</title>
</head>
<body>

<ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="patient.php">Patienten</a></li>
        
        <li style="float:right"><a class="active" href="zoeken.php"><img src="images/search.png" alt="" srcset=""></a></li>
    </ul>

    <div class="patient-form">
        <h2>Add New Patient</h2>
        <form action="insert_patient.php" method="post">
            <label for="voor_naam">Voornaam:</label>
            <input type="text" name="voor_naam" required>

            <label for="achter_naam">Achternaam:</label>
            <input type="text" name="achter_naam" required>

            <label for="adress">Adress:</label>
            <input type="text" name="adress" required>

            <label for="huis_nummer">Huisnummer:</label>
            <input type="text" name="huis_nummer" required>
            
            <label for="postcode">Postcode:</label>
            <input type="text" name="postcode" required>

            <label for="plaats">Plaats:</label>
            <input type="text" name="plaats" required>

            <label for="telefoon_nummer">Telefoonnummer:</label>
            <input type="text" name="telefoon_nummer" required>

            <label for="patient_foto">Patientfoto:</label>
            <input type="text" name="patient_foto" required>

            <button type="submit">Voeg toe</button>
        </form>
    </div>

</body>
</html>
