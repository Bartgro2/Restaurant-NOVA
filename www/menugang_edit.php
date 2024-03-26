<?php


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
        if ($stmt->rowCount() > 0) {
            $menugang = $stmt->fetch(PDO::FETCH_ASSOC);
            // Process the retrieved data (if needed)
        } else {
            // No category found with the given ID
            echo "No category found with this ID <br>";
            echo "<a href='tool_index.php'>Go back</a>";
            exit; // You may want to exit here to prevent further execution
        }
    } else {
        // Error in executing SQL statement
        echo "Error executing SQL statement";
        exit; // You may want to exit here to prevent further execution
    }
}

require 'nav.php';
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


