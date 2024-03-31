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
    echo " ga terug <a href='menugang.php'> menugang </a>";
    exit; // <-- Add this line
}

$naam = $_POST['naam'];
$id = $_GET['id'];

require 'database.php';

if (empty($naam) || !preg_match("/^[a-zA-Z0-9\s]*$/", $naam)) {
    if (empty($naam)) {
        echo "Naam cannot be empty.";
    } else {
        echo "Invalid format for naam. Only alphanumeric characters and spaces are allowed.";
    }
    echo " Ga terug <a href='categorieën_create.php'> categorieën </a>";
    exit;
}

// Check if the provided "naam" already exists for a menugang
$sql_check = "SELECT COUNT(*) AS count FROM menugangen WHERE naam = :naam AND menugang_id != :menugang_id";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bindParam(':naam', $naam);
$stmt_check->bindParam(':menugang_id', $id);
$stmt_check->execute();
$result_check = $stmt_check->fetch(PDO::FETCH_ASSOC);

// If the "naam" already exists, prevent the update operation
if ($result_check['count'] > 0) {
    echo "Naam already exists for menugang. Please choose a different naam.";
    echo " Ga terug naar <a href='menugang_index.php'> menugang </a>";
    exit;
}

// Prepare the SQL statement to update the menugang
$sql = "UPDATE menugangen
        SET naam = :naam
        WHERE menugang_id = :menugang_id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':naam', $naam);
$stmt->bindParam(':menugang_id', $id);

if ($stmt->execute()) {
    header("Location: menugang_index.php"); 
    exit; 
} else {
    echo "Error updating menugang";
    echo " ga terug naar <a href='menugang_index.php'> menugang </a>";
    exit();
}
?>



