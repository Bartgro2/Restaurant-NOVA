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
    echo " ga terug naar <a href='producten_index.php'> producten </a>";
    exit;
}

require 'database.php';

$stmt = $conn->prepare("SELECT *, producten.naam as naam, menugangen.naam as menugang, categorieen.naam as categorie FROM producten 
JOIN categorieen ON categorieen.categorie_id = producten.categorie_id
JOIN menugangen ON menugangen.menugang_id = producten.menugang_id");
$stmt->execute();
// set the resulting array to associative
$producten = $stmt->fetchAll(PDO::FETCH_ASSOC);


if (isset($_GET['submit'])) {

    $zoekterm = $_GET['zoekveld'];

    if (empty($zoekterm)) {
        header("location: producten_index.php");
        exit;
    }

    // Prepare the SQL query with placeholders to prevent SQL injection
    $sql = "SELECT *, producten.naam as naam, menugangen.naam as menugang, categorieen.naam as categorie FROM producten
            JOIN categorieen ON categorieen.categorie_id = producten.categorie_id
            JOIN menugangen ON menugangen.menugang_id = producten.menugang_id  WHERE menugang LIKE :search OR categorie LIKE :search OR vega LIKE :search OR inkooprijs LIKE :search OR verkoopprijs LIKE :search OR aantal_voorraad LIKE :search";

    $stmt = $conn->prepare($sql);

    // Bind parameters
    $searchTerm = '%' . $_GET['search'] . '%'; // Add wildcards to search for partial matches
    $stmt->bindParam(':search', $searchTerm, PDO::PARAM_STR);

// Execute the statement
$stmt->execute();
}
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
<?php include 'nav.php' ?>   
<main>
    <div class="container">
        <div class="producten-container">
            <div class="table-wrapper"> 
                <div class="search-bar">
                    <div class="search-container">
                        <form action="producten_index.php">
                            <input type="text"  placeholder="Search.." name="search">
                            <button type="submit"><i class="fas fa-search"></i> </button>
                        </form>
                    </div>
                </div>
                
                <div class="product-tabel">
                    <table>
                        <thead>
                            <tr>
                                <th>id</th>
                                <th>naam</th>
                                <th>menugang</th>
                                <th>categorie</th>
                                <th>inkoopprijs</th>
                                <th>verkoopprijs</th>
                                <th>vega</th>
                                <th>beschrijving</th>
                                <th>aantal</th>     
                                <th>Acties</th> 
                            </tr>
                        </thead>
                        <tbody>
                        <?php foreach ($producten as $product): ?>
    <tr>
        <td><?php echo $product['product_id']; ?></td>
        <td><?php echo $product['naam']; ?></td>
        <td><?php echo $product['menugang']; ?></td>
        <td><?php echo $product['categorie']; ?></td>
        <td><?php echo $product['inkoopprijs']; ?></td>
        <td><?php echo $product['verkoopprijs']; ?></td>
        <td><?php echo $product['vega']; ?></td>
        <td class="description-cell"><?php echo $product['beschrijving'] ?></td>
        <td><?php echo $product['aantal_voorraad']; ?></td>
        <td>
            <a href="producten_detail.php?id=<?php echo $product['product_id']; ?>">Bekijk</a>
            <a href="producten_edit.php?id=<?php echo $product['product_id']; ?>">Wijzig</a>
            <a href="producten_delete.php?id=<?php echo $product['product_id']; ?>">Verwijder</a>
        </td>
    </tr>
<?php endforeach; ?>

                        </tbody>
                    </table>            
                </div>             
            </div>
        </div>
    </div>
</main>
<?php include 'footer.php' ?>
</body>
</body>
</html>




