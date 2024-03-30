<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if role is not admin, manager, or medewerker
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'manager' && $_SESSION['role'] !== 'medewerker') {
    echo "You are not allowed to view this page, please login as admin, manager, or medewerker ";
    echo " ga terug naar <a href='login.php'> menugang </a>";
    exit;
}

// Check if the request method is not POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "You are not allowed to view this page ";
    echo " ga terug <a href='tafels_index.php'> tafels </a>";
    exit;
}

require 'database.php';

// Extract data from the form
$tafel_id = $_GET['id']; // Assuming 'id' is the name of the input field in your form
$tafel_nummer = $_POST['nummer'];
$aantal_personen = $_POST['personen'];

// Prepare the SQL statement to update the reservering
$sql = "UPDATE tafels
        SET 
        tafelnummer = :tafelnummer,
        aantal_personen = :aantal_personen
        WHERE tafel_id = :tafel_id";

// Prepare and execute the SQL statement
$stmt = $conn->prepare($sql);
$stmt->bindParam(':tafelnummer', $tafel_nummer);
$stmt->bindParam(':aantal_personen', $aantal_personen);
$stmt->bindParam(':tafel_id', $tafel_id);


if ($stmt->execute()) {
    header("Location: tafels_index.php");
    exit;
} else {
    echo "Error updating tafels";
    echo " ga terug naar <a href='tafels_index.php'> tafels </a>";
}
?>

