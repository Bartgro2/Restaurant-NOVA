<?php
// Get the current page file name
$current_page = basename($_SERVER['PHP_SELF']);

if (isset($_SESSION['user_id'])) {
    // If logged in, display "Logout" link
    $login_link = '<a href="logout.php">Logout</a>';
} else {
    // If not logged in, display "Login" link
    $login_link = '<a href="login.php">Login</a>';
}




?>

<nav>
    <div class="container">
        <ul>
        <li> <a href="index.php" <?php if ($current_page == 'index.php') echo 'class="active"'; ?>>Home</a></li>
            <li> <a href="#">menu</a></li>
            <li class="dropdown">
            <a href="" class="dropbtn">menugangen</a>
             <div class="dropdown-content">
                 <a href="menugang_index.php">bekijken</a>
                 <a href="menugang_create.php">toevoegen</a>
             </div>
            </li>
            <li class="dropdown"> 
                <a href="" class="dropbtn">categorieën</a>
                <div class="dropdown-content">
                    <a href="categorieën_index.php">bekijken</a>
                    <a href="categorieën_create.php">toevoegen</a>
                </div>
            </li>
            <li class="dropdown"> 
                <a href="" class="dropbtn">producten</a>
                <div class="dropdown-content">
                    <a href="producten_index.php">bekijken</a>
                    <a href="producten_create.php">toevoegen</a>
                </div>
                </li>
            <li> <a href="#">dashboard</a></li>
            <li class="dropdown"> 
                <a href="#" class="dropbtn">gebruikers</a>
                <div class="dropdown-content">
                    <a href="#">bekijken</a>
                    <a href="gebruikers_create.php">toevoegen</a>
                </div>
            </li>
            <li><?php echo $login_link; ?></li>
        </ul>
    </div>
</nav>




