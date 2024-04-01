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
        <div class="product-container">
            <div class="table-wrapper"> 
                <div class="search-bar">
                    <div class="search-container">
                        <form action="/action_page.php">
                            <input type="text" class="test" placeholder="Search.." name="search">
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
                                <th>beschrijving</th>
                                <th>inkoopprijs</th>
                                <th>verkoopprijs</th>
                                <th>vega</th>
                                <th>aantal</th>
                                <th>Acties</th> 
                            </tr>
                        </thead>
                        <tbody>
                            <!-- Table body content here -->
                        </tbody>
                    </table>            
                </div>             
            </div>
        </div>
    </div>
</main>
<?php include 'footer.php' ?>
</body>
</html>




