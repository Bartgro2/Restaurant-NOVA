<?php

session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if the request method is not POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "You are not allowed to view this page ";
    echo " ga terug naar <a href='reserveringen_index.php'> reserveringen </a>";
    exit;
}

require 'database.php';

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);
    return $data;
}

$errors = [];

// Sanitize and validate form fields
$requiredFields = ['voornaam', 'achternaam', 'email', 'datum', 'tijd'];

foreach ($requiredFields as $field) {
    if (empty($_POST[$field])) {
        $errors[] = "Please fill in all fields";
        break; // Stop checking further fields if one is found empty
    }
}

// Check for email format
$email = test_input($_POST["email"]);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errors[] = "Invalid email format";
}

// Validate firstname and lastname
foreach (['voornaam', 'achternaam'] as $nameField) {
    if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST[$nameField])) {
        $errors[] = "Only letters and white space allowed for " . ($nameField == 'voornaam' ? 'voornaam' : 'achternaam');
    }
}

if (empty($errors)) {
     // Prepare concatenated data
     $email = $_POST['email'];

     // Check if user already exists with the same email
     $stmt = $conn->prepare("SELECT COUNT(*) FROM gebruikers WHERE email = :email");
     $stmt->bindParam(':email', $email);
     $stmt->execute();
     $count = $stmt->fetchColumn();


    if ($count > 0) {
        $errors[] = "User with the same email already exists";
    } else {
        // Insert user details
        $sql = "INSERT INTO gebruikers (voornaam, achternaam, tussenvoegsel, email) VALUES (:voornaam, :achternaam, :tussenvoegsel, :email)";
        $stmt2 = $conn->prepare($sql);
        $stmt2->bindParam(':voornaam', $_POST['voornaam']);
        $stmt2->bindParam(':achternaam', $_POST['achternaam']);
        $stmt2->bindParam(':tussenvoegsel', $_POST['tussenvoegsel']);
        $stmt2->bindParam(':email', $email);
        $stmt2->execute();

        if ($stmt2->rowCount() > 0) {
            // Check user role to determine further action
            if ($_SESSION['role'] === 'klant' || !isset($_SESSION['role'])) {
                // For customers or when role is not set
                $datum = $_POST['datum'];
                $tijd = $_POST['tijd'];

                // Prepare the statement to insert data into reserveringen table
                $stmt3 = $conn->prepare("INSERT INTO reserveringen (gebruiker_id, datum, tijd) VALUES (:gebruiker_id, :datum, :tijd)");
                $stmt3->bindParam(':gebruiker_id', $conn->lastInsertId());
                $stmt3->bindParam(':datum', $datum);
                $stmt3->bindParam(':tijd', $tijd);

                // Execute the insertion
                if ($stmt3->execute()) {
                    header("Location: reserveringen_index.php");
                    exit;
                } else {
                    $errors[] = "Error inserting reserveringen data.";
                }
            } else {
                // For non-customer roles
                $gebruiker_id = $conn->lastInsertId();
                $tafel_id = $_POST['tafel_id'];
                $datum = $_POST['datum'];
                $tijd = $_POST['tijd'];

                // Insert table into the reservations
                $stmt4 = $conn->prepare("INSERT INTO reserveringen (gebruiker_id, tafel_id, datum, tijd) VALUES (:gebruiker_id, :tafel_id, :datum, :tijd)");
                $stmt4->bindParam(':gebruiker_id', $gebruiker_id);
                $stmt4->bindParam(':tafel_id', $tafel_id);
                $stmt4->bindParam(':datum', $datum);
                $stmt4->bindParam(':tijd', $tijd);

                if ($stmt4->execute()) {
                    if ($_SESSION['role'] != 'admin' && $_SESSION['role'] != 'directeur' && $_SESSION['role'] != 'manager' && $_SESSION['role'] != 'medewerker') {
                        // For roles other than admin, directeur, manager, and medewerker
                        header("Location: reserveringen_index.php");
                        exit;
                    } else {                 
                        header("Location: index.php");
                        exit;
                    }
                } else {
                    $errors[] = "Error inserting table into reserveringen.";
                }
            }
        } else {
            $errors[] = "Error inserting user data.";
        }
    }
}

// Display errors if any
if (!empty($errors)) {
    foreach ($errors as $error) {
        echo $error . "<br>";
    }
    echo '<a href="reserveringen_index.php">Go back</a>'; 
}
?>





