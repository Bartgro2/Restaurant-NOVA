<?php

session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if role is not admin, manager or medewerker
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'manager' && $_SESSION['role'] !== 'medewerker') {
    echo "You are not allowed to view this page, please login as admin, manager, or medewerker ";
    echo " login als een andere rol, hier <a href='login.php'> login </a>";
    exit;
}


require 'database.php';

// Check if the 'id' parameter is present in the URL
if (isset($_GET['id'])) {
    $tafel_id = $_GET['id'];

    // Select the record to delete
    $sql = "SELECT * FROM tafels WHERE tafel_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $tafel_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Delete the record
        $sql = "DELETE FROM tafels WHERE tafel_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $tafel_id);
        if ($stmt->execute()) {
            header("Location: tafels_index.php"); // Redirect to tafels_index.php
            exit; // Make sure to exit after redirecting
        } else {
            echo "Error deleting tafel"; // Display an error message if deletion fails
        }
    } else {
        echo "Tafel not found"; // Display a message if the record is not found
    }
} else {
    header("Location: tafels_index.php");
    exit;
}
?>

