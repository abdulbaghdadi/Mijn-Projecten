<?php
// get_patient_info.php

// Include your database connection logic
require_once "database.php";

// Check if the patient ID is provided in the request
if (isset($_GET['id'])) {
    $patientId = $_GET['id'];

    try {
        // Fetch patient information based on the provided ID
        $stmt = $pdo->prepare("SELECT * FROM patient WHERE patient_id = :id");
        $stmt->bindParam(':id', $patientId);
        $stmt->execute();

        $patientInfo = $stmt->fetch(PDO::FETCH_ASSOC);

        // Check if patient information is found
        if ($patientInfo) {
            // Format the patient information as HTML
            $output = '<div class="patient-details">';
            $output .= '<strong>Naam:</strong> ' . $patientInfo['voor_naam'] . '<br>';
            $output .= '<strong>Achternaam:</strong> ' . $patientInfo['achter_naam'] . '<br>';
            $output .= '<strong>Adress:</strong> ' . $patientInfo['adress'] . '<br>';
            $output .= '<strong>Huisnummer:</strong> ' . $patientInfo['huis_nummer'] . '<br>';
            $output .= '<strong>Postcode:</strong> ' . $patientInfo['postcode'] . '<br>';
            $output .= '<strong>Plaats:</strong> ' . $patientInfo['plaats'] . '<br>';
            $output .= '<strong>Telefoonnummer:</strong> ' . $patientInfo['telefoon_nummer'] . '<br>';


            $output .= '<strong></strong> <img class="patient-photo" src="' . $patientInfo['patient_foto'] . '" alt="Patient Photo"><br>';

            // You can customize the HTML structure based on your requirements

            $output .= '</div>';

            // Return the formatted patient information
            echo $output;
        } else {
            // Patient not found
            echo "Patient not found.";
        }
    } catch (PDOException $e) {
        // Handle database error
        echo "Error: " . $e->getMessage();
    }
} else {
    // No patient ID provided in the request
    echo "Invalid request.";
}
?>
