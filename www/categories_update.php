<?php

$naam = $_POST['naam'];
$id = $_GET['id'];

require 'database.php';

$sql = "UPDATE menugangen
        SET naam = :naam
        WHERE menugang_id = :menugang_id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':naam', $naam);
$stmt->bindParam(':menugang_id', $id);

if ($stmt->execute()) {
    header("Location: menugang_index.php"); // Redirect to menugang_index.php
    exit; // Make sure to exit after redirecting
} else {
    echo "Error updating menugang"; // Add error handling if needed
}
?>


