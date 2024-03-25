<?php
ob_start(); 


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
    }
} else {
    echo "No file uploaded.";
}

ob_end_flush(); 
?>


