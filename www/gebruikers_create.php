<?php 

session_start();
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
        <div class="gebruikers-container">
            <div class="account-pagina">
                <div class="gebruikers-panel">
                    <div class="form-panel special-form-panel">
                        <h1>Registreren</h1>
                        <hr class="separator">
                        <form action="gebruikers_create_process.php" method="POST">
                            <div class="input-container">
                                <div class="input-groep">
                                    <input type="text" id="voornaam" name="voornaam" placeholder="Voornaam">
                                </div>
                                <div class="input-groep">
                                    <input type="text" id="achternaam" name="achternaam" placeholder="Achternaam">
                                </div>
                                <div class="input-groep">
                                    <input type="text" id="tussenvoegsel" name="tussenvoegsel" placeholder="Tussenvoegsel">
                                </div>
                            </div>
                            <div class="input-groep">
                                <input type="email" id="email" name="email" placeholder="Email">
                            </div>
                            <div class="input-groep">
                                <input type="text" id="gebruikersnaam" name="gebruikersnaam" placeholder="Gebruikersnaam">
                            </div>
                            <div class="special-container">
                                <div class="input-groep">
                                    <input type="password" id="wachtwoord" name="wachtwoord" placeholder="Wachtwoord">
                                </div>
                                <div class="input-groep">
                                    <input type="password" id="verzeker_wachtwoord" name="verzeker_wachtwoord" placeholder="Verzeker Wachtwoord">
                                </div>
                            </div>
                            <div class="input-groep">
                                <select id="role" name="role">
                                    <option value="">Selecteer Rol</option>
                                    <option value="admin">Admin</option>
                                    <option value="directeur">Directeur</option>
                                    <option value="manager">Manager</option>
                                    <option value="medewerker">Medewerker</option>
                                    <option value="klant">Klant</option>
                                </select>
                            </div>
                            <div class="input-groep">
                                <input type="text" id="woonplaats" name="woonplaats" placeholder="Woonplaats">
                            </div>
                            <div class="input-groep">
                                <input type="text" id="postcode" name="postcode" placeholder="Postcode">
                            </div>
                            <div class="input-groep">
                                <input type="number" id="huisnummer" name="huisnummer" placeholder="Huisnummer">
                            </div>
                            <div class="input-groep">
                                <button type="submit" class="input-button">Aanmaken</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>



    
<?php require 'footer.php'; ?>
</body>
</html>