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
    echo " ga terug <a href='menugang_create.php'> menugang </a>";
    exit;
}

require 'database.php';

$naam = $_POST['naam'];

if (empty($naam) || !preg_match("/^[a-zA-Z0-9\s]*$/", $naam)) {
    if (empty($naam)) {
        echo "Naam cannot be empty.";
    } else {
        echo "Invalid format for naam. Only alphanumeric characters and spaces are allowed.";
    }
    echo " Ga terug <a href='menugang_create.php'> menugang </a>"; // Fixed redirection link
    exit;
}

// Check if the menugang already exists
$stmt_check = $conn->prepare("SELECT COUNT(*) AS count FROM menugangen WHERE naam = :naam");
$stmt_check->bindParam(':naam', $naam);
$stmt_check->execute();
$result_check = $stmt_check->fetch(PDO::FETCH_ASSOC);

if ($result_check['count'] > 0) {
    echo "Menugang with the same name already exists.";
    echo " ga terug <a href='menugang_index.php'> menugang </a>";
    exit;
}

$stmt = $conn->prepare("INSERT INTO menugangen (naam) VALUES (:naam)");

$stmt->bindParam(':naam', $naam);
$stmt->execute();

if ($stmt->rowCount() > 0) {
    header("Location: menugang_index.php");
    exit;
} else {
    echo "Something went wrong";
    echo "Ga terug naar <a href='menugang_create.php'> menugang </a>";
    exit();
}

?>

