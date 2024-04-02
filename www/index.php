<?php

session_start();

require 'database.php';

$stmt = $conn->prepare("SELECT image FROM producten");
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="css/style.css">
</head>

<body>
    <?php include 'nav.php' ?>
    <?php include 'footer.php' ?>
    <main>
    
        <div class="hero-image" style="background-image: url( : 'https://placehold.co/200');">
                <div class="hero-text">
                    <h1>Over ons</h1>
                </div>
            </div>
        </div>
        
        <section class="restuarant-about">  
            <p>"Australian Delights" is gelegen in Alkmaar en opende haar deuren in 2022.</p>
<p>Wij bieden een eigentijdse benadering van de Australische keuken, waarbij we de diverse smaken van Australië combineren met invloeden uit Europa, Azië en de Middellandse Zee.</p>
<p>Bij ons kunt u niet alleen genieten van heerlijke gerechten, maar ook ontspannen op ons terras onder het genot van een verfrissend drankje.</p>
<p>We streven ernaar om een gastvrije omgeving te creëren waar iedereen zich thuis voelt.</p>
        </section>
            <div class="white-section-container">
            
            <button type="button">reservering</button>
            <button type="button">menu</button>
            </div>         
      
</main>
</body>

</html>
