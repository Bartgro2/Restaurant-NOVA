<?php

session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if role is not admin, manager or medewerker
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'manager' && $_SESSION['role'] !== 'medewerker') {
    echo "You are not allowed to view this page, please login as admin, manager, or medewerker ";
    echo " login als een andere rol, hier <a href='login.php'> login </a>";
    exit;
}

// Check if the request method is not GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo "You are not allowed to view this page ";
    echo " ga terug naar de <a href='categorieën.index.php'> categorieën </a>";
    exit;
}

require 'database.php';
require 'nav.php';
require 'footer.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Document</title>
</head>
<body>
    
</body>
</html>
<main>
    <div class="account-pagina2">
        <div class="form-panel">
           <!-- New div wrapper for vertical centering -->
                <h1>categorie maken</h1> <!-- Form title -->
                <hr class="separator"> <!-- Add horizontal line as a separator -->
                <form action="categorieën_create_process.php" method="POST">
                    <div class="input-groep">
                        <label for="naam">naam</label>
                        <input type="text" id="naam" name="naam">
                    </div>
                    <div class="input-groep">
                        <button type="submit" class="input-button"> aanmaken </button>
                    </div> 
                </form>
            </div>
        </div>
 
</main>
