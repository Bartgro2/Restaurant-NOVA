<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if role is not admin, manager or medewerker
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'manager' && $_SESSION['role'] !== 'medewerker') {
    echo "You are not allowed to view this page, please login as admin, manager, or medewerker ";
    echo " login als een andere rol, hier <a href='login.php'> login </a>";
    exit;
}

// Check if the request method is not GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo "You are not allowed to view this page ";
    echo " ga terug naar <a href='login.php'> login </a>";
    exit;
}

require 'database.php';

$stmt = $conn->prepare("SELECT * FROM reserveringen join tafels on tafels.tafel_id = reserveringen.tafel_id");
$stmt->execute();
// set the resulting array to associative
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
    <?php include 'footer.php' ?>

    <main>
        <div class="container">
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>tafelnummer</th>
                        <th>personen</th>
                        <th>datum</th>
                        <th>tijd</th>       
                        <th>Acties</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($reserveringen as $reservering) : ?>
                        <tr>
                            <td><?php echo $reservering['id'] ?></td>
                            <td><?php echo $reservering['tafelnummer'] ?></td>
                            <td><?php echo $reservering['aantal_personen'] ?></td>
                            <td><?php echo $reservering['datum'] ?></td>
                            <td><?php echo $reservering['tijd'] ?></td>
                            <td>
                            <td>
                              <a href="reserveringen_detail.php?id=<?php echo $reservering['reservering_id'] ?>">Bekijk</a>
                              <a href="reserveringen_edit.php?id=<?php echo $reservering['reservering_id'] ?>">Wijzig</a>
                              <a href="reserveringen_delete.php?id=<?php echo $reservering['reservering_id'] ?>">Verwijder</a>
                        </td>
                            </td>
                        </tr> 
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </main>
</body>
</html>