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
    echo " ga terug naar <a href='reserveringen_index.php'> reserveringen </a>";
    exit;
}

require 'database.php';

$stmt = $conn->prepare("SELECT * FROM reserveringen
                        JOIN tafels ON tafels.tafel_id = reserveringen.tafel_id
                        JOIN gebruikers ON gebruikers.gebruiker_id = reserveringen.gebruiker_id");
$stmt->execute();
$reserveringen = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
<?php include 'nav.php' ?>
    <main>
        <div class="container">
            <table>
                <thead>
                    <tr>
                                            
                        <th>voornaam</th>
                        <th>tussenvoegsel</th>
                        <th>achternaam</th>
                        <th>email</th>
                        <th>datum</th>
                        <th>tijd</th>   
                        <th>personen</th>
                        <th>tafelnummer</th>
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
    <?php foreach ($reserveringen as $reservering) : ?>
        <tr>
            
            <td><?php echo $reservering['voornaam'] ?></td>
            <td><?php echo $reservering['tussenvoegsel'] ?></td>
            <td><?php echo $reservering['achternaam'] ?></td>
            <td><?php echo $reservering['email'] ?></td>
            <td><?php echo $reservering['datum'] ?></td>
            <td><?php echo $reservering['tijd'] ?></td>
            <td><?php echo $reservering['aantal_personen'] ?></td>
            <td><?php echo $reservering['tafel_nummer'] ?></td>        
            <td>
                <a href="reserveringen_detail.php?id=<?php echo $reservering['reservering_id'] ?>">Bekijk</a> 
                <a href="reserveringen_edit.php?id=<?php echo $reservering['reservering_id'] ?>">Wijzig</a> 
                <a href="reserveringen_delete.php?id=<?php echo $reservering['reservering_id'] ?>">Verwijder</a>
            </td>
        </tr> 
    <?php endforeach; ?>
</tbody>
            </table>
        </div>
    </main>   
 <?php include 'footer.php' ?>
</body>
</html>