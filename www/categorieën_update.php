<?php

session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'manager' && $_SESSION['role'] !== 'medewerker') {
    echo "You are not allowed to view this page, please login as admin, manager, or medewerker ";
    echo " login als een andere rol, hier <a href='login.php'> login </a>";
    exit;
}

// Check if the request method is not POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "You are not allowed to view this page ";
    echo " ga terug <a href='login.php'> login </a>";
    exit;
}

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


