<?php
ob_start(); // Start output buffering

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


// Check if the request method is not GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo "You are not allowed to view this page ";
    echo " ga terug naar de <a href='categorieën.index.php'> categorieën </a>";
    exit;
}

require 'database.php';


if (isset($_GET['id'])) {
    $categorie_id = $_GET['id'];

    
  $stmt = $conn->prepare("SELECT * FROM categorieen WHERE categorie_id = :categorie_id");
  $stmt->bindParam(':categorie_id', $categorie_id);
  $stmt->execute();
  

  if ($stmt->rowCount() > 0) {
    $categorie = $stmt->fetch(PDO::FETCH_ASSOC);
} else {
    // No categorie found with the given ID
    echo "No categorie found with this ID <br>";
    echo "<a href='categorieën_index.php'> Ga terug</a>";
    exit;
}
} else {
// Redirect to categorieën_index.php if ID parameter is not set
header("Location: categorieën_index.php.php");
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
<?php require 'nav.php'  ?>
    <main>
    <div class="container">
        <?php if (isset($categorie)) : ?>          
                        <p><?php echo $categorie['naam'] ?></p> <!-- Corrected variable name --> 
        <?php else : ?>
            <p>categorie not found.</p>
        <?php endif; ?>
    </div>
</main>
<?php require 'footer.php' ?>
</body>
</html>

<?php ob_end_flush(); // End output buffering and flush the buffer ?>



