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
    echo " ga terug naar <a href='reserveringen_index.php'> tafel </a>";
    exit;
}

require 'database.php';

if (isset($_GET['id'])) {
    $reservering_id = $_GET['id'];

    $sql = "SELECT * FROM reserveringen WHERE reservering_id = :reservering_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':reservering_id', $reservering_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $reservering = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // No reservering found with the given ID
        echo "No reservering found with this ID <br>";
        echo "<a href='reserveringen_index.php'> Ga terug</a>";
        exit;
    }
} else {
    // Redirect to reserveringen_index.php if ID parameter is not set
    header("Location: reserveringen_index.php");
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
            <?php if (isset($reservering)) : ?>          
                <h2><?php echo $reservering['datum'] ?></h2>
                <p> <?php echo $reservering['tijd'] ?></p>
                <!-- Add other fields you want to display -->
            <?php else : ?>
                <p>reservering not found.</p>
            <?php endif; ?>
        </div>
    </main>
<?php require 'footer.php' ?>    
</body>
</html>

<?php ob_end_flush(); // End output buffering and flush the buffer ?>

