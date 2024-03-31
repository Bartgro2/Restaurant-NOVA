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


// Check if the request method is not POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "You are not allowed to view this page ";
    echo " ga terug <a href='menugang_create.php'> menugang </a>";
    exit;
}

require 'database.php';

$name = $_POST['naam']; // Correct variable name

$stmt = $conn->prepare("INSERT INTO menugangen (naam) VALUES (:naam)");

$stmt->bindParam(':naam', $name); // Use the correct variable name here

$stmt->execute();

if ($stmt->rowCount() > 0) {
    header("Location: menugang_index.php");
    exit;
} else {
    echo "Something went wrong";
    echo "Ga terug naar <a href='menugang_create.php'> menugang </a>";
    exit();
}

?>
