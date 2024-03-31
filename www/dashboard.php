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
    <div class="dashboard-details">
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
            
            </div>
          </div>
        <?php else : ?>
          <p>Gebruiker not found.</p>
        <?php endif; ?>
      </div>
    </div>
  </div>
</main>

<?php require 'footer.php' ?>
</body>
</html>

