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
    echo " ga terug naar <a href='gebruiker_index.php'> gebruikers </a>";
    exit;
}

require 'database.php';

if (isset($_GET['id'])) {
    $gebruiker_id = $_GET['id'];

    $sql = "SELECT * FROM gebruikers WHERE gebruiker_id = :gebruiker_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(':gebruiker_id', $gebruiker_id);
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // No gebruiker found with the given ID
        echo "No gebruiker found with this ID <br>";
        echo "<a href='gebruikers_index.php'> Ga terug</a>";
        exit;
    }
} else {
    // Redirect to gebruiker_index.php if ID parameter is not set
    header("Location: gebruikers_index.php");
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
<?php require 'nav.php'; ?>
    <main>
        <div class="container">
            <?php if (isset($gebruiker)) : ?>          
                <h2><?php echo $gebruiker['voornaam'] ?></h2>
                <p> <?php echo $gebruiker['achternaam'] ?></p>
                <!-- Add other fields you want to display -->
            <?php else : ?>
                <p>gebruiker not found.</p>
            <?php endif; ?>
        </div>
    </main>
<?php require 'footer.php'; ?>
</body>
</html>

<?php ob_end_flush(); // End output buffering and flush the buffer ?>