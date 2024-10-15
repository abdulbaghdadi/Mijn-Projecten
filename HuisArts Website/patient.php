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
    <title>Document</title>
    
    <!-- Voeg de jQuery-bibliotheek toe -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
    
    <!-- JavaScript-script -->
    <script>
        // Wacht tot het document volledig geladen is
        $(document).ready(function() {
            
            // Functie om patiënten te sorteren en weer te geven op basis van de geselecteerde volgorde
            function sortAndDisplayPatients(order) {
                // Verkrijg een array van alle patiëntkaarten
                var patients = $('.patient-card').toArray();

                // Sorteer de patiënten op basis van de achternaam
                patients.sort(function(a, b) {
                    var aName = $(a).data('achternaam');
                    var bName = $(b).data('achternaam');

                    return order === 'asc' ? aName.localeCompare(bName) : bName.localeCompare(aName);
                });

                // Leeg de container en voeg de gesorteerde patiënten toe
                $('.patient-cards-container').empty().append(patients);
            }

            // Koppel het wijzigingsevenement om te sorteren wanneer de dropdown wijzigt
            $('#sort-dropdown').on('change', function() {
                var sortOrder = $(this).val();
                sortAndDisplayPatients(sortOrder);
            });

            // Initiële sortering en weergave (standaard: oplopende volgorde)
            sortAndDisplayPatients('asc');
        });
    </script>

</head>
<body>

    <!-- Navigatiemenu -->
    <ul>
        <li><a href="index.html">Home</a></li>
        <li><a href="patient.php">Patiënten</a></li>
        
        <li style="float:right"><a class="active" href="zoeken.php"><img src="images/search.png" alt="" srcset=""></a></li>
    </ul>
    
    <!-- Voeg een knop toe om een nieuwe patiënt toe te voegen -->
    <div><a href="add_patient.php" class="add-patient-btn">Voeg nieuwe patiënt toe</a></div>

    <!-- Voeg een dropdown toe voor het sorteren -->
    <label for="sort-dropdown">Sorteer op Achternaam:</label>
    <select id="sort-dropdown">
        <option value="asc">asc</option>
        <option value="desc">desc</option>
    </select>

    <!-- Voeg een container toe voor patiëntenkaarten -->
    <div class="patient-cards-container">
        <?php
        // Inclusief het PHP-bestand voor databaseverbinding
        require_once "database.php";

        try {
            // Query om alle patiënten op te halen
            $stmt = $pdo->query("SELECT * FROM patient");

            if ($stmt) {
                // Haal alle rijen op
                $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

                // Loop door elke rij en toon de patiëntgegevens
                foreach ($rows as $row) {
                    echo '<div class="patient-card clickable" data-achternaam="' . $row['achter_naam'] . '" data-patient-id="' . $row['patient_id'] . '">';
                    echo "<strong>Naam:</strong> " . $row['voor_naam'] . "<br>";
                    echo "<strong>Achternaam:</strong> " . $row['achter_naam'] . "<br>";
                    echo "<strong></strong> <img class='patient-photo' src='" . $row['patient_foto'] . "' alt='Patient Photo'><br>";

                    // Stijl voor "Edit" link
                    echo '<a href="edit_patient.php?id=' . $row['patient_id'] . '" class="edit-link">Bewerk</a>';

                    // Stijl voor "notitie" link
                    echo '<a href="notitie_add_patient.php?id=' . $row['patient_id'] . '" class="edit-link">Notitie</a>';

                    // Stijl voor "Delete" link
                    echo '<a href="delete_patient.php?id=' . $row['patient_id'] . '" class="delete-link" onclick="return confirm(\'Weet u zeker dat u deze patiënt wilt verwijderen?\')">Verwijder</a>';

                    echo "</div>";
                }
            } else {
                // Toon foutinformatie als er een fout is opgetreden bij de query
                print_r($pdo->errorInfo());
            }
        } catch (PDOException $e) {
            // Toon een fout als er een PDO-uitzondering is opgetreden
            die("Fout: " . $e->getMessage());
        }
        ?>
    </div>

</body>
</html>
