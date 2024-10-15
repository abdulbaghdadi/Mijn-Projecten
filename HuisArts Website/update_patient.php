<?php
// update_patient.php
// Inclusief het PHP-bestand voor databaseverbinding
require_once "database.php";

// Controleer of het formulier is ingediend voor het bijwerken van patiëntinformatie
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        // Haal patiëntinformatie op
        $patientId = $_POST['patient_id'];
        $voorNaam = $_POST['voor_naam'];
        $achterNaam = $_POST['achter_naam'];
        $adress = $_POST['adress'];
        $huisNummer = $_POST['huis_nummer'];
        $postcode = $_POST['postcode'];
        $plaats = $_POST['plaats'];
        $telefoonNummer = $_POST['telefoon_nummer'];
        $patient_foto = $_POST['patient_foto'];

        // Bereid de update-instructie voor patiënten voor
        $stmtPatient = $pdo->prepare("UPDATE patient SET voor_naam = :voor_naam, achter_naam = :achter_naam, adress = :adress, huis_nummer = :huis_nummer, postcode = :postcode, plaats = :plaats, telefoon_nummer = :telefoon_nummer, patient_foto = :patient_foto WHERE patient_id = :patient_id");
        $stmtPatient->bindParam(':patient_id', $patientId);
        $stmtPatient->bindParam(':voor_naam', $voorNaam);
        $stmtPatient->bindParam(':achter_naam', $achterNaam);
        $stmtPatient->bindParam(':adress', $adress);
        $stmtPatient->bindParam(':huis_nummer', $huisNummer);
        $stmtPatient->bindParam(':postcode', $postcode);
        $stmtPatient->bindParam(':plaats', $plaats);
        $stmtPatient->bindParam(':telefoon_nummer', $telefoonNummer);
        $stmtPatient->bindParam(':patient_foto', $patient_foto);

        // Voer de update voor patiënten uit
        $stmtPatient->execute();

        // Haal notitie-informatie op
        $onderwerp = $_POST['onderwerp'];
        $datum = $_POST['datum'];
        $tekst = $_POST['tekst'];

        // Bereid de update-instructie voor notities voor
        $stmtNotities = $pdo->prepare("UPDATE notities SET onderwerp = :onderwerp, datum = :datum, tekst = :tekst WHERE patient_id = :patient_id");
        $stmtNotities->bindParam(':patient_id', $patientId);
        $stmtNotities->bindParam(':onderwerp', $onderwerp);
        $stmtNotities->bindParam(':datum', $datum);
        $stmtNotities->bindParam(':tekst', $tekst);

        // Voer de update voor notities uit
        $stmtNotities->execute();

        // Stel succesberichten in in sessievariabelen
        session_start();
        $_SESSION['success_message_patient'] = "Patiëntinformatie succesvol bijgewerkt.";
        $_SESSION['success_message_notities'] = "Notitie-informatie succesvol bijgewerkt.";

        // Doorverwijzen naar de lijst met patiënten of een succesbericht weergeven
        header("Location: patient.php");
        exit();
    } catch (PDOException $e) {
        die("Fout: " . $e->getMessage());
    }
}
?>
