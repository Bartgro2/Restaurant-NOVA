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
$gebruikers = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
         <div class="dashboard-container">

        <div class="dashboard-details">

            <h3>Persoonlijke gegevens</h3>
            <p><?php echo "Voornaam: " . $_SESSION['firstname'];; ?></p>
            <p><?php echo "achternaam: " . $_SESSION['lastname'];; ?></p>
            <p><?php echo "tussenvoegsel: " . $_SESSION['infix'];; ?></p>
            
        </div>
        <div class="empty-space"></div>

                <a href="gebruikers_detail.php?id=<?php echo $gebruiker['gebruiker_id'] ?>">Bekijk</a>
                <a href="gebruikers_delete.php?id=<?php echo $gebruiker['gebruiker_id'] ?>">Verwijder</a>
    </div>
    </main>
<?php require 'footer.php' ?>
</body>
</html>

