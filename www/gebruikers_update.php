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
    echo " ga terug naar <a href='reserveringen_index.php'> reserveringen </a>";
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

// Sanitize and validate form fields
$requiredFields = ['voornaam', 'achternaam', 'email', 'role', 'woonplaats', 'postcode', 'huisnummer', 'gebruikersnaam', 'wachtwoord'];

foreach ($requiredFields as $field) {
    // Check if the field is required and not empty, except for tussenvoegsel
    if ($field !== 'tussenvoegsel' && empty($_POST[$field])) {
        $errors[] = "Please fill in all fields";
        break; // Stop checking further fields if one is found empty
    }
}

// Check for email format
$email = test_input($_POST["email"]);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
}

// Validate firstname, lastname, and username
foreach (['voornaam', 'achternaam'] as $nameField) {
    if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST[$nameField])) {
        $errors[] = "Only letters and white space allowed for " . ($nameField == 'voornaam' ? 'voornaam' : 'achternaam');
    }
}

// Validate username
if (!preg_match("/^[a-zA-Z0-9\s]*$/", $_POST['gebruikersnaam'])) {
    $errors[] = "Only letters, numbers, and white space allowed for gebruikersnaam";
}

// Validate tussenvoegsel if present
if (!empty($_POST['tussenvoegsel']) && !preg_match("/^[a-zA-Z-' ]*$/", $_POST['tussenvoegsel'])) {
    $errors[] = "Only letters and white space allowed for tussenvoegsel";
}

// Verify if the passwords match
$wachtwoord = $_POST['wachtwoord'];
$verzeker_wachtwoord = $_POST['verzeker_wachtwoord'];
if ($verzeker_wachtwoord !== $wachtwoord) {
    $errors[] = "Passwords do not match.";
}

if (empty($errors)) {
    $voornaam = $_POST['voornaam'];
    $tussenvoegsel = $_POST['tussenvoegsel'];
    $achternaam = $_POST['achternaam'];
    $gebruikersnaam = $_POST['gebruikersnaam'];
    $email = $_POST['email'];
    $wachtwoord = $_POST['wachtwoord'];
    $rol =  $_SESSION['role'];
    $woonplaats =  $_POST['woonplaats'];
    $postcode =  $_POST['postcode'];
    $huisnummer =  $_POST['huisnummer'];
    $gebruiker_id = $_POST['id'];

    // Retrieve the address ID based on the user ID
    $sql = "SELECT * FROM adressen
            JOIN gebruikers ON gebruikers.adres_id = adressen.adres_id
            WHERE gebruiker_id = :gebruiker_id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':gebruiker_id', $gebruiker_id);
    $stmt->execute();
    $adres = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($adres) {
        $adres_id = $adres['adres_id']; // Assuming 'adres_id' is the primary key of the 'adressen' table

        // Update the address details
        $sql = "UPDATE adressen
                SET woonplaats = :woonplaats,
                    postcode = :postcode,
                    huisnummer = :huisnummer
                WHERE adres_id = :adres_id";

        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':woonplaats', $woonplaats);
        $stmt->bindParam(':postcode', $postcode);
        $stmt->bindParam(':huisnummer', $huisnummer);
        $stmt->bindParam(':adres_id', $adres_id);
        $stmt->execute();

        // Check if the address update was successful
        if ($stmt->rowCount() > 0) {
            // Proceed with updating the user
            $sql = "UPDATE gebruikers
                    SET adres_id = :adres_id,
                        voornaam = :voornaam,
                        tussenvoegsel = :tussenvoegsel,
                        achternaam = :achternaam,
                        email = :email,
                        gebruikersnaam = :gebruikersnaam,
                        wachtwoord = :wachtwoord";
            
            // Update role only if the user has admin, directeur, or manager role
            if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'directeur' || $_SESSION['role'] === 'manager') {
                if (isset($_POST['rol'])) {
                    $sql .= ", role = :rol";
                }
            }
            
            $sql .= " WHERE gebruiker_id = :gebruiker_id";

            $hashed_password = password_hash($wachtwoord, PASSWORD_DEFAULT);
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':adres_id', $adres_id);
            $stmt->bindParam(':voornaam', $voornaam);
            $stmt->bindParam(':tussenvoegsel', $tussenvoegsel);
            $stmt->bindParam(':achternaam', $achternaam);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':gebruikersnaam', $gebruikersnaam);
            $stmt->bindParam(':wachtwoord', $hashed_password);
            $stmt->bindParam(':gebruiker_id', $gebruiker_id);
            
            // Bind role parameter if it exists
            if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'directeur' || $_SESSION['role'] === 'manager') {
                if (isset($_SESSION['role'])) {
                    $stmt->bindParam(':rol', $_SESSION['role']);
                }
            }
            
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                // User updated successfully
                header("Location: gebruikers_index.php");
                exit;
            } else {
                // Error updating user
                echo "Error updating user details. ";
                echo " ga terug naar  </a>";
                exit;
            }
        } else {
            // Error updating address
            echo "Error updating address details. ";
            echo " ga terug naar ";
            exit;
        }
    } else {
        // Error retrieving address
        echo "Error retrieving address details. ";
        echo " ga terug naar ";
        exit;
    }
} else {
    // Display errors
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
    if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'directeur' && $_SESSION['role'] !== 'manager' && $_SESSION['role'] !== 'medewerker') {
        header("Location: gebruikers_index.php"); // Redirect to gebruikers_index.php
        exit; // Make sure to exit after redirecting
    } else {
        header("Location: dashboard.php"); // Redirect to dashboard.php
        exit; // Make sure to exit after redirecting
    }
}
?>

