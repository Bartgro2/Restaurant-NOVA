<?php

session_start();

// Check if the user is not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}

// Check if role is not admin, manager or medewerker
if ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'manager' && $_SESSION['role'] !== 'medewerker') {
    echo "You are not allowed to view this page, please login as admin, manager, or medewerker ";
    echo " login als een andere rol, hier <a href='login.php'> login </a>";
    exit;
}

require 'database.php';


if (isset($_GET['id'])) {
    $categorie_id = $_GET['id'];

    // Prepare the SQL statement
    $sql = "SELECT * FROM categorieen WHERE categorie_id = :categorie_id";
    $stmt = $conn->prepare($sql);

    // Bind the parameter
    $stmt->bindParam(":categorie_id", $categorie_id);

    // Execute the statement
    if ($stmt->execute()) {
        if ($stmt->rowCount() > 0) {
            $categorie = $stmt->fetch(PDO::FETCH_ASSOC);
            // Process the retrieved data (if needed)
        } else {
            // No category found with the given ID
            echo "No categorie found with this ID <br>";
            echo "<a href='categorieën_index.php'> ga terug</a>";
            exit; // You may want to exit here to prevent further execution
        }
    } else {
        // Error in executing SQL statement
        echo "Error executing SQL statement";
        exit; // You may want to exit here to prevent further execution
    }
} else {
    // Redirect to the index page if 'id' parameter is not set
    header("Location: categorieën_index.php");
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
<?php require 'nav.php' ?>  
<main>
    <div class="account-pagina2">
        <div class="form-panel">    
            <h1>categorie bijwerken</h1> <!-- Form title -->
            <hr class="separator"> <!-- Add horizontal line as a separator -->
            <form action="categorieën_update.php?id=<?php echo $categorie_id ?>" method="POST">
                    <div class="input-groep">
                        <label for="naam">naam</label>
                        <input type="text" id="naam" name="naam" value="<?php echo $categorie['naam'] ?>">
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

