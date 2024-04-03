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

// Check if the request method is not GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo "You are not allowed to view this page ";
    echo " ga terug naar <a href='reserveringen_index.php'> tafel </a>";
    exit;
}

require 'database.php';

if (isset($_GET['id'])) {
    $reservering_id = $_GET['id'];

    $sql = "SELECT * FROM reserveringen
    JOIN gebruikers on gebruikers.gebruiker_id = reserveringen.gebruiker_id 
    JOIN tafels on tafels.tafel_id = reserveringen.tafel_id 
    WHERE reservering_id = :reservering_id";
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
    <div class="product-card">
      <?php if (isset($reservering)) : ?>  
       <div class="product-image">
        <img src="images/img_avatar.png" alt="Avatar" style="width:100%">
       </div>
        <div class="container-something">
          <div class="personal-details">
            <p><?php echo $reservering['voornaam'] ?> <?php echo $reservering['tussenvoegsel'] ?> <?php echo $reservering['achternaam'] ?></p>
            <p><?php echo $reservering['email']?></p>
            <div class="empty-space"></div> 
          </div>
          <div class="reservation-details">
            <p>reservering:</p>
            <p>Datum: <?php echo $reservering['datum'] ?></p> 
            <p>Tijd: <?php echo $reservering['tijd'] ?></p>
            <p>Tafelnummer: <?php echo $reservering['tafel_nummer'] ?></p> 
            <p>Aantal Personen: <?php echo $reservering['aantal_personen'] ?></p>  
          </div>
        </div>
      <?php else : ?>
        <p>Reservering not found.</p>
      <?php endif; ?>
    </div>
  </div>
</main>



<?php require 'footer.php' ?>    
</body>
</html>




