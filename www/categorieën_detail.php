<?php
session_start();

require 'database.php';
require 'footer.php';
require 'nav.php';

if (isset($_GET['id'])) {
    $categorie_id = $_GET['id'];

    
  $stmt = $conn->prepare("SELECT * FROM categorieen WHERE categorie_id = :categorie_id");
  $stmt->bindParam(':categorie_id', $categorie_id);
  $stmt->execute();
  $categorie = $stmt->fetch(PDO::FETCH_ASSOC);
    
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
        <?php if (isset($categorie)) : ?>          
                        <p><?php echo $categorie['naam'] ?></p> <!-- Corrected variable name --> 
        <?php else : ?>
            <p>categorie not found.</p>
        <?php endif; ?>
    </div>
</main>
</body>
</html>



