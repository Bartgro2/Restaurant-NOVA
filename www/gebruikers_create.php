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
    <main>
    <div class="account-pagina">
        <div class="form-panel">       
            <h1>registeren</h1> 
            <hr class="separator">
            <form action="gebruikers_create_process.php" method="POST">
    <div class="input-groep">
        <label for="voornaam">Voornaam</label>
        <input type="text" id="voornaam" name="voornaam">
    </div>
    <div class="input-groep">
        <label for="achternaam">Achternaam</label>
        <input type="text" id="achternaam" name="achternaam">
    </div>
    <div class="input-groep">
        <label for="tussenvoegsel">Tussenvoegsel</label>
        <input type="text" id="tussenvoegsel" name="tussenvoegsel">
    </div>
    <div class="input-groep">
        <label for="email">Email</label>
        <input type="email" id="email" name="email">
    </div>
    <div class="input-groep">
        <label for="gebruikersnaam">Gebruikersnaam</label>
        <input type="text" id="gebruikersnaam" name="gebruikersnaam">
    </div>
    <div class="input-groep">
        <label for="wachtwoord">Wachtwoord</label>
        <input type="password" id="wachtwoord" name="wachtwoord">
    </div>
    <div class="input-groep">
        <label for="verzeker_wachtwoord">Verzeker Wachtwoord</label>
        <input type="password" id="verzeker_wachtwoord" name="verzeker_wachtwoord">
    </div>
    <div class="input-groep">
        <label for="role">Rol:</label>
        <select id="role" name="role">
            <option value="">Selecteer Rol</option>
            <option value="admin">Admin</option>
            <option value="medewerker">Medewerker</option>
            <option value="klant">Klant</option>
        </select>
    </div>
    <div class="input-groep">
        <label for="woonplaats">Woonplaats</label>
        <input type="text" id="woonplaats" name="woonplaats">
    </div>
    <div class="input-groep">
        <label for="postcode">Postcode</label>
        <input type="text" id="postcode" name="postcode">
    </div>
    <div class="input-groep">
        <label for="huisnummer">Huisnummer</label>
        <input type="number" id="huisnummer" name="huisnummer">
    </div>
    <div class="input-groep">
        <button type="submit" class="input-button">Aanmaken</button>
    </div>
</form>

        </div>
    </div>
</main>
</body>
</html>