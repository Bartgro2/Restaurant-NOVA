<?php
// Database configuratie
$host   = "mariadb";
$dbuser = "user";
$dbpass = "password";
$dbname = "restaurant_nova";

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $dbuser, $dbpass);
    // Verdere logica hier...
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>