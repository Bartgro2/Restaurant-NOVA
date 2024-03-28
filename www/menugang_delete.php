<?php

session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if role is not admin, manager or medewerker
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'manager') {
    echo "You are not allowed to view this page, please login as admin, manager, or medewerker ";
    echo " ga terug naar <a href='login.php'> menugang </a>";
    exit;
}

// Check if the request method is not POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "You are not allowed to view this page ";
    echo " ga terug <a href='login.php'> login </a>";
    exit;
}


require 'database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Select the record to delete
    $sql_select = "SELECT * FROM menugangen WHERE menugang_id = :id";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bindParam(":id", $id);
    $stmt_select->execute();

    if ($stmt_select->rowCount() > 0) {
        // Delete the record
        $sql_delete = "DELETE FROM menugangen WHERE menugang_id = :id";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bindParam(":id", $id);
        if ($stmt_delete->execute()) {
            header("Location: menugang_index.php"); // Redirect to menugang_index.php
            exit; // Make sure to exit after redirecting
        } else {
            echo "Error deleting menugang"; // Display an error message if deletion fails
        }
    } else {
        echo "Menugang not found"; // Display a message if the record is not found
    }
}
?>




