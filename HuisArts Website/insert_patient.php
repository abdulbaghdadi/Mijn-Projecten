<?php
require_once "database.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $voorNaam = $_POST["voor_naam"];
    $achterNaam = $_POST["achter_naam"];
    $adress = $_POST["adress"];
    $huis_nummer = $_POST["huis_nummer"];
    $postcode = $_POST["postcode"];
    $plaats = $_POST["plaats"];
    $telefoon_nummer = $_POST["telefoon_nummer"];
    $patient_foto = $_POST["patient_foto"];




    try {
        $stmt = $pdo->prepare("INSERT INTO patient (voor_naam, achter_naam, huis_nummer, postcode, plaats, telefoon_nummer, patient_foto, adress) 
        VALUES (:voor_naam, :achter_naam, :huis_nummer, :postcode, :plaats, :telefoon_nummer, :patient_foto, :adress)");


        $stmt->bindParam(':voor_naam', $voorNaam);
        $stmt->bindParam(':achter_naam', $achterNaam);
        $stmt->bindParam(':adress', $adress);
        $stmt->bindParam(':huis_nummer', $huis_nummer);
        $stmt->bindParam(':postcode', $postcode);
        $stmt->bindParam(':plaats', $plaats);
        $stmt->bindParam(':telefoon_nummer', $telefoon_nummer);
        $stmt->bindParam(':patient_foto', $patient_foto);



        $stmt->execute();

        header("Location: patient.php"); 
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
} else {

    echo "Form not submitted.";
}
?>
