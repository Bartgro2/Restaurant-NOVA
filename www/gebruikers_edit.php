<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if role is not admin, manager, or medewerker
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'manager' && $_SESSION['role'] !== 'medewerker') {
    echo "You are not allowed to view this page, please login as admin, manager, or medewerker ";
    echo " login als een andere rol, hier <a href='login.php'> login </a>";
    exit;
}

// Check if the request method is not GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo "You are not allowed to view this page ";
    echo " ga terug naar <a href='gebruikers_index.php'> gebruikers </a>";
    exit;
}

require 'database.php';

if (isset($_GET['id']) && isset($_GET['adres_id'])) {
    $gebruiker_id = $_GET['id']; // Corrected
    
    // Query to retrieve user records based on gebruiker_id
    $sql = "SELECT * FROM gebruikers WHERE gebruiker_id = :id";

    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":id", $gebruiker_id);
    
    if ($stmt->execute()) {
        // Check if there are any results
        if ($stmt->rowCount() > 0) {
            // If results exist, fetch the user data
            $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            // No user found with the specified gebruiker_id
            echo "No user found with this ID <br>";
            echo "<a href='gebruikers_index.php'>Go back</a>";
            exit;
        }
    } else {
        // Error executing the SQL statement
        echo "Error executing SQL statement";
        exit;
    }

    // Query to retrieve address based on adres_id
    $sql = "SELECT * FROM adressen";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":adres_id", $adres_id);
    
    if ($stmt->execute()) {
        // Check if there are any results
        if ($stmt->rowCount() > 0) {
            // If results exist, fetch the address data
            $adres = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            // No address found for the user
            echo "No address found for this user";
            exit;
        }
    } else {
        // Error executing the SQL statement
        echo "Error executing SQL statement";
        exit;
    }
} else {
    // ID not provided in the request
    echo "No ID provided in the request";
    exit;
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
    <?php require 'nav.php'; ?>
    <main>
        <div class="account-pagina">
            <div class="form-panel">       
                <h1>registeren</h1> 
                <hr class="separator">
                <form action="menugang_update.php?id=<?php echo $gebruiker_id ?>" method="POST">
                
                


                    <div class="input-groep"> 
                        <label for="voornaam">Voornaam</label>
                        <input type="text" id="voornaam" name="voornaam" value="<?php echo $gebruiker['voornaam'] ?>">
                    </div>
                    <div class="input-groep">
                        <label for="tussenvoegsel">Tussenvoegsel</label>
                        <input type="text" id="tussenvoegsel" name="tussenvoegsel" value="<?php echo $gebruiker['tussenvoegsel'] ?>">
                    </div>
                    <div class="input-groep">
                        <label for="achternaam">Achternaam</label>
                        <input type="text" id="achternaam" name="achternaam" value="<?php echo $gebruiker['achternaam'] ?>">
                    </div>
                    <div class="input-groep">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" value="<?php echo $gebruiker['email'] ?>">
                    </div>
                    <div class="input-groep">
                        <label for="gebruikersnaam">Gebruikersnaam</label>
                        <input type="text" id="gebruikersnaam" name="gebruikersnaam" value="<?php echo $gebruiker['gebruikersnaam'] ?>">
                    </div>
                    <div class="input-groep">
                        <label for="wachtwoord">Wachtwoord</label>
                        <input type="password" id="wachtwoord" name="wachtwoord" value="<?php echo $gebruiker['wachtwoord'] ?>">
                    </div>
                    <div class="input-groep">
                        <label for="verzeker_wachtwoord">Verzeker Wachtwoord</label>
                        <input type="password" id="verzeker_wachtwoord" name="verzeker_wachtwoord" value="<?php echo $gebruiker['wachtwoord'] ?>">
                    </div>
                    <div class="input-groep">
                        <label for="role">Rol:</label>
                        <select id="role" name="role">
                            <option value="admin" <?php echo ($_SESSION['role'] === 'admin') ? 'selected' : ''; ?>>Admin</option>
                            <option value="manager" <?php echo ($_SESSION['role'] === 'manager') ? 'selected' : ''; ?>>Manager</option>
                            <option value="medewerker" <?php echo ($_SESSION['role'] === 'medewerker') ? 'selected' : ''; ?>>Medewerker</option>
                            <option value="klant" <?php echo ($_SESSION['role'] === 'klant') ? 'selected' : ''; ?>>Klant</option>
                        </select>
                    </div>
                    <div class="input-groep">
                        <label for="woonplaats">Woonplaats</label>
                        <input type="text" id="woonplaats" name="woonplaats" value="<?php echo $adres['woonplaats'] ?>">
                    </div>
                    <div class="input-groep">
                        <label for="postcode">Postcode</label>
                        <input type="text" id="postcode" name="postcode" value="<?php echo $adres['postcode']; ?>">

                    </div>
                    <div class="input-groep">
                        <label for="huisnummer">Huisnummer</label>
                        <input type="number" id="huisnummer" name="huisnummer" value="<?php echo $adres['huisnummer'] ?>">
                    </div>
                    <div class="input-groep">
                        <button type="submit" class="input-button">Aanmaken</button>
                    </div>
                </form>
            </div>
        </div>
    </main>
    <?php require 'footer.php'; ?>
</body>
</html>



