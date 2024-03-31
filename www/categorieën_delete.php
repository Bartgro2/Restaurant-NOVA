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
    echo " ga terug <a href='login.php'> login </a>";
    exit;
}


require 'database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Select the record to delete
    $sql = "SELECT * FROM categorieen WHERE categorie_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        // Delete the record
        $sql = "DELETE FROM categorieen WHERE categorie_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id);
        if ($stmt->execute()) {
            header("Location: categorieën_index.php"); // Redirect to tafels_index.php
            exit; // Make sure to exit after redirecting
        } else {
            echo "Error deleting categorie"; // Display an error message if deletion fails
            echo " ga terug <a href='categorieën_index.php'> categorieën </a>";
            exit;
        }
    } else {
        echo "categorie not found"; // Display a message if the record is not found
        echo " ga terug <a href='categorieën_index.php'> categorieën </a>";
        exit;
    }
    } else {
    header("Location: categorieën_index.php");
    exit;
    }




