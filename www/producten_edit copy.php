<?php

session_start();

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
    <div class="account-pagina">
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

