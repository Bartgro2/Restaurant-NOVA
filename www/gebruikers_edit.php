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
        <div class="account-pagina">
            <div class="form-panel">       
                <h1>registeren</h1> 
                <hr class="separator">
                <form action="gebruikers_update.php?id=<?php echo $gebruiker_id ?>" method="POST">
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

                    <?php if ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'manager' || $_SESSION['role'] === 'directeur') { ?>
    <!-- Role dropdown only visible to admin, manager, and directeur -->
    <div class="input-groep">
        <label for="role">Rol:</label>
        <select id="role" name="role">
            <?php
              if ($_SESSION['role'] === 'admin') {
                // Admin can select any role
                echo "<option value='admin'>Admin</option>";
                echo "<option value='directeur'>Directeur</option>";
                echo "<option value='manager'>Manager</option>";
                echo "<option value='medewerker'>Medewerker</option>";
                echo "<option value='klant'>Klant</option>";
            } elseif ($_SESSION['role'] === 'manager') {
                // Manager can select only medewerker or klant
                echo "<option value='klant'>Klant</option>";
                echo "<option value='medewerker'>Medewerker</option>";
            } elseif ($_SESSION['role'] === 'directeur') {
                // Directeur can select any role except admin
                echo "<option value='manager'>Manager</option>";
                echo "<option value='medewerker'>Medewerker</option>";
                echo "<option value='klant'>Klant</option>";
            }?>
            
        </select>
    </div>
<?php } ?>


          
                    <div class="input-groep">
                        <label for="woonplaats">Woonplaats</label>              
                        <input type="text" id="woonplaats" name="woonplaats" value="<?php echo isset($adres['woonplaats']) ? $adres['woonplaats'] : ''; ?>">
                    
                    </div>
                    <div class="input-groep">
                        <label for="postcode">Postcode</label>              
                        <input type="text" id="postcode" name="postcode" value="<?php echo isset($adres['postcode']) ? $adres['postcode'] : ''; ?>">                
                    </div>
                    <div class="input-groep">
                         <label for="huisnummer">Huisnummer</label>
                         <input type="number" id="huisnummer" name="huisnummer" value="<?php echo isset($adres['huisnummer']) ? $adres['huisnummer'] : ''; ?>">  
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
