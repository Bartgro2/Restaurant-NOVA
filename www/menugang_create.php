<?php


require 'database.php';
require 'nav.php';
require 'footer.php';

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
    
</body>
</html>
<main>
    <div class="account-pagina2">
        <div class="form-panel">    
            <h1>menugang maken</h1> <!-- Form title -->
            <hr class="separator"> <!-- Add horizontal line as a separator -->
            <form action="menugang_create_process.php" method="POST">
                    <div class="input-groep">
                        <label for="naam">naam</label>
                        <input type="text" id="naam" name="naam">
                    </div>
                    <div class="input-groep">
                        <button type="submit" class="input-button"> aanmaken </button>
                    </div> 
            </form>
        </div>
    </div>
</main>