<?php


// Check if the request method is not POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo "You are not allowed to view this page ";
    echo " ga terug <a href='login.php'> login </a>";
    exit;
}

require 'database.php';

// Check if email and password are set and not empty
if (isset($_POST['email']) && isset($_POST['wachtwoord']) && !empty($_POST['email']) && !empty($_POST['wachtwoord'])) {
    $emailForm = $_POST['email'];
    $passwordForm = $_POST['wachtwoord'];

    // Prepare and execute the SQL query to fetch user by email
    $stmt = $conn->prepare("SELECT * FROM gebruikers WHERE email = :email");
    $stmt->bindParam(':email', $emailForm);
    $stmt->execute();

    // Check if a user with the given email exists
    if ($stmt->rowCount() > 0) {
        // Fetch the user data
        $dbuser = $stmt->fetch(PDO::FETCH_ASSOC);
        
        // Verify the password
        if (password_verify($passwordForm, $dbuser['wachtwoord'])) {
            session_start();
            $_SESSION['user_id'] = $dbuser['gebruiker_id'];
            $_SESSION['email'] = $dbuser['email'];
            $_SESSION['firstname'] = $dbuser['voornaam'];
            $_SESSION['infix'] = $dbuser['tussenvoegsel'];
            $_SESSION['lastname'] = $dbuser['achternaam'];
            $_SESSION['role'] = $dbuser['rol'];

            // Redirect to dashboard upon successful login
            header("Location: dashboard.php");
            exit;
        } else {
            // Password verification failed
            echo "Incorrect password ";
            echo "vul een geldig wachtwoord in bij <a href='login.php'> login</a>";
            exit;
        }
    } else {
        // User with the given email not found
        echo "User not found";
        echo "<a href='login.php'> log graag in</a>";
        exit;
    }
} else {
    // Email or password is empty
    echo "Email and password are required ";
    echo "Vul deze velden graag in bij het invullen van de <a href='login.php'> login </a> velden.";
    exit;
}
?>













