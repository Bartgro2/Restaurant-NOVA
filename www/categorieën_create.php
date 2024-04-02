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


require 'database.php';


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
<?php require 'nav.php'; ?>
    <main>
    <div class="container">
    <div class="categorie-container">
    <div class="account-pagina">
        <div class="form-panel">
           <!-- New div wrapper for vertical centering -->
                <h1>categorie </h1> <!-- Form title -->
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
    </div>  
  </div>
</main>
<?php require 'footer.php' ?>
</body>
</html>


