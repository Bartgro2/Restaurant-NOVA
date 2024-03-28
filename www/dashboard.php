<?php 

session_start();

require 'database.php';
require 'nav.php';
require 'footer.php';



if (!isset($_SESSION['user_id'])) {
    echo "You are not logged in, please login. ";
    echo "<a href='login.php'>Login here</a>";
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "You are not allowed to view this page ";
    echo "<a href='login.php'> login hier </a>";
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
    <main>
         <div class="dashboard-container">


        

        <div class="dashboard-details">

            <h3>Persoonlijke gegevens</h3>
            <p><?php echo "Voornaam: " . $_SESSION['firstname'];; ?></p>
            <p><?php echo "achternaam: " . $_SESSION['lastname'];; ?></p>
            <p><?php echo "tussenvoegsel: " . $_SESSION['infix'];; ?></p>
            
        </div>
        <div class="empty-space"></div>
    </div>

    </main>
</body>
</html>

