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
require 'footer.php';
require 'nav.php';

if (isset($_GET['id'])) {
    $categorie_id = $_GET['id'];

    
  $stmt = $conn->prepare("SELECT * FROM categorieen WHERE categorie_id = :categorie_id");
  $stmt->bindParam(':categorie_id', $categorie_id);
  $stmt->execute();
  $categorie = $stmt->fetch(PDO::FETCH_ASSOC);
    
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
        <?php if (isset($categorie)) : ?>          
                        <p><?php echo $categorie['naam'] ?></p> <!-- Corrected variable name --> 
        <?php else : ?>
            <p>categorie not found.</p>
        <?php endif; ?>
    </div>
</main>
</body>
</html>



