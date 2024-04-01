<?php

session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if the request method is not GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo "You are not allowed to view this page ";
    echo " ga terug <a href='login.php'> login </a>";
    exit;
}

require 'database.php';

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Delete associated reservations
    $sql = "DELETE FROM reserveringen WHERE reservering_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    
    if (!$stmt->execute()) {
        echo "Error deleting associated reservations";
        echo " ga terug naar <a href='index.php'> home pagina  </a>";
        exit;
    }

    // Delete the address record if it exists
    $sql = "DELETE FROM adressen WHERE adres_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id);
    
    if (!$stmt->execute()) {
        echo "Error deleting associated address";
        echo " ga terug naar <a href='index.php'> home pagina  </a>";
        exit;
    }

    // Now, delete the user record
    $sql = "DELETE FROM gebruikers WHERE gebruiker_id = :id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $id);

    if ($stmt->execute()) {
        header("Location: gebruikers_index.php");
        exit;
    } else {
        echo "Error deleting user";
        echo " ga terug naar <a href='index.php'> home pagina  </a>";
        exit;
    }
} else {
    header("Location: gebruikers_create.php");
    exit;
}
?>



