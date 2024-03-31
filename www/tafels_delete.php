<?php

session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if role is not admin, directeur, manager, or medewerker
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'directeur' && $_SESSION['role'] !== 'manager' && $_SESSION['role'] !== 'medewerker') {
    echo "You are not authorized to view this page. Please log in with appropriate credentials. ";
    echo "Log in with a different role <a href='login.php'>here</a>.";
    exit;
}

// Check if the request method is not GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo "You are not allowed to view this page ";
    echo " ga terug naar <a href='tafels_index.php'> tafels </a>";
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
            echo " ga terug <a href='tafels_index.php'> tafels </a>";
            exit;
        }
    } else {
        echo "Tafel not found"; // Display a message if the record is not found
        echo " ga terug <a href='tafels_index.php'> tafels </a>";
        exit;
    }
} else {
    header("Location: tafels_index.php");
    exit;
}
?>

