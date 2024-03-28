<?php

session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'manager' && $_SESSION['role'] !== 'medewerker') {
    echo "You are not allowed to view this page, please login as admin, manager, or medewerker ";
    echo " login als een andere rol, hier <a href='login.php'> login </a>";
    exit;
}

require 'database.php';
require 'footer.php';
require 'nav.php';

if (isset($_GET['id'])) {
    $menugang_id = $_GET['id'];

    
  $stmt = $conn->prepare("SELECT * FROM menugangen WHERE menugang_id = :menugang_id");
  $stmt->bindParam(':menugang_id', $menugang_id);
  $stmt->execute();
  $menugang = $stmt->fetch(PDO::FETCH_ASSOC);
    
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
    <div class="container">
        <?php if (isset($menugang)) : ?>          
                        <p><?php echo $menugang['naam'] ?></p> <!-- Corrected variable name --> 
        <?php else : ?>
            <p>menugang not found.</p>
        <?php endif; ?>
    </div>
</main>
</body>
</html>



