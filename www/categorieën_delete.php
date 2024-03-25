<?php

session_start();

require 'database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Select the record to delete
    $sql_select = "SELECT * FROM categorieen WHERE categorie_id = :id";
    $stmt_select = $conn->prepare($sql_select);
    $stmt_select->bindParam(":id", $id);
    $stmt_select->execute();

    if ($stmt_select->rowCount() > 0) {
        // Delete the record
        $sql_delete = "DELETE FROM categorieen WHERE categorie_id = :id";
        $stmt_delete = $conn->prepare($sql_delete);
        $stmt_delete->bindParam(":id", $id);
        if ($stmt_delete->execute()) {
            header("Location: categorieën_index.php"); // Redirect to menugang_index.php
            exit; // Make sure to exit after redirecting
        } else {
            echo "Error deleting categorie"; // Display an error message if deletion fails
        }
    } else {
        echo "categorie not found"; // Display a message if the record is not found
    }
}
?>




