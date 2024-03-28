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
            <li> <a href="#">Menu</a></li>
            <li class="dropdown">
                <a href="" class="dropbtn">Menugangen</a>
                <div class="dropdown-content">
                    <a href="menugang_index.php">Bekijken</a>
                    <a href="menugang_create.php">Toevoegen</a>
                </div>
            </li>
            <li class="dropdown"> 
                <a href="" class="dropbtn">Categorieën</a>
                <div class="dropdown-content">
                    <a href="categorieën_index.php">Bekijken</a>
                    <a href="categorieën_create.php">Toevoegen</a>
                </div>
            </li>
            <li class="dropdown"> 
                <a href="" class="dropbtn">Producten</a>
                <div class="dropdown-content">
                    <a href="producten_index.php">Bekijken</a>
                    <a href="producten_create.php">Toevoegen</a>
                </div>
            </li>
            <li class="dropdown"> 
                <a href="" class="dropbtn">Tafel</a>
                <div class="dropdown-content">
                    <a href="#">Bekijken</a>
                    <a href="#">Toevoegen</a>
                </div>
            </li>
            <li class="dropdown"> 
                <a href="" class="dropbtn">Reservering</a>
                <div class="dropdown-content">
                    <a href="#">Bekijken</a>
                    <a href="#">Toevoegen</a>
                </div>
            </li>
            <li> <a href="dashboard.php">Dashboard</a></li>
            <li class="dropdown"> 
                <a href="#" class="dropbtn">Gebruikers</a>
                <div class="dropdown-content">
                    <a href="gebruikers_index.php">Bekijken</a>
                    <a href="gebruikers_create.php">Toevoegen</a>
                </div>
            </li>
            <li><?php echo $login_link; ?></li>
        </ul>
    </div>
</nav>





