<?php
require 'database.php';

session_start();

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

if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Prepare the SQL statement to fetch the product
    $sql = "SELECT * FROM producten WHERE product_id = :product_id";
    $stmt = $conn->prepare($sql);

    // bind the param
    $stmt->bindParam(":product_id", $product_id);

    // Execute the statement
    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {

            $product = $stmt->fetch(PDO::FETCH_ASSOC);
            
            $sql = "SELECT * FROM categorieen";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            $sql = "SELECT * FROM menugangen";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $menugangen = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } else {
            // No product found with the given ID
            echo "No product found with this ID <br>";
            echo "<a href='prodocuten_index.php'>Go back</a>";
            exit; // You may want to exit here to prevent further execution
        }
    } else {
        // Error in executing SQL statement
        echo "Error executing SQL statement";
        echo "<a href='producten_index.php'>Ga terug</a>";
        exit; // Exit to prevent further execution
    }
} else {
    // Redirect to menugang_index.php if ID parameter is not set
    header("Location: producten_index.php");
    exit; // Exit to prevent further execution
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
<?php require 'nav.php' ?>
<main>
    <div class="container">
        <div class="account-pagina">
            <div class="form-panel">    
                <h1>categorie bijwerken</h1> <!-- Form title -->
                <hr class="separator"> <!-- Add horizontal line as a separator -->
                <form action="producten_update.php?id=<?php echo $product_id ?>" method="POST">
                    <div class="input-groep">
                        <label for="naam">Naam</label>
                        <input type="text" id="naam" name="naam" value="<?php echo $product['naam'] ?>">
                    </div>
                    <div class="input-groep">
                        <label for="beschrijving">Beschrijving</label>
                        <textarea name="beschrijving" id="beschrijving" cols="30" rows="10"><?php echo $product['beschrijving'] ?></textarea>
                    </div>
                    <div class="input-groep">
                        <label for="categorie">Categorie</label>
                        <select name="categorie" id="categorie">
                            <?php foreach($categories as $categorie):?>
                                <option value="<?php echo $categorie['categorie_id']; ?>"><?php echo $categorie['naam']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="input-groep">
                        <label for="menugang">Menugang</label>
                        <select name="menugang" id="menugang">
                            <?php foreach($menugangen as $menugang):?>
                                <option value="<?php echo $menugang['menugang_id']; ?>"><?php echo $menugang['naam']; ?></option>
                            <?php endforeach ?>
                        </select>
                    </div>
                    <div class="input-container">
                        <div class="input-groep">
                            <label for="inkoopprijs">Inkoopprijs</label>
                            <input type="number" id="inkoopprijs" name="inkoopprijs" value="<?php echo $product['inkoopprijs'] ?>">
                        </div>
                        <div class="input-groep">
                            <label for="verkoopprijs">Verkoopprijs</label>
                            <input type="number" id="verkoopprijs" name="verkoopprijs" value="<?php echo $product['inkoopprijs'] ?>">
                        </div>
                    </div>
                    <div class="input-groep">
                        <label for="aantal_voorraad">Aantal voorraad</label>
                        <input type="number" id="aantal_voorraad" name="aantal_voorraad" value="<?php echo $product['aantal_voorraad'] ?>">
                    </div>
                    <div class="input-groep">
                        <label for="vega">Vegetarisch</label>
                        <input type="number" id="vega" name="vega" value="<?php echo $product['vega'] ?>">
                    </div>
                    <div class="input-groep">
                        <label for="image">Afbeelding</label>
                        <input type="file" name="image" id="image">
                    </div>
                    <div class="input-groep">
                        <button type="submit" class="input-button">bewerken</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</main>
<?php require 'footer.php' ?>
</body>
</html>

