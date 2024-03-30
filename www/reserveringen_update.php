<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if the user role is admin, manager, or medewerker
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'manager' && $_SESSION['role'] !== 'medewerker') {
    echo "You are not allowed to view this page, please login as admin, manager, or medewerker ";
    echo " login als een andere rol, hier <a href='login.php'> login </a>";
    exit;
}

// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "You are not allowed to view this page ";
    echo "Ga terug naar <a href='gebruikers_index.php'> gebruikers</a>";
    exit;
}

require 'database.php';

// Sanitize and validate form fields
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$errors = [];

$requiredFields = ['voornaam', 'achternaam', 'email', 'tijd', 'datum', 'tafel_id']; // Add 'tafel_id' to required fields

foreach ($requiredFields as $field) {
    // Check if the field is required and not empty, except for tussenvoegsel
    if ($field !== 'tussenvoegsel' && empty($_POST[$field])) {
        $errors[] = "Please fill in all fields";
        break; // Stop checking further fields if one is found empty
    }
}

$email = test_input($_POST["email"]);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
}

foreach (['voornaam', 'achternaam'] as $nameField) {
    if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST[$nameField])) {
        $errors[] = "Only letters and white space allowed for " . ($nameField == 'voornaam' ? 'voornaam' : 'achternaam');
    }
}

if (!empty($_POST['tussenvoegsel']) && !preg_match("/^[a-zA-Z-' ]*$/", $_POST['tussenvoegsel'])) {
    $errors[] = "Only letters and white space allowed for tussenvoegsel";
}

if (empty($errors)) {
    // Retrieve necessary form data
    $voornaam = $_POST['voornaam'];
    $tussenvoegsel = $_POST['tussenvoegsel'];
    $achternaam = $_POST['achternaam'];
    $email = $_POST['email'];
    $tijd = $_POST['tijd'];
    $datum = $_POST['datum'];
    $reservering_id = $_GET['id'];
    $tafel_id = $_POST['tafel_id'];

    // Check if the reservering_id exists
    $stmt_check_id = $conn->prepare("SELECT COUNT(*) AS count FROM reserveringen WHERE reservering_id = :reservering_id");
    $stmt_check_id->bindParam(':reservering_id', $reservering_id);
    $stmt_check_id->execute();
    $row = $stmt_check_id->fetch(PDO::FETCH_ASSOC);
    $count = $row['count'];

    if ($count == 0) {
        // Reservering_id does not exist, handle the error or redirect to an error page
        echo "Error: The provided reservering_id does not exist.";
        exit;
    }

    // Check if the user with provided email already exists
    $stmt = $conn->prepare("SELECT * FROM gebruikers WHERE email = :email OR voornaam = :voornaam");

    $stmt->bindParam(':email', $email);
    $stmt->bindParam(':voornaam', $voornaam);

    $stmt->execute();
    $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

    // If user exists, get the user_id
    if ($gebruiker) {
        $gebruiker_id = $gebruiker['gebruiker_id'];

        // Check if the provided tafel_id exists
        $stmt_check_tafel = $conn->prepare("SELECT COUNT(*) AS count FROM tafels WHERE tafel_id = :tafel_id");
        $stmt_check_tafel->bindParam(':tafel_id', $tafel_id);
        $stmt_check_tafel->execute();
        $row_tafel = $stmt_check_tafel->fetch(PDO::FETCH_ASSOC);
        $count_tafel = $row_tafel['count'];

        if ($count_tafel == 0) {
            // Tafel_id does not exist, handle the error or redirect to an error page
            echo "Error: The provided tafel_id does not exist.";
            exit;
        }

        // Proceed with updating the reservation
        $sql_update_reservation = "UPDATE reserveringen
        SET 
            datum = :datum,
            tijd = :tijd,
            tafel_id = :tafel_id,
            gebruiker_id = :gebruiker_id
        WHERE reservering_id = :reservering_id";

        $stmt_update_reservation = $conn->prepare($sql_update_reservation);
        $stmt_update_reservation->bindParam(':datum', $datum);
        $stmt_update_reservation->bindParam(':tijd', $tijd);
        $stmt_update_reservation->bindParam(':tafel_id', $tafel_id);
        $stmt_update_reservation->bindParam(':gebruiker_id', $gebruiker_id);
        $stmt_update_reservation->bindParam(':reservering_id', $reservering_id);

        if ($stmt_update_reservation->execute()) {
            // Redirect to reserveringen_index.php after updating
            header("Location: reserveringen_index.php");
            exit;
        } else {
            echo "Error updating reservation. ";
            echo " ga terug naar <a href='reserveringen_index.php'> reseveringen </a>";
            exit;
        }
    }
}

// Display errors
foreach ($errors as $error) {
    echo $error . "<br>";
    echo " ga terug naar <a href='reserveringen_index.php'> reseveringen </a>";
    exit;
}
?>












 










