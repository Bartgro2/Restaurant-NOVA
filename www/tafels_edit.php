<?php

session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if role is not admin, manager or medewerker
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'manager') {
    echo "You are not allowed to view this page, please login as admin, manager, or medewerker ";
    echo " ga terug naar <a href='login.php'> tafel </a>";
    exit;
}

// Check if the request method is not GET
if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo "You are not allowed to view this page ";
    echo " ga terug naar <a href='tafels_index.php'> tafel </a>";
    exit;
}

require 'database.php';


if (isset($_GET['id'])) {
    $tafel_id = $_GET['id'];

    // Prepare the SQL statement
    $sql = "SELECT * FROM tafels WHERE tafel_id = :tafel_id";
    $stmt = $conn->prepare($sql);

    // Bind the parameter
    $stmt->bindParam(":tafel_id", $tafel_id);

    // Execute the statement
    if ($stmt->execute()) {
        // Check if a menugang record is found
        if ($stmt->rowCount() > 0) {
            // Fetch the menugang record
            $tafel = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            // No tafel found with the given ID
            echo "No tafel found with this ID <br>";
            echo "<a href='tafels_index.php'>Ga terug</a>";
            exit; // Exit to prevent further execution
        }
    } else {
        // Error in executing SQL statement
        echo "Error executing SQL statement";
        echo "<a href='tafels_index.php'>Ga terug</a>";
        exit; // Exit to prevent further execution
    }
} else {
    // Redirect to tafels_index.php if ID parameter is not set
    header("Location: tafels_index.php");
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
<?php require 'nav.php';?>
<main>
    <div class="account-pagina2">
        <div class="form-panel">    
            <h1>tafel bijwerken</h1> <!-- Form title -->
            <hr class="separator"> <!-- Add horizontal line as a separator -->
            <form action="tafels_update.php?id=<?php echo $tafel_id ?>" method="POST">
                    <div class="input-groep">
                        <label for="personen">personen</label>
                        <input type="number" id="personen" name="personen" value="<?php echo $tafel['aantal_personen'] ?>">
                    </div>
                    <div class="input-groep">
                        <label for="nummer">nummer</label>
                        <input type="number" id="nummer" name="nummer" value="<?php echo $tafel['tafelnummer'] ?>">
                    </div>
                    <div class="input-groep">
                        <button type="submit" class="input-button"> bijwerken </button>
                    </div> 
            </form>
        </div>
    </div>
</main>
<?php require 'footer.php' ?>
</body>
</html>