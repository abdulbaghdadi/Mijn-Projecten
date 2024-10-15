<?php

// Define the database connection parameters
$host = 'localhost';
$dbname = 'ksonederland';
$user = 'root';
$password = '';

// Create a new PDO instance
try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}

