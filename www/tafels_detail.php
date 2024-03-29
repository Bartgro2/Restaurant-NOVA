<?php
ob_start(); // Start output buffering

session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if role is not admin, manager or medewerker
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'manager') {
    echo "You are not allowed to view this page, please login as admin, manager, or medewerker ";
    echo " ga terug naar <a href='login.php'> login </a>";
    exit;
}

// Check if the request method is not GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo "You are not allowed to view this page ";
    echo " ga terug naar <a href='tafels_index.php'> tafel </a>";
    exit;
}

require 'database.php';


if (isset($_GET['id'])) {
    $tafel_id = $_GET['id'];

    $sql = "SELECT * FROM tafels WHERE tafel_id = :tafel_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':tafel_id', $tafel_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $tafel = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // No tafel found with the given ID
        echo "No tafel found with this ID <br>";
        echo "<a href='tafels_index.php'>Ga terug</a>";
        exit;
    }
} else {
    // Redirect to menugang_index.php if ID parameter is not set
    header("Location: menugang_index.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Menugang Detail</title>
</head>
<body>
<?php require 'nav.php' ?>
    <main>
        <div class="container">
            <?php if (isset($tafel)) : ?>          
                <h2><?php echo $tafel['aantal_personen'] ?></h2>
                <p> <?php echo $tafel['tafelnummer'] ?></p>
                <!-- Add other fields you want to display -->
            <?php else : ?>
                <p>tafel not found.</p>
            <?php endif; ?>
        </div>
    </main>
<?php require 'footer.php' ?>    
</body>
</html>

<?php ob_end_flush(); // End output buffering and flush the buffer ?>
