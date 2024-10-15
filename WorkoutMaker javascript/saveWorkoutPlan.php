<?php

// Read the JSON data from the request body
$data = file_get_contents('php://input');

// Decode JSON data
$decodedData = json_decode($data, true);

// Define the file path to save the workout plan
$filePath = 'workoutPlan.json';

// Check if the "delete" parameter is present in the request
if (isset($_GET['delete'])) {
    // Handle exercise deletion
    $exerciseIdToDelete = $_GET['delete'];

    // Load existing workout plan from file
    $existingWorkoutPlan = json_decode(file_get_contents($filePath), true);

    // Find and remove the exercise with the specified ID
    $updatedWorkoutPlan = array_filter($existingWorkoutPlan, function ($exercise) use ($exerciseIdToDelete) {
        return $exercise['id'] !== $exerciseIdToDelete;
    });

    // Encode the updated workout plan back to JSON format
    $encodedUpdatedWorkoutPlan = json_encode($updatedWorkoutPlan, JSON_PRETTY_PRINT);

    // Save the updated workout plan to the file
    file_put_contents($filePath, $encodedUpdatedWorkoutPlan);

    // Respond with a success message
    echo json_encode(['status' => 'success', 'message' => 'Exercise deleted successfully.']);
} else {
    // Handle saving the workout plan

    // Encode the workout plan back to JSON format
    $encodedWorkoutPlan = json_encode($decodedData, JSON_PRETTY_PRINT);

    // Save the workout plan to the file
    file_put_contents($filePath, $encodedWorkoutPlan);

    // Respond with a success message
    echo json_encode(['status' => 'success', 'message' => 'Workout plan saved successfully.']);
}
?>
