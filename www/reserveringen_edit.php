<?php
session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if role is not admin, directeur, manager, or medewerker
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'directeur' && $_SESSION['role'] !== 'manager' && $_SESSION['role'] !== 'medewerker') {
    echo "You are not authorized to view this page. Please log in with appropriate credentials. ";
    echo "Log in with a different role <a href='login.php'>here</a>.";
    exit;
}

// Check if the request method is not GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo "You are not allowed to view this page ";
    echo " ga terug naar <a href='reserveringen_index.php'> reserveringen </a>";
    exit;
}

require 'database.php';

if (isset($_GET['id'])) {
    $reservering_id = $_GET['id'];

    // Prepare the SQL statement to fetch the reservering
    $sql = "SELECT * FROM reserveringen
    JOIN gebruikers ON gebruikers.gebruiker_id = reserveringen.gebruiker_id
    WHERE reserveringen.reservering_id = :reservering_id"; // Specify the WHERE clause
    $stmt = $conn->prepare($sql); // Prepare the SQL statement

    // bind the parameter
    $stmt->bindParam(":reservering_id", $reservering_id);

    // Execute the statement
    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {

            $reservering = $stmt->fetch(PDO::FETCH_ASSOC);

            $sql = "SELECT * FROM tafels";
            $stmt = $conn->prepare($sql);
            $stmt->execute();
            $tafels = $stmt->fetchAll(PDO::FETCH_ASSOC);

        } else {
            // No reservering found with the given ID
            echo "No reservering found with this ID <br>";
            echo "<a href='reserveringen_index.php'>Go back</a>";
            exit; // You may want to exit here to prevent further execution
        }
    } else {
        // Error in executing SQL statement
        echo "Error executing SQL statement";
        echo "<a href='reserveringen_index.php'>Ga terug</a>";
        exit; // Exit to prevent further execution
    }
} else {
    // Redirect to reserveringen_index.php if ID parameter is not set
    header("Location: reserveringen_index.php");
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
<?php require 'nav.php' ?>
<main>
<div class="container">
        <div class="reserveringen-container">
        <div class="account-pagina">
            <div class="reserveringen-panel">
            <div class="form-panel"> 
            <h1>reserveren</h1> <!-- Form title -->
            
            <hr class="separator"> <!-- Add horizontal line as a separator -->
            <div class="white-space"></div>
            <form action="reserveringen_update.php?id=<?php echo $reservering_id ?>" method="POST">        
           
                <div class="input-container">
    <div class="input-groep">
        <input type="text" id="voornaam" name="voornaam" value="<?php echo $reservering['voornaam']; ?>" placeholder="Voornaam">
    </div>
    <div class="input-groep">
       <input type="text" id="tussenvoegsel" name="tussenvoegsel" value="<?php echo $reservering['tussenvoegsel']; ?>" placeholder="Tussenvoegsel">
    </div>
    <div class="input-groep">
       <input type="text" id="achternaam" name="achternaam" value="<?php echo $reservering['achternaam']; ?>" placeholder="Achternaam">
    </div>
</div>

                <div class="input-groep">
                   <input type="email" id="email" name="email" value="<?php echo $reservering['email']; ?>" placeholder="Email">
                </div>
                <div class="input-groep">
                    <input type="date" name="datum" id="datum" value="<?php echo $reservering['datum']; ?>">
                </div>
                <div class="input-groep">
                    <input type="time" name="tijd" id="tijd" value="<?php echo $reservering['tijd']; ?>">
                </div>
                <div class="input-groep">
                    <select name="tafel_id" id="tafel_id">
                        <?php foreach($tafels as $table): ?>
                            <option value="<?php echo $table['tafel_id']; ?>">
                                Tafel <?php echo $table['tafel_nummer']; ?> - <?php echo $table['aantal_personen']; ?> personen
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="input-groep">
                    <button type="submit" class="input-button">Aanpassen</button>
                </div>
</main>
<?php require 'footer.php' ?>
</body>
</html>


