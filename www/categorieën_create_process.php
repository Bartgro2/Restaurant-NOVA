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
    echo " ga terug naar <a href='categorieën_index.php'> categorieën </a>";
    exit;
}

require 'database.php';

$naam = $_POST['naam'];

// Check if naam is empty or contains invalid characters
if (empty($naam) || !preg_match("/^[a-zA-Z0-9\s]*$/", $naam)) {
    if (empty($naam)) {
        echo "Naam cannot be empty.";
    } else {
        echo "Invalid format for naam. Only alphanumeric characters and spaces are allowed.";
    }
    echo " Ga terug <a href='categorieën_create.php'> categorieën </a>";
    exit;
}


// Check if the provided category name already exists
$sql_check = "SELECT COUNT(*) AS count FROM categorieen WHERE naam = :naam";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bindParam(':naam', $naam);
$stmt_check->execute();
$result_check = $stmt_check->fetch(PDO::FETCH_ASSOC);

// If the category name already exists, prevent the insertion
if ($result_check['count'] > 0) {
    echo "Category name already exists. Please choose a different name.";
    echo " ga terug naar <a href='categorieën_create.php'> categorieën </a>";
    exit;
}

// Insert the category name into the database
$stmt = $conn->prepare("INSERT INTO categorieen (naam) VALUES (:naam)");
$stmt->bindParam(':naam', $naam);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    header("Location: categorieën_index.php");
    exit;
} else {
    echo "Something went wrong";
    echo " ga terug <a href='categorieën_create.php'> categorieën </a>";
    exit;
}

?>


