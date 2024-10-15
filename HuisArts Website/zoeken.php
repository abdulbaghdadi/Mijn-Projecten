<!DOCTYPE html>
<html lang="nl">
<head>
    <!-- Set het karakter set voor het document -->
    <meta charset="UTF-8">
    
    <!-- Zet het viewport voor betere responsiviteit op verschillende apparaten -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Titel van het document -->
    <title>Huisartsenpraktijk</title>
    
    <!-- Link naar een extern stylesheet voor de opmaak -->
    <link rel="stylesheet" href="style.css">

</head>
<body>
    <!-- Navigatiemenu -->
    <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="patient.php">Patiënten</a></li>
        <li style="float:right"><a class="active" href="zoeken.php"><img src="images/search.png" alt="" srcset=""></a></li>
    </ul>

    <!-- Formulier voor zoeken op achternaam -->
    <form action="zoeken.php" method="get">
        <label for="search">Zoeken op Achternaam:</label>
        <input type="text" name="search" id="search" required>
        <button type="submit">Zoeken</button>
    </form>

    <?php
    // Inclusief het PHP-bestand voor databaseverbinding
    require_once "database.php";

    // Controleer of 'search' is ingesteld in de URL-querystring
    if (isset($_GET['search'])) {
        $searchTerm = $_GET['search'];

        // Query om patiënt- en notitiegegevens op te halen op basis van de zoekterm
        $query = "SELECT patient.*, notities.onderwerp, notities.datum, notities.tekst
        FROM patient
        LEFT JOIN notities ON patient.patient_id = notities.patient_id
        WHERE patient.achter_naam = :searchTerm
        ORDER BY notities.datum DESC";

        $stmt = $pdo->prepare($query);
        $stmt->execute(['searchTerm' => $searchTerm]);

        echo "<h2>Zoekresultaten</h2>";

        // Variabele om bij te houden of patiëntinformatie is weergegeven
        $patientDisplayed = false;

        // Maak een tabel voor patiënten
        echo "<table>";
        echo "<tr><th>Voornaam</th><th>Achternaam</th><th>Adres</th><th>Huisnummer</th><th>Postcode</th><th>Plaats</th><th>Telefoonnummer</th></tr>";

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            // Toon patiëntinformatie alleen als het nog niet is weergegeven
            if (!$patientDisplayed) {
                echo "<tr>";
                echo "<td>{$row['voor_naam']}</td>";
                echo "<td>{$row['achter_naam']}</td>";
                echo "<td>{$row['adress']}</td>";
                echo "<td>{$row['huis_nummer']}</td>";
                echo "<td>{$row['postcode']}</td>";
                echo "<td>{$row['plaats']}</td>";
                echo "<td>{$row['telefoon_nummer']}</td>";
                echo "</tr>";

                $patientDisplayed = true; // Set op true om aan te geven dat patiëntinformatie is weergegeven
            }
        }

        echo "</table>";

        // Toon notitie-informatie in de notitiestabel
        echo "<h2>Notities Resultaten</h2>";
        echo "<table>";
        echo "<tr><th>Onderwerp</th><th>Datum</th><th>Tekst</th></tr>";

        // Reset de instructie om resultaten vanaf het begin op te halen
        $stmt->execute(['searchTerm' => $searchTerm]);

        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo "<tr>";
            echo "<td>{$row['onderwerp']}</td>";
            echo "<td>{$row['datum']}</td>";
            echo "<td>{$row['tekst']}</td>";
            echo "</tr>";
        }

        echo "</table>";
    }
    ?>
</body>
</html>
