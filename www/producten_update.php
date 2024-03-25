<?php

$naam = $_POST['naam'];
$id = $_GET['id'];

require 'database.php';

$sql = "UPDATE categorieen
        SET naam = :naam
        WHERE categorie_id = :categorie_id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':naam', $naam);
$stmt->bindParam(':categorie_id', $id);

if ($stmt->execute()) {
    header("Location: categorieën_index.php"); // Redirect to menugang_index.php
    exit; // Make sure to exit after redirecting
} else {
    echo "Error updating categorie"; // Add error handling if needed
}
?>


