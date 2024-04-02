
<?php



require 'database.php';

$sql = "SELECT *, menugangen.naam as menugang, categorieen.naam as categorie, producten.naam as menu_naam  FROM producten
        JOIN menugangen on menugangen.menugang_id = producten.menugang_id
        JOIN categorieen on categorieen.categorie_id = producten.categorie_id";
$stmt = $conn->prepare($sql);
$stmt->execute();
$menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title></title>
</head>
<body>
    <?php require 'nav.php' ?>
    <main>
        <div class="container">
            <div class="menu-container">
                <div class="menu-wrapper">
                    <?php foreach($menu_items as $menu_item):?>
                    <div class="menu-item">
                        <?php if(isset($menu_item['image'])): ?>
                            <div class="menu-img">
                            <img src="<?php echo isset($menu_item['image']) ? 'images/' . $menu_item['image'] : 'images/food.png'; ?>" 
             alt="food" 
             style="width:100%"
             onerror="this.onerror=null; this.src='https://placehold.co/200';" />
                            </div>
                        <?php endif; ?>
                        <div class="menu-details">
                            <div class="menu-item-name">
                                <p><?php echo $menu_item['menu_naam']?></p>
                            </div>
                            <div class="menu-price">
                                <p>Price: € <?php echo $menu_item['verkoopprijs']?></p>
                            </div>
                            <div class="menu-vega">
                                <?php if($menu_item['vega'] == '0'): ?>
                                    <i class="fas fa-leaf"></i> <!-- Leaf icon -->
                                <?php else: ?>
                                     <p> niet vegan </p>
                                <?php endif; ?>
                            </div>
                            <div class="menu-description">
                                <p><?php echo $menu_item['beschrijving']?></p>
                            </div>
                        </div>
                    </div>
                    <?php endforeach ?>
                </div>
            </div>
        </div>
    </main>
    <?php require 'footer.php' ?>
</body>
</html>


