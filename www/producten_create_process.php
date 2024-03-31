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
    echo " ga terug naar <a href='producten_index.php'> producten </a>";
    exit;
}

require 'database.php';

$naam = $_POST['naam'];
$categorie = $_POST['categorie'];
$menugang = $_POST['menugang'];
$beschrijving = $_POST['beschrijving'];
$inkoopprijs = $_POST['inkoopprijs'];
$verkoopprijs = $_POST['verkoopprijs'];
$vega = $_POST['vega'];
$aantal_voorraad = $_POST['aantal_voorraad'];
$image = isset($_FILES['image']) ? $_FILES['image'] : null;

$requiredFields = ['naam', 'categorie', 'menugang', 'beschrijving', 'inkoopprijs', 'verkoopprijs', 'vega', 'aantal_voorraad'];

foreach ($requiredFields as $field) {
    // Check if the field is required and not empty
    if (empty($_POST[$field])) {
        $errors[] = "Please fill in all fields";
        break; // Stop checking further fields if one is found empty
    }
}

// Validate name format
if (!preg_match("/^[a-zA-Z-' ]*$/", $_POST['naam'])) {
    $errors[] = "Invalid format for name. Only letters, spaces, hyphens, and apostrophes are allowed.";
}

// Check if the product already exists
$stmt_check = $conn->prepare("SELECT COUNT(*) AS count FROM producten WHERE naam = :naam AND categorie_id = :categorie AND menugang_id = :menugang");
$stmt_check->bindParam(':naam', $naam);
$stmt_check->bindParam(':categorie', $categorie);
$stmt_check->bindParam(':menugang', $menugang);
$stmt_check->execute();
$result_check = $stmt_check->fetch(PDO::FETCH_ASSOC);

if ($result_check['count'] > 0) {
    echo "Product with the same name already exists in the specified category and menugang.";
    echo " ga terug <a href='producten_index.php'> producten </a>";
    exit;
}

// Include file upload handling logic
include 'producten_create_file_upload.php';

if ($target_file) {
    $stmt = $conn->prepare("INSERT INTO producten (menugang_id, categorie_id, naam, beschrijving, inkoopprijs, verkoopprijs, vega, aantal_voorraad, image)
        VALUES (:menugang, :categorie, :naam, :beschrijving, :inkoopprijs, :verkoopprijs, :vega, :aantal_voorraad, :image)");

    $stmt->bindParam(':naam', $naam);
    $stmt->bindParam(':categorie', $categorie);
    $stmt->bindParam(':menugang', $menugang);
    $stmt->bindParam(':beschrijving', $beschrijving);
    $stmt->bindParam(':inkoopprijs', $inkoopprijs);
    $stmt->bindParam(':verkoopprijs', $verkoopprijs);
    $stmt->bindParam(':vega', $vega);
    $stmt->bindParam(':aantal_voorraad', $aantal_voorraad);
    $stmt->bindParam(':image', $target_file);

    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        header("Location: producten_index.php");
        exit;
    } else {
        echo "Something went wrong";
        echo "Ga terug naar <a href='producten_create.php'> producten</a>";
        exit();
    }
} else {
    echo "No file uploaded.";
    echo "Ga terug naar <a href='producten_create.php'> producten</a>";
    exit();
}
?>


