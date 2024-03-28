<?php

session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'manager' && $_SESSION['role'] !== 'medewerker') {
    echo "You are not allowed to view this page, please login as admin, manager, or medewerker ";
    echo " login als een andere rol, hier <a href='login.php'> login </a>";
    exit;
}

require 'database.php';

$stmt = $conn->prepare("SELECT *, producten.naam as naam, menugangen.naam as menugang, categorieen.naam as categorie FROM producten 
JOIN categorieen ON categorieen.categorie_id = producten.categorie_id
JOIN menugangen ON menugangen.menugang_id = producten.menugang_id");
$stmt->execute();
// set the resulting array to associative
$producten = $stmt->fetchAll(PDO::FETCH_ASSOC);
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

    <div class="container">
        <main>
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>naam</th>
                        <th>menugang</th>
                        <th>categorie</th>
                        <th>beschrijving</th>
                        <th>inkoopprijs</th>
                        <th>verkoopprijs</th>
                        <th>vega</th>
                        <th>aantal</th>
                        <th>Acties</th> 
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($producten as $product) : ?>
                    <tr>
                        <td><?php echo $product['product_id'] ?></td>
                        <td><?php echo $product['naam'] ?></td>
                        <td><?php echo $product['menugang'] ?></td>
                        <td><?php echo $product['categorie'] ?></td>
                        <td><?php echo $product['beschrijving'] ?></td>
                        <td><?php echo $product['inkoopprijs'] ?></td>
                        <td><?php echo $product['verkoopprijs'] ?></td>
                        <td><?php echo $product['vega'] ?></td>
                        <td><?php echo $product['aantal_voorraad'] ?></td>
                        <!-- Geen Acties kolom omdat deze niet wordt geselecteerd in de query -->
                        <td>
                            <a href="producten_detail.php?id=<?php echo $product['product_id'] ?>">Bekijk</a>
                            <a href="producten_edit.php?id=<?php echo $product['product_id'] ?>">Wijzig</a>
                            <a href="producten_delete.php?id=<?php echo $product['product_id'] ?>">Verwijder</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
</body>
</html>



