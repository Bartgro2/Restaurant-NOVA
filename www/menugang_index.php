<?php
require 'database.php';

$stmt = $conn->prepare("SELECT menugang_id, naam FROM menugangen");
$stmt->execute();
// set the resulting array to associative
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
    <?php include 'nav.php' ?>
    <?php include 'footer.php' ?>


    
        <main>
            <div class="container">
            <table>
                <thead>
                    <tr>
                        <th>id</th>
                        <th>naam</th>
                        <th>Acties</th> 
                    </tr>
                </thead>
                <tbody>
                <?php foreach ($menugangen as $menugang) : ?>
                    <tr>
                        <td><?php echo $menugang['menugang_id'] ?></td>
                        <td><?php echo $menugang['naam'] ?></td>
                        <td>
                            <a href="menugang_detail.php?id=<?php echo $menugang['menugang_id'] ?>">Bekijk</a>
                            <a href="menugang_edit.php?id=<?php echo $menugang['menugang_id'] ?>">Wijzig</a>
                            <a href="menugang_delete.php?id=<?php echo $menugang['menugang_id'] ?>">Verwijder</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
                </tbody>
            </table>
        </div>
        </main>
    
</body>
</html>


