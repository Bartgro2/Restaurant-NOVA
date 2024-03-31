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
            <!-- Home and Menu links visible to all users -->
            <li><a href="index.php" <?php if ($current_page == 'index.php') echo 'class="active"'; ?>>Home</a></li>
            <li><a href="menu.php" <?php if ($current_page == 'menu.php') echo 'class="active"'; ?>>Menu</a></li>
            <!-- Reservering link -->
            <li><a href="reserveringen_create.php" <?php if ($current_page == 'reserveringen_create.php') echo 'class="active"'; ?>>Reservering</a></li>

            <!-- Dashboard link visible to all roles -->
            <?php if (isset($_SESSION['role'])) : ?>
                <li><a href="dashboard.php" <?php if ($current_page == 'dashboard.php') echo 'class="active"'; ?>>Dashboard</a></li>

                <!-- Other menu items visible to admin, manager, and directeur -->
                <?php if ($_SESSION['role'] == 'admin' || $_SESSION['role'] == 'directeur' || $_SESSION['role'] == 'manager' || $_SESSION['role'] == 'medewerker') { ?>
                    <li class="dropdown">                    
                        <a href="#" class="dropbtn <?php if (in_array($current_page, array('menugang_index.php', 'menugang_create.php'))) echo 'active'; ?>">Menugangen</a>
                        <div class="dropdown-content">
                            <a href="menugang_index.php">Bekijken</a>
                            <a href="menugang_create.php">Toevoegen</a>
                        </div>
                    </li>
                    <li class="dropdown"> 
                        <a href="#" class="dropbtn <?php if (in_array($current_page, array('categorieën_index.php', 'categorieën_create.php'))) echo 'active'; ?>">Categorieën</a>
                        <div class="dropdown-content">
                            <a href="categorieën_index.php">Bekijken</a>
                            <a href="categorieën_create.php">Toevoegen</a>
                        </div>
                    </li>
                    <li class="dropdown"> 
                        <a href="#" class="dropbtn <?php if (in_array($current_page, array('producten_index.php', 'producten_create.php'))) echo 'active'; ?>">Producten</a>
                        <div class="dropdown-content">
                            <a href="producten_index.php">Bekijken</a>
                            <a href="producten_create.php">Toevoegen</a>
                        </div>
                    </li>
                    <li class="dropdown"> 
                        <a href="#" class="dropbtn <?php if (in_array($current_page, array('tafels_index.php', 'tafels_create.php'))) echo 'active'; ?>">Tafels</a>
                        <div class="dropdown-content">
                            <a href="tafels_index.php">Bekijken</a>
                            <a href="tafels_create.php">Toevoegen</a>
                        </div>
                    </li>
                    <li class="dropdown">
                    <a href="#" class="dropbtn <?php if (in_array($current_page, array('reserveringen_index.php', 'reserveringen_create.php'))) echo 'active'; ?>">Reserveringen</a>
                        <div class="dropdown-content">
                            <a href="reserveringen_index.php">Bekijken</a>
                            <a href="reserveringen_create.php">Toevoegen</a>
                        </div>
                    </li>

                    <li class="dropdown">
                    <a href="#" class="dropbtn <?php if (in_array($current_page, array('gebruikers_index.php', 'gebruikers_create.php'))) echo 'active'; ?>">Gebruikers</a>
                        <div class="dropdown-content">
                            <a href="gebruikers_index.php">Bekijken</a>
                            <a href="gebruikers_create.php">Toevoegen</a>
                        </div>
                    </li>
                <?php } ?>
            <?php endif; ?>

            <!-- Login/Logout link -->
            <li><?php echo $login_link; ?></li>
        </ul>
    </div>
</nav>


