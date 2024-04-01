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
    echo " ga terug naar <a href='login.php'> login </a>";
    exit;
}

require 'database.php';

$stmt = $conn->prepare("SELECT * FROM  tafels");
$stmt->execute();
// set the resulting array to associative
$tafels = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Store tafels data in session
$_SESSION['tafels'] = $tafels;
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
        <div class="tafel-container">
        <div class="table-wrapper">
        <table>
            <thead>
                <tr>
                    <th>id</th>
                    <th>tafelnummer</th>
                    <th>personen</th>       
                    <th>Acties</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($tafels as $tafel) : ?>
                    <tr>
                        <td><?php echo $tafel['tafel_id'] ?></td>
                        <td><?php echo $tafel['tafel_nummer'] ?></td>
                        <td><?php echo $tafel['aantal_personen'] ?></td>          
                        <td>
                          <a href="tafels_detail.php?id=<?php echo $tafel['tafel_id'] ?>">Bekijk</a>
                          <a href="tafels_edit.php?id=<?php echo $tafel['tafel_id'] ?>">Wijzig</a>
                          <a href="tafels_delete.php?id=<?php echo $tafel['tafel_id'] ?>">Verwijder</a>
                        </td>             
                    </tr> 
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    </div>
    </div>
</main>

</body>
</html>

.reserveringen-container .table-wrapper,
.producten-container .table-wrapper,
.categorie-container .table-wrapper,
.menugang-container .table-wrapper {
  min-height: 580px; /* Specific min-height for these pages */
}

.gebruikers-container .table-wrapper {
  min-height: 800px; /* Specific min-height for this page */
}

.tafel-container .table-wrapper {
  min-height: 600px; /* Specific min-height for this page */
}