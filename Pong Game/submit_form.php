<?php

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $leftScore = $_POST['leftScore'];
    $rightScore = $_POST['rightScore'];

    $gegevens = compact('leftScore', 'rightScore');

    $jsonBestand = 'data.json';
    $bestaandeGegevens = file_get_contents($jsonBestand);
    $bestaandeGegevens = json_decode($bestaandeGegevens, true) ?: [];

    $bestaandeGegevens[] = $gegevens;

    $jsonInhoud = json_encode($bestaandeGegevens, JSON_PRETTY_PRINT);

    file_put_contents($jsonBestand, $jsonInhoud);
}

?>
