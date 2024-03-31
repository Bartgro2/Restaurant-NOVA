<?php
ob_start(); // Start output buffering

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


require 'database.php';

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    $stmt = $conn->prepare("SELECT *, menugangen.naam as menugang, categorieen.naam as categorie, producten.naam as naam FROM producten
    JOIN menugangen ON producten.menugang_id = menugangen.menugang_id
    JOIN categorieen ON producten.categorie_id = categorieen.categorie_id
    WHERE producten.product_id = :product_id");
    $stmt->bindParam(':product_id', $product_id); // Bind the product_id parameter
    $stmt->execute();

    if ($stmt->rowCount() > 0) {
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
    } else {
        // No product found with the given ID
        echo "No prodoct found with this ID <br>";
        echo "<a href='producten_index.php'>Ga terug</a>";
        exit;
    }
} else {
    // Redirect to producten_index.php if ID parameter is not set
    header("Location: producten_index.php");
    exit;
}
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Pacifico&family=Open+Sans&family=Cabin&family=Oswald&family=Nunito&family=Roboto+Condensed&display=swap">


    <title>Document</title>
</head>
<body>
<?php require 'nav.php'; ?>
<main>
    <div class="container">
        <div class="card">
            <?php if (isset($product)) : ?> 
                <div class="card_container">
                    <img src="<?php echo $product['image'] ?>" alt="Product Image" style="width:100%">

                    <div class="empty-space"></div> <!-- Add empty space -->
                </div>
                <div class="card_container">
                    <section class="card-section">
                        <div class="card-inner">
                            <h1 class="product-name"><?php echo $product['naam'] ?></h1>
                         
                        <p class="category"><?php echo $product['menugang'] ?></p>
                       
                        <?php if ($product['vega'] == 0) : ?>
                            <i class="fas fa-carrot"></i>
                        <?php endif; ?> 
                        </div>
                        </section>
                    <div class="empty-space"></div>
                    <div class="card-section">
                        <div class="card-inner2"></div>
                        <p class="price">Inkoopprijs: € <?php echo $product['inkoopprijs'] ?></p>
                        <div class="empty-space"></div>
                        <p class="price">Verkoopprijs: € <?php echo $product['verkoopprijs'] ?></p>

                        <p class="stock">Aantal voorraad: <?php echo $product['aantal_voorraad'] ?></p>
                    </div></div>
                    <div class="empty-space"></div>
                    <section class="card-section">
                        <div class="product_beschrijving">
                            <p class="description"><?php echo $product['beschrijving'] ?></p>
                        </div>
                        </section>
                </div>
            <?php else : ?>
                <p>Product not found.</p>
            <?php endif; ?>
        </div>
    </div>
</main>


 <?php require 'footer.php'; ?>
</body>
</html>

<?php ob_end_flush(); // End output buffering and flush the buffer ?>




