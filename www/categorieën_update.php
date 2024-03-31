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

$naam = $_POST['naam'];
$id = $_GET['id'];

require 'database.php';

// Check if the category name already exists
$sql_check = "SELECT COUNT(*) AS count FROM categorieen WHERE naam = :naam AND categorie_id != :categorie_id";
$stmt_check = $conn->prepare($sql_check);
$stmt_check->bindParam(':naam', $naam);
$stmt_check->bindParam(':categorie_id', $id);
$stmt_check->execute();
$result_check = $stmt_check->fetch(PDO::FETCH_ASSOC);

if ($result_check['count'] > 0) {
    echo "Category name already exists. Please choose a different name.";
    echo " ga terug naar <a href='categorieën_index.php'> categorieën </a>";
    exit;
}

// Update the category
$sql_update = "UPDATE categorieen SET naam = :naam WHERE categorie_id = :categorie_id";
$stmt_update = $conn->prepare($sql_update);
$stmt_update->bindParam(':naam', $naam);
$stmt_update->bindParam(':categorie_id', $id);

if ($stmt_update->execute()) {
    header("Location: categorieën_index.php"); 
    exit; 
} else {
    echo "Error updating categorie. ";
    echo " ga terug naar <a href='categorieën_edit.php'> categorieën </a>"; 
    exit();
}
?>




