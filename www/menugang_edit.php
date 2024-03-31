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
    echo " ga terug naar <a href='menugang.php'> menugang </a>";
    exit;
}

require 'database.php';


if (isset($_GET['id'])) {
    $menugang_id = $_GET['id'];

    // Prepare the SQL statement
    $sql = "SELECT * FROM menugangen WHERE menugang_id = :menugang_id";
    $stmt = $conn->prepare($sql);

    // Bind the parameter
    $stmt->bindParam(":menugang_id", $menugang_id);

    // Execute the statement
    if ($stmt->execute()) {
        // Check if a menugang record is found
        if ($stmt->rowCount() > 0) {
            // Fetch the menugang record
            $menugang = $stmt->fetch(PDO::FETCH_ASSOC);
        } else {
            // No menugang found with the given ID
            echo "No menugang found with this ID <br>";
            echo "<a href='menugang_index.php'>Ga terug</a>";
            exit; // Exit to prevent further execution
        }
    } else {
        // Error in executing SQL statement
        echo "Error executing SQL statement";
        echo "<a href='menugang_index.php'>Ga terug</a>";
        exit; // Exit to prevent further execution
    }
} else {
    // Redirect to menugang_index.php if ID parameter is not set
    header("Location: menugang_index.php");
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
            <h1>menugang bijwerken</h1> <!-- Form title -->
            <hr class="separator"> <!-- Add horizontal line as a separator -->
            <form action="menugang_update.php?id=<?php echo $menugang_id ?>" method="POST">
                    <div class="input-groep">
                        <label for="naam">naam</label>
                        <input type="text" id="naam" name="naam" value="<?php echo $menugang['naam'] ?>">
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


