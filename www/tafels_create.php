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
<?php require 'nav.php' ?>
    <main>
    <div class="account-pagina2">
        <div class="form-panel">    
            <h1>tafel maken</h1> <!-- Form title -->
            <hr class="separator"> <!-- Add horizontal line as a separator -->
            <form action="tafels_create_process.php" method="POST">
                    <div class="input-groep">
                        <label for="personen">personen</label>
                        <input type="number" id="personen" name="personen">
                    </div>
                    <div class="input-groep">
                        <label for="nummer">nummer</label>
                        <input type="number" id="nummer" name="nummer">
                    </div>                    
                    <div class="input-groep">
                        <button type="submit" class="input-button"> aanmaken </button>
                    </div> 
            </form>
        </div>
    </div>
</main>
<?php require 'footer.php' ?>
</body>
</html>

