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
    echo " ga terug <a href='tafels_index.php'> tafels </a>";
    exit;
}

require 'database.php';

// Extract data from the form
$tafel_id = $_GET['id']; // Assuming 'id' is the name of the input field in your form
$tafel_nummer = $_POST['nummer'];
$aantal_personen = $_POST['personen'];

// Check if the provided tafelnummer already exists
$sql_check = "SELECT COUNT(*) AS count FROM tafels WHERE tafelnummer = :tafelnummer AND tafel_id != :tafel_id";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bindParam(':tafelnummer', $tafel_nummer);
$stmt_check->bindParam(':tafel_id', $tafel_id);
$stmt_check->execute();
$result_check = $stmt_check->fetch(PDO::FETCH_ASSOC);

// If the tafelnummer already exists, prevent the update operation
if ($result_check['count'] > 0) {
    echo "Tafelnummer already exists. Please choose a different tafelnummer.";
    echo " Ga terug naar <a href='tafels_index.php'> tafels </a>";
    exit;
}

// Prepare the SQL statement to update the tafel
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
    echo " Ga terug naar <a href='tafels_index.php'> tafels </a>";
}
?>


