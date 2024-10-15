<?php
// Start de PHP-sessie
session_start();

// Maak alle sessievariabelen leeg
$_SESSION = array();

// Vernietig de sessie
session_destroy();

// Doorverwijzen naar de inlogpagina
header("Location: login.php");
exit();
?>
