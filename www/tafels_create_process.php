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
    echo " login als een andere rol, hier <a href='login.php'> login </a>";
    exit;
}

// Check if the request method is not POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "You are not allowed to view this page ";
    echo " ga terug <a href='login.php'> login </a>";
    exit;
}

require 'database.php';

$tafelnummer = $_POST['nummer'];
$aantal_personen = $_POST['personen'];


$stmt = $conn->prepare("INSERT INTO tafels (tafelnummer, aantal_personen) VALUES (:tafelnummer, :aantal_personen)");

$stmt->bindParam(':tafelnummer', $tafelnummer);
$stmt->bindParam(':aantal_personen', $aantal_personen);

$stmt->execute();

if ($stmt->rowCount() > 0) {
    header("Location: tafels_index.php");
    exit;
} else {
    echo "Something went wrong";
}

?>