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

    $sql = "SELECT * FROM gebruikers
            JOIN adressen on adressen.adres_id = gebruikers.adres_id
            WHERE gebruiker_id = :gebruiker_id";
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
    <div class="gebruiker-card">
      <?php if (isset($gebruiker)) : ?>
        <div class="product-image">
          <img src="images/img_avatar.png" alt="Avatar" style="width:100%">
        </div>
        <div class="container-something">
          <div class="personal-details">
            <h2><?php echo $gebruiker['voornaam'] ?> <?php echo $gebruiker['tussenvoegsel'] ?> <?php echo $gebruiker['achternaam'] ?></h2> 
            <p><?php echo $gebruiker['email'] ?></p>
            <div class="empty-space"></div> 
          </div>
          <div class="user-details">
            <p>Gebruiker:</p>
            <p>Naam: <?php echo $gebruiker['gebruikersnaam'] ?></p>
            <p>Rol: <?php echo $gebruiker['rol'] ?></p>
            <div class="empty-space"></div>
          </div>
          <div class="adres-details">
            <p>Adres:</p>
            <p>Woonplaats: <?php echo $gebruiker['woonplaats'] ?></p>
            <p>Postcode: <?php echo $gebruiker['postcode'] ?></p>
            <p>Huisnummer: <?php echo $gebruiker['huisnummer'] ?></p>
          </div>
        </div>
      <?php else : ?>
        <p>Gebruiker not found.</p>
      <?php endif; ?>
    </div>
  </div>
</main>



<?php require 'footer.php'; ?>
</body>
</html>

<?php ob_end_flush(); // End output buffering and flush the buffer ?>

