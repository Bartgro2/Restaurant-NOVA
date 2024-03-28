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

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "You are not allowed to view this page ";
    echo " ga terug <a href='gebruikers_create.php'> login </a>";
    exit;
}

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


