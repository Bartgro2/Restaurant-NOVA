<?php

require 'database.php';

$name = $_POST['naam']; // Correct variable name

$stmt = $conn->prepare("INSERT INTO menugangen (naam) VALUES (:naam)");

$stmt->bindParam(':naam', $name); // Use the correct variable name here

$stmt->execute();

if ($stmt->rowCount() > 0) {
    header("Location: menugang_index.php");
    exit;
} else {
    echo "Something went wrong";
}

?>
