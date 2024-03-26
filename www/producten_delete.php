<?php

require 'database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Select the record to delete
    $sql = "SELECT * FROM producten WHERE product_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {

        $sql = "DELETE FROM producten WHERE product_id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(":id", $id);

        if ($stmt->execute()) {
            header("Location: producten_index.php"); // Redirect to producten_index.php
            exit; // Make sure to exit after redirecting
        } else {
            echo "Error deleting product"; // Display an error message if deletion fails
        }
    } else {
        echo "Product not found"; // Display a message if the record is not found
    }
}
?>






