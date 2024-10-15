<?php

$filePath = 'workoutPlan.json';

// Check if the file exists
if (file_exists($filePath)) {
    // Read the JSON data from the file
    $data = file_get_contents($filePath);

    // Check if the data is not empty
    if (!empty($data)) {
        // Decode the JSON data
        $workoutPlan = json_decode($data, true);

        // Respond with the loaded workout plan
        echo json_encode($workoutPlan);
        exit;
    }
}

// If the file doesn't exist or is empty, respond with an empty array
echo json_encode([]);
?>
