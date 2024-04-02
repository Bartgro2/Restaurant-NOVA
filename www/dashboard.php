<?php 

session_start();

if (!isset($_SESSION['user_id'])) {
    echo "You are not logged in, please login. ";
    echo "<a href='login.php'>Login here</a>";
    exit;
}

require 'database.php';

$stmt = $conn->prepare("SELECT * FROM gebruikers join adressen on adressen.adres_id = gebruikers.adres_id");
$stmt->execute();
// set the resulting array to associative
$gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);

$stmt = $conn->prepare("SELECT * FROM reserveringen join tafels on tafels.tafel_id = reserveringen.tafel_id");
$stmt->execute();
// set the resulting array to associative
$reservering = $stmt->fetch(PDO::FETCH_ASSOC);




?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" crossorigin="anonymous">

    <title>Document</title>
</head>
<body>
<?php require 'nav.php' ?>
<main>
  <div class="container">
    <div class="dashboard-container">
      <div class="dashboard-details">
        <div class="product-image-container">
          <img src="images/img_avatar.png" alt="Avatar" class="circular-img">
        </div>
        <div class="introduce">
          Hi, <?php echo $gebruiker['gebruikersnaam'] ?>. Jouw rol is: <?php echo $gebruiker['rol'] ?>
        </div>
        
        <?php if (!empty($reservering)) { ?>
  <div class="reservation-details">
    <p class="section-title">Reservation Details</p>
    <div><span class="label">Naam:</span> <?php echo $gebruiker['voornaam'] ?></div>
    <div><span class="label">Datum:</span> <?php echo $reservering['datum'] ?></div>
    <div><span class="label">Tijd:</span> <?php echo $reservering['tijd'] ?></div>
    <div><span class="label">Hoeveelheid gasten:</span> <?php echo $reservering['aantal_personen'] ?></div>
    <div><span class="label">Tafel nummer:</span> <?php echo $reservering['tafel_nummer'] ?></div>
    <p><em>Please arrive 15 minutes before your reservation time. Thank you!</em></p>
  </div>
   <?php } else { ?>
     <p>Geen reservering.</p>
    <?php } ?>



        <div class="extra">
          <a href="gebruikers_edit.php?id=<?php echo $gebruiker['gebruiker_id'] ?>"><i class="fas fa-edit"></i>Edit</a>
          <a href="gebruikers_delete.php?id=<?php echo $gebruiker['gebruiker_id'] ?>" onclick="return confirm('Are you sure you want to delete this user?');"><i class="fas fa-trash-alt"></i>Delete</a>
        </div>
      </div>
    </div>
  </div>
</main>


<?php require 'footer.php' ?>
</body>
</html>

