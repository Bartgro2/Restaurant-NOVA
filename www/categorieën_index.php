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
    echo " ga terug naar het <a href='dashboard.php'> dashboard </a>";
    exit;
}

require 'database.php';


$stmt = $conn->prepare("SELECT * FROM categorieen");
$stmt->execute();
// set the resulting array to associative
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);


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
                <div class="categorie-container">
                <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>naam</th>
                        <th>Acties</th> 
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($categories as $categorie) : ?>
                    <tr>
                        <td> <?php echo $categorie['categorie_id'] ?></td>
                        <td> <?php echo $categorie['naam'] ?></td>
                        <td> 
                            <a href="categorieën_detail.php?id=<?php echo $categorie['categorie_id'] ?>">Bekijk</a>
                            <a href="categorieën_edit.php?id=<?php echo $categorie['categorie_id'] ?>">Wijzig</a>
                            <a href="categorieën_delete.php?id=<?php echo $categorie['categorie_id'] ?>">Verwijder</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
    </div>
    </div>
<?php include 'footer.php' ?> 
</body>
</html>


