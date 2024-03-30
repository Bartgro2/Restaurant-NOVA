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

// Check if the request method is not GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo "You are not allowed to view this page ";
    echo " ga terug <a href='login.php'> login </a>";
    exit;
}
  

require 'database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Select the record to delete
    $sql = "SELECT * FROM producten WHERE product_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {

        $sql = "DELETE FROM producten WHERE product_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            header("Location: producten_index.php"); // Redirect to producten_index.php
            exit; // Make sure to exit after redirecting
        } else {
            echo "Error deleting product"; // Display an error message if deletion fails
            echo "Ga terug naar <a href='producten_index.php'> producten</a>";
            exit();
            
        }
    } else {
        echo "Product not found"; // Display a message if the record is not found
        echo "Ga terug naar <a href='producten_index.php'> producten</a>";
        exit();
    }
} else {
    header("Location: producten_index.php");
    exit;
}
?>






