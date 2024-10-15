<?php
require_once "database.php";

if (isset($_GET['id'])) {
    $patientId = $_GET['id'];

    try {
        $stmt = $pdo->prepare("DELETE FROM patient WHERE patient_id = :patient_id");
        $stmt->bindParam(':patient_id', $patientId);
        $stmt->execute();

        header("Location: patient.php"); 
        exit();
    } catch (PDOException $e) {
        die("Error: " . $e->getMessage());
    }
}
?>
