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
<?php require 'nav.php' ?>
<main>
  <div class="container">
    <div class="dashboard-container">
    
      <div class="dashboard-details">
        <div class="product-image-container">
          <img src="images/img_avatar.png" alt="Avatar" class="circular-img">
        </div>
        <a href="gebruikers_edit.php?id=<?php echo $gebruiker['gebruiker_id'] ?>">Bekijk</a>
        <a href="gebruikers_delete.php?id=<?php echo $gebruiker['gebruiker_id'] ?>">Verwijder</a>
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
    </div>
  </div>
</main>



<?php require 'footer.php' ?>
</body>
</html>

