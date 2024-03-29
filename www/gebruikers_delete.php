<?php

session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if role is admin or manager
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'manager') {
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

    // Delete the associated gebruikers records
    $sql = "DELETE FROM gebruikers WHERE gebruiker_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    
    if ($stmt->execute()) {
        // Now, delete the adres record
        $sql2 = "DELETE FROM adressen WHERE adres_id = :id";
        $stmt2 = $conn->prepare($sql2);
        $stmt2->bindParam(":id", $id);
        
    if ($stmt2->execute()) {
        header("Location: gebruikers_index.php"); // Redirect to tafels_index.php
        exit; // Make sure to exit after redirecting
    } else {
        echo "Error deleting gebruiker"; // Display an error message if deletion fails
    }
} else {
    echo "gebruiker not found"; // Display a message if the record is not found
}
} else {
header("Location: gebruikers_index.php");
exit;
}
?>
