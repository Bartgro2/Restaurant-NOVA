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
    echo " ga terug naar <a href='tafels_index.php'> tafels </a>";
    exit;
}

require 'database.php';

$tafelnummer = $_POST['nummer'];
$aantal_personen = $_POST['personen'];

// Check if nummer and personen are not empty
if (empty($tafelnummer) && empty($aantal_personen)) {
    echo "Tafelnummer and aantal personen cannot be empty.";
    echo " Ga terug <a href='tafels_create.php'> tafels </a>";
    exit;
} elseif (empty($tafelnummer)) {
    echo "Tafelnummer cannot be empty.";
    echo " Ga terug <a href='tafels_create.php'> tafels </a>";
    exit;
} elseif (empty($aantal_personen)) {
    echo "Aantal personen cannot be empty.";
    echo " Ga terug <a href='tafels_create.php'> tafels </a>";
    exit;
}

// Check if the tafel already exists
$stmt_check = $conn->prepare("SELECT COUNT(*) AS count FROM tafels WHERE tafel_nummer = :tafel_nummer");
$stmt_check->bindParam(':tafel_nummer', $tafel_nummer);
$stmt_check->execute();
$result_check = $stmt_check->fetch(PDO::FETCH_ASSOC);

if ($result_check['count'] > 0) {
    echo "Tafel with the same tafelnummer already exists.";
    echo " Ga terug <a href='tafels_create.php'> tafels </a>";
    exit;
}

// Insert the tafel if it doesn't exist
$stmt_insert = $conn->prepare("INSERT INTO tafels (tafel_nummer, aantal_personen) VALUES (:tafel_nummer, :aantal_personen)");
$stmt_insert->bindParam(':tafel_nummer', $tafel_nummer);
$stmt_insert->bindParam(':aantal_personen', $aantal_personen);
$stmt_insert->execute();

if ($stmt_insert->rowCount() > 0) {
    header("Location: tafels_index.php");
    exit;
} else {
    echo "Something went wrong";
    echo " Ga terug <a href='tafels_create.php'> tafels </a>";
    exit;
}
?>
