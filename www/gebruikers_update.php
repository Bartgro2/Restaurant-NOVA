<?php
require 'database.php';

session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if the request method is not POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "You are not allowed to view this page ";
    echo "Ga terug naar <a href='dashboard.php'> dashboard </a>";
    exit;
}

// Sanitize and validate form fields
function test_input($data) {
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$errors = [];

$requiredFields = ['voornaam', 'achternaam', 'email', 'role', 'woonplaats', 'postcode', 'huisnummer', 'gebruikersnaam', 'wachtwoord', 'verzeker_wachtwoord'];

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

if (!preg_match("/^[a-zA-Z0-9\s]*$/", $_POST['gebruikersnaam'])) {
    $errors[] = "Only letters, numbers, and white space allowed for gebruikersnaam";
}

if (!empty($_POST['tussenvoegsel']) && !preg_match("/^[a-zA-Z-' ]*$/", $_POST['tussenvoegsel'])) {
    $errors[] = "Only letters and white space allowed for tussenvoegsel";
}

$wachtwoord = $_POST['wachtwoord'];
$verzeker_wachtwoord = $_POST['verzeker_wachtwoord'];
if ($verzeker_wachtwoord !== $wachtwoord) {
    $errors[] = "Passwords do not match.";
}

if (empty($errors)) {
    // Check if user already exists
    $stmt = $conn->prepare("SELECT COUNT(*) FROM gebruikers WHERE CONCAT(email, '|', voornaam, '|', achternaam, '|', gebruikersnaam) = :concatenated_data AND gebruiker_id != :gebruiker_id");
    $concatenated_data = $_POST['email'] . '|' . $_POST['voornaam'] . '|' . $_POST['achternaam'] . '|' . $_POST['gebruikersnaam'];
    $stmt->bindParam(':concatenated_data', $concatenated_data);
    $stmt->bindParam(':gebruiker_id', $_GET['id']);
    $stmt->execute();
    $count = $stmt->fetchColumn();

    if ($count > 0) {
        $errors[] = "User with a combination of the same email, firstname, lastname, username already exists";
    } else {
        $voornaam = $_POST['voornaam'];
        $tussenvoegsel = $_POST['tussenvoegsel'];
        $achternaam = $_POST['achternaam'];
        $gebruikersnaam = $_POST['gebruikersnaam'];
        $email = $_POST['email'];
        $wachtwoord = $_POST['wachtwoord'];
        $gebruiker_id = $_GET['id'];
        $woonplaats = $_POST['woonplaats'];
        $postcode = $_POST['postcode'];
        $huisnummer = $_POST['huisnummer'];

        // Update the user
        $hashed_password = password_hash($wachtwoord, PASSWORD_DEFAULT);
        $sql = "UPDATE gebruikers
        JOIN adressen ON gebruikers.adres_id = adressen.adres_id
        SET gebruikers.voornaam = :voornaam,
            gebruikers.tussenvoegsel = :tussenvoegsel,
            gebruikers.achternaam = :achternaam,
            gebruikers.email = :email,
            gebruikers.gebruikersnaam = :gebruikersnaam,
            gebruikers.wachtwoord = :wachtwoord,
            gebruikers.rol = :rol,
            adressen.woonplaats = :woonplaats,
            adressen.postcode = :postcode,
            adressen.huisnummer = :huisnummer
        WHERE gebruikers.gebruiker_id = :gebruiker_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':voornaam', $voornaam);
        $stmt->bindParam(':tussenvoegsel', $tussenvoegsel);
        $stmt->bindParam(':achternaam', $achternaam);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':gebruikersnaam', $gebruikersnaam);
        $stmt->bindParam(':wachtwoord', $hashed_password);

        // Check if the user is directeur, admin, or manager
        if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'directeur' || $_SESSION['role'] === 'manager') {
            // If so, set their role to the selected role from the form
            $stmt->bindParam(':rol', $_POST['role']);
        } else {
            // For other roles, set their role to their current role
            $stmt->bindParam(':rol', $_SESSION['role']);
        }

        $stmt->bindParam(':woonplaats', $woonplaats);
        $stmt->bindParam(':postcode', $postcode);
        $stmt->bindParam(':huisnummer', $huisnummer);
        $stmt->bindParam(':gebruiker_id', $gebruiker_id);
        $stmt->execute();

        // Check if both updates were successful
        if ($stmt->rowCount() > 0) {
            if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'manager' && $_SESSION['role'] !== 'medewerker') { 
                header("Location: gebruikers_index.php"); // Redirect to gebruikers_index.php
                exit; // Make sure to exit after redirecting
            } else {
                header("Location: dashboard.php"); // Redirect to dashboard.php
                exit; // Make sure to exit after redirecting
            }
        } else {
            $errors[] = "Error updating user";
        }
    }
}

// If there are errors, display them
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
    if ($_SESSION['role'] !== 'admin' || $_SESSION['role'] !== 'directeur' || $_SESSION['role'] !== 'manager' || $_SESSION['role'] !== 'medewerker') { 
        header("Location: gebruikers_index.php"); // Redirect to gebruikers_index.php
        exit; // Make sure to exit after redirecting
    } else {
        header("Location: dashboard.php"); // Redirect to dashboard.php
        exit; // Make sure to exit after redirecting
    }
}
?>
