<?php

session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'manager') {
    echo "You are not allowed to view this page, please login as admin, manager, or medewerker ";
    echo " login als een andere rol, hier <a href='login.php'> login </a>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "You are not allowed to view this page ";
    echo "<a href='gebruikers_index.php'> ga terug </a>";
    exit;
}

require 'database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Select the associated gebruikers records
    $sql = "SELECT * FROM gebruikers WHERE adres_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    
    if ($stmt->execute()) {
        // Delete the associated gebruikers records
        $sql = "DELETE FROM gebruikers WHERE adres_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        
        if ($stmt->execute()) {
            // Now, delete the adres record
            $sql = "DELETE FROM adressen WHERE adres_id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":id", $id);
            
            if ($stmt_delete_adres->execute()) {
                header("Location: gebruikers_index.php"); // Redirect to gebruikers_index.php
                exit; // Make sure to exit after redirecting
            } else {
                echo "Error deleting adres"; // Display an error message if deletion fails
            }
        } else {
            echo "Error deleting gebruikers"; // Display an error message if deletion fails
        }
    } else {
        echo "Error selecting gebruikers"; // Display an error message if selection fails
    }
}
?>




