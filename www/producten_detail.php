<?php


require 'database.php';
require 'footer.php';
require 'nav.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT *, menugangen.naam as menugang, categorieen.naam as categorie, producten.naam as naam FROM producten
    JOIN menugangen ON producten.menugang_id = menugangen.menugang_id
    JOIN categorieen ON producten.categorie_id = categorieen.categorie_id
    WHERE producten.product_id = :product_id");
    $stmt->bindParam(':product_id', $product_id); // Bind the product_id parameter
    $stmt->execute();
    $product = $stmt->fetch(PDO::FETCH_ASSOC);
}
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
    <main>
        <div class="container">
            <?php if (isset($product)) : ?>          
                <p><?php echo $product['menugang'] ?></p>
                <p><?php echo $product['categorie'] ?></p>
                <!-- Display other product details here -->
            <?php else : ?>
                <p>Product not found.</p>
            <?php endif; ?>
        </div>
    </main>
</body>
</html>




