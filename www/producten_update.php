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

$product_naam = $_POST['naam'];
$categorie_id = $_POST['categorie']; // Veronderstel dat 'categorie' het categorie-ID is
$menugang_id = $_POST['menugang']; // Veronderstel dat 'menugang' het menugang-ID is
$beschrijving = $_POST['beschrijving'];
$inkoopprijs = $_POST['inkoopprijs'];
$verkoopprijs = $_POST['verkoopprijs'];
$vega = $_POST['vega'];
$aantal_voorraad = $_POST['aantal_voorraad'];
$image = isset($_FILES['image']) ? $_FILES['image']['name'] : null; // Alleen de bestandsnaam wordt hier opgeslagen
$product_id = $_GET['id'];



// Query voor het bijwerken van het product
$sql = "UPDATE producten
        SET menugang_id = :menugang_id,
            categorie_id = :categorie_id,
            naam = :naam,
            beschrijving = :beschrijving,
            inkoopprijs = :inkoopprijs,
            verkoopprijs = :verkoopprijs,
            vega = :vega,
            aantal_voorraad = :aantal_voorraad,
            image = :image
        WHERE product_id = :product_id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':product_id', $product_id);
$stmt->bindParam(':menugang_id', $menugang_id);
$stmt->bindParam(':categorie_id', $categorie_id);
$stmt->bindParam(':naam', $product_naam); // De juiste parameterbinding
$stmt->bindParam(':beschrijving', $beschrijving);
$stmt->bindParam(':inkoopprijs', $inkoopprijs);
$stmt->bindParam(':verkoopprijs', $verkoopprijs);
$stmt->bindParam(':vega', $vega);
$stmt->bindParam(':aantal_voorraad', $aantal_voorraad);
$stmt->bindParam(':image', $image);
die();
if ($stmt->execute()) {
    header("Location: producten_index.php"); // Redirect naar categorieën_index.php
    exit; // Zorg ervoor dat je na het doorsturen de code verlaat
} else {
    echo "Fout bij het bijwerken van het product"; // Voeg foutafhandeling toe indien nodig
    echo "Ga terug naar <a href='producten_index.php'> producten </a>";
    exit();
}
?>



