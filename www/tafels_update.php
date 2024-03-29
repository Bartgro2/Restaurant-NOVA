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
    echo " ga terug <a href='tafels_index.php'> tafel </a>";
    exit;
}

require 'database.php';

$tafelnummer = $_POST['nummer'];
$aantal_personen = $_POST['personen'];
$tafel_id = $_GET['id'];

$sql = "UPDATE tafels
        SET tafelnummer = :tafelnummer,
        aantal_personen = :aantal_personen
        WHERE tafel_id = :tafel_id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':tafelnummer', $tafelnummer); // Corrected parameter name
$stmt->bindParam(':aantal_personen', $aantal_personen); // Corrected parameter name
$stmt->bindParam(':tafel_id', $tafel_id);

if ($stmt->execute()) {
    header("Location: tafels_index.php"); 
    exit; 
} else {
    echo "Error updating tafel";
    echo " ga terug naar <a href='tafels_index.php'> tafel </a>";
}
?>
