<?php

require 'nav.php';
require 'footer.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <title>Login</title>
</head>
<body>
   <main>
    <div class="account-pagina2">
        <div class="form-panel">    
            <h1>Login</h1> <!-- Form title -->
            <hr class="separator"> <!-- Add horizontal line as a separator -->
            <form action="login_process.php" method="POST">
                <div class="input-groep">
                    <label for="email">Email</label>
                    <input type="text" id="email" name="email">
                </div>
                <div class="input-groep">
                    <label for="wachtwoord">Password</label>
                    <input type="password" id="wachtwoord" name="wachtwoord">
                </div>
                <div class="input-groep">
                    <button type="submit" class="input-button">Login</button>
                </div> 
            </form>
        </div>
    </div>
   </main>
</body>
</html>
