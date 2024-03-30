<?php 
session_start();

require 'database.php';

// Retrieve table data
$sql = "SELECT * FROM tafels";
$stmt = $conn->prepare($sql);
$stmt->execute();
$tafels = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
<?php require 'nav.php' ?>
<main>
       <?php if (isset($_SESSION['role']) && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'manager' || $_SESSION['role'] === 'medewerker')) { ?>
        <div class="account-pagina">
        <?php } else { ?>
        <div class="account-pagina2">
         <?php } ?>

        <div class="form-panel">    
            <h1>reserveren</h1> <!-- Form title -->
            <hr class="separator"> <!-- Add horizontal line as a separator -->
            <form action="reserveringen_create_process.php" method="POST">
            <?php   
            if (isset($_SESSION['role']) && ($_SESSION['role'] === 'admin' || $_SESSION['role'] === 'manager' || $_SESSION['role'] === 'medewerker')) {
            ?>
                <div class="input-groep">
                    <label for="voornaam">Voornaam</label>
                    <input type="text" id="voornaam" name="voornaam">
                </div>
                <div class="input-groep">
                    <label for="tussenvoegsel">Tussenvoegsel</label>
                    <input type="text" id="tussenvoegsel" name="tussenvoegsel">
                </div>
                <div class="input-groep">
                    <label for="achternaam">Achternaam</label>
                    <input type="text" id="achternaam" name="achternaam">
                </div>
                <div class="input-groep">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email">
                </div>
                <div class="input-groep">
                    <label for="datum">Datum</label>
                    <input type="date" name="datum" id="datum">
                </div>
                <div class="input-groep">
                    <label for="tijd">Tijd</label>
                    <input type="time" name="tijd" id="tijd">
                </div>
                <div class="input-groep">
                    <label class="input-label" for="tafel_nummer">Tafel</label>
                    <select name="tafel_id" id="tafel_id">
                        <?php foreach($tafels as $table): ?>
                            <option value="<?php echo $table['tafel_id']; ?>">
                                Tafel <?php echo $table['tafel_nummer']; ?> - <?php echo $table['aantal_personen']; ?> personen
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="input-groep">
                    <button type="submit" class="input-button">Bewerken</button>
                </div>
            <?php
            } else { // For guests or customers
            ?>
                <div class="input-groep">
                    <label for="voornaam">Voornaam</label>
                    <input type="text" name="voornaam" id="voornaam">
                </div>
                <div class="input-groep">
                    <label for="tussenvoegsel">Tussenvoegsel</label>
                    <input type="text" name="tussenvoegsel" id="tussenvoegsel">   
                </div>
                <div class="input-groep">
                    <label for="achternaam">Achternaam</label>
                    <input type="text" name="achternaam" id="achternaam">
                </div>
                <div class="input-groep">
                    <label for="email">Email</label>
                    <input type="email" name="email" id="email">
                </div>
                <div class="input-groep">
                    <label for="datum">Datum</label>
                    <input type="date" name="datum" id="datum">
                </div>
                <div class="input-groep">
                    <label for="tijd">Tijd</label>
                    <input type="time" name="tijd" id="tijd">
                </div>
                <div class="input-groep">
                    <button type="submit" class="input-button">Bevestig</button>
                </div> 
            <?php
            }
            ?>
            </form>
        </div>
    </div>
</main>
<?php require 'footer.php' ?>
</body>
</html>
