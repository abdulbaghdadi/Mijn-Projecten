<?php
$host = "localhost"; // De hostnaam van de database-server
$dbname = "voetbaltoernooi"; // De naam van de database
$username = "root"; // De gebruikersnaam voor de databaseverbinding
$password = ""; // Het wachtwoord voor de databaseverbinding

try {
    // Probeer een nieuwe PDO (PHP Data Objects) verbinding te maken met de opgegeven gegevens
    $db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    
    // Stel PDO in om fouten te melden als uitzonderingen (exceptions)
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    // Als er een fout optreedt bij het maken van de verbinding, stop dan het script en geef een foutmelding weer
    die("Verbinding mislukt: " . $e->getMessage());
}
?>
