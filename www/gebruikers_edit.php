<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if the request method is not GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo "You are not allowed to view this page ";
    echo " ga terug naar <a href='dashboard.php'> dashboard </a>";
    exit;
}

require 'database.php';

if (isset($_GET['id'])) {
    $gebruiker_id = $_GET['id'];
    
    // Prepare the SQL statement to fetch the user
    $sql = "SELECT * FROM gebruikers WHERE gebruiker_id = :gebruiker_id";
    $stmt = $conn->prepare($sql);
    $stmt->bindParam(":gebruiker_id", $gebruiker_id);
    
    // Execute the statement
    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            $gebruiker = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Fetch address details if available
            $sql = "SELECT * FROM adressen WHERE adres_id = :adres_id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(":adres_id", $gebruiker['adres_id']);
            
            if ($stmt->execute()) {
                $adres = $stmt->fetch(PDO::FETCH_ASSOC);
            } else {
                // Error in executing SQL statement for address
                echo "Error executing SQL statement for address";
                echo "<a href='dashboard.php'>Go back</a>";
                exit; // Exit to prevent further execution
            }
        } else {
            // No user found with the given ID
            echo "No user found with this ID <br>";
            echo "<a href='dashboard.php'>Go back</a>";
            exit; // Exit to prevent further execution
        }
    } else {
        // Error in executing SQL statement for user
        echo "Error executing SQL statement for user";
        echo "<a href='dashboard.php'>Go back</a>";
        exit; // Exit to prevent further execution
    }
} else {
    // Redirect to dashboard.php if ID parameter is not set
    header("Location: dashboard.php");
    exit; // Exit to prevent further execution
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
    <div class="container">
        <div class="gebruikers-container">
            <div class="account-pagina">
                <div class="gebruikers-panel">
                    <div class="form-panel special-form-panel">
                        <h1>Bijwerken</h1>
                        <hr class="separator">
                        <form action="gebruikers_update.php" method="POST">
                            <div class="input-container">
                                <div class="input-groep">
                                    <input type="text" id="voornaam" name="voornaam" placeholder="Voornaam" value="<?php echo ($gebruiker['voornaam']); ?>">
                                </div>
                                <div class="input-groep">
                                    <input type="text" id="tussenvoegsel" name="tussenvoegsel" placeholder="Tussenvoegsel" value="<?php echo ($gebruiker['tussenvoegsel']); ?>">                                    
                                </div>
                                <div class="input-groep">
                                    <input type="text" id="achternaam" name="achternaam" placeholder="Achternaam" value="<?php echo ($gebruiker['achternaam']); ?>">
                                </div>
                            </div>
                            <div class="input-groep">
                                <input type="email" id="email" name="email" placeholder="Email" value="<?php echo isset($gebruiker['email']) ? $gebruiker['email'] : ''; ?>">
                            </div>
                            <div class="input-groep">
                                <input type="text" id="gebruikersnaam" name="gebruikersnaam" placeholder="Gebruikersnaam" value="<?php echo ($gebruiker['gebruikersnaam']);?>">
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
    <select id="rol" name="rol">
        <?php 
        if ($_SESSION['role'] === 'admin') {
            $allowed_roles = ['admin', 'directeur', 'manager', 'medewerker', 'klant'];
        } elseif ($_SESSION['role'] === 'directeur') {
            $allowed_roles = ['directeur', 'manager', 'medewerker', 'klant'];
        } elseif ($_SESSION['role'] === 'manager') {
            $allowed_roles = ['manager', 'medewerker', 'klant'];
        } else {
            $allowed_roles = ['klant'];
        }
        
        foreach ($allowed_roles as $role) {
            echo "<option value='$role'" . ($gebruiker['rol'] === $role ? ' selected' : '') . ">$role</option>";
        }
        ?>
    </select>
</div>


                            <div class="input-container">
                                <div class="input-groep">
                                    <input type="text" id="woonplaats" name="woonplaats" placeholder="Woonplaats" value="<?php echo ($adres !== false && isset($adres['woonplaats'])) ? $adres['woonplaats'] : ''; ?>">
                                </div>
                                <div class="input-groep">
                                    <input type="number" id="huisnummer" name="huisnummer" placeholder="Huisnummer" value="<?php echo isset($adres['huisnummer']) ? $adres['huisnummer'] : ''; ?>">
                                </div>
                                <div class="input-groep">
                                    <input type="text" id="postcode" name="postcode" placeholder="postcode" value="<?php echo isset($adres['postcode']) ? $adres['postcode'] : ''; ?>">
                                </div>
                            </div>
                            <div class="input-groep">
                                <button type="submit" class="input-button">Aanpassen</button>
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