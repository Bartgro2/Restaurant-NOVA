<?php

session_start();

require 'database.php';

// Fetch starters
$sql = "SELECT *, menugangen.naam as menugang, producten.naam as menu_naam  FROM producten
        JOIN menugangen on menugangen.menugang_id = producten.menugang_id where menugangen.naam = 'voorgerecht'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$menu_starters = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch main courses
$sql = "SELECT *, menugangen.naam as menugang, producten.naam as menu_naam  FROM producten
        JOIN menugangen on menugangen.menugang_id = producten.menugang_id where menugangen.naam = 'hoofdgerecht'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$menu_main_courses = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch desserts
$sql = "SELECT *, menugangen.naam as menugang, producten.naam as menu_naam  FROM producten
        JOIN menugangen on menugangen.menugang_id = producten.menugang_id where menugangen.naam = 'dessert'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$menu_desserts = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch nagerechten
$sql = "SELECT *, menugangen.naam as menugang, producten.naam as menu_naam  FROM producten
        JOIN menugangen on menugangen.menugang_id = producten.menugang_id where menugangen.naam = 'nagerecht'";
$stmt = $conn->prepare($sql);
$stmt->execute();
$menu_nagerechten = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Fetch categories
$sql = "SELECT * from categorieen";
$stmt = $conn->prepare($sql);
$stmt->execute();
$menu_categorie = $stmt->fetch(PDO::FETCH_ASSOC);

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
        <div class="menu-card">
            <div class="container">
                <!-- Voorgerechten -->
                <div class="category">Voorgerechten</div>
                <div class="menu-container">
                    <div class="menu-wrapper">
                        <?php foreach($menu_starters as $menu_item):?>
                            <!-- Menu Item -->
                            <div class="menu-item">
                                <!-- Menu Item Image -->
                                <?php if(isset($menu_item['image'])): ?>
                                    <div class="menu-img">
                                        <img src="<?php echo isset($menu_item['image']) ? 'images/' . $menu_item['image'] : 'images/food.png'; ?>" 
                                             alt="food" 
                                             style="width:100%"
                                             onerror="this.onerror=null; this.src='https://placehold.co/200';" />
                                    </div>
                                <?php endif; ?>
                                <!-- Menu Item Details -->
                                <div class="menu-details">
                                    <div class="menu-item-name">
                                        <p><?php echo $menu_item['menu_naam']?></p>
                                    </div>
                                    <div class="menu-price">
                                        <p>Prijs: € <?php echo $menu_item['verkoopprijs']?></p>
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
                
                <!-- Hoofdgerechten -->
                <div class="category">Hoofdgerechten</div>
                <div class="menu-container">
                    <div class="menu-wrapper">
                        <?php foreach($menu_main_courses as $menu_item):?>
                            <!-- Menu Item -->
                            <div class="menu-item">
                                <!-- Menu Item Image -->
                                <?php if(isset($menu_item['image'])): ?>
                                    <div class="menu-img">
                                        <img src="<?php echo isset($menu_item['image']) ? 'images/' . $menu_item['image'] : 'images/food.png'; ?>" 
                                             alt="food" 
                                             style="width:100%"
                                             onerror="this.onerror=null; this.src='https://placehold.co/200';" />
                                    </div>
                                <?php endif; ?>
                                <!-- Menu Item Details -->
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
                
                <!-- Desserts -->
                <div class="category">Desserts</div>
                <div class="menu-container">
                    <div class="menu-wrapper">
                        <?php foreach($menu_desserts as $menu_item):?>
                            <!-- Menu Item -->
                            <div class="menu-item">
                                <!-- Menu Item Image -->
                                <?php if(isset($menu_item['image'])): ?>
                                    <div class="menu-img">
                                        <img src="<?php echo isset($menu_item['image']) ? 'images/' . $menu_item['image'] : 'images/food.png'; ?>" 
                                             alt="food" 
                                             style="width:100%"
                                             onerror="this.onerror=null; this.src='https://placehold.co/200';" />
                                    </div>
                                <?php endif; ?>
                                <!-- Menu Item Details -->
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
                
                <!-- Nagerechten -->
                <div class="category">Nagerechten</div>
                <div class="menu-container">
                    <div class="menu-wrapper">
                        <?php foreach($menu_nagerechten as $menu_item):?>
                            <!-- Menu Item -->
                            <div class="menu-item">
                                <!-- Menu Item Image -->
                                <?php if(isset($menu_item['image'])): ?>
                                    <div class="menu-img">
                                        <img src="<?php echo isset($menu_item['image']) ? 'images/' . $menu_item['image'] : 'images/food.png'; ?>" 
                                             alt="food" 
                                             style="width:100%"
                                             onerror="this.onerror=null; this.src='https://placehold.co/200';" />
                                    </div>
                                <?php endif; ?>
                                <!-- Menu Item Details -->
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
        </div>
    </main>

    <?php require 'footer.php' ?>
</body>
</html>


