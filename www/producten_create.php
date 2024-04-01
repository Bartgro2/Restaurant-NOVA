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


require 'database.php';


$sql = "SELECT * FROM categorieen";
$stmt = $conn->prepare($sql);
$stmt->execute();
$categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

$sql = "SELECT * FROM menugangen";
$stmt = $conn->prepare($sql);
$stmt->execute();
$menugangen = $stmt->fetchAll(PDO::FETCH_ASSOC);

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
<?php require 'nav.php'; ?>
    <main>
    <div class="container">
        <div class="product-container">
     
    <div class="account-pagina">
        
        <div class="form-panel">       
            <h1>Product maken</h1> <!-- Form title -->
            <hr class="separator"> <!-- Add horizontal line as a separator -->
            <form action="producten_create_process.php" method="POST" enctype="multipart/form-data">
                <div class="input-groep">
                    <label for="naam">Naam</label>
                    <input type="text" id="naam" name="naam">
                </div>
                <div class="input-groep">
                    <label for="beschrijving">Beschrijving</label>
                    <textarea name="beschrijving" id="beschrijving" cols="30" rows="10"></textarea>
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
                <div class="input-groep">
                    <label for="inkoopprijs">Inkoopprijs</label>
                    <input type="number" id="inkoopprijs" name="inkoopprijs">
                </div>
                <div class="input-groep">
                    <label for="verkoopprijs">Verkoopprijs</label>
                    <input type="number" id="verkoopprijs" name="verkoopprijs">
                </div>
                <div class="input-groep">
                    <label for="aantal_voorraad">Aantal voorraad</label>
                    <input type="number" id="aantal_voorraad" name="aantal_voorraad">
                </div>
                <div class="input-groep">
                    <label for="vega">Vegetarisch</label>
                    <input type="text" id="vega" name="vega">
                </div>
                <div class="input-groep">
                    <label for="image">Afbeelding</label>
                     <input type="file" name="image" id="image">
                </div>
                <div class="input-groep">
                    <button type="submit" class="input-button">Aanmaken</button>
                </div>
            </form>
        </div>
    </div>
</div>
</div>
</main>
<?php require 'footer.php'; ?>
</body>
</html>




