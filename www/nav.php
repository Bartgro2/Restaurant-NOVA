<?php
// Get the current page file name
$current_page = basename($_SERVER['PHP_SELF']);
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
            <li> <a href="#">dashboard</a></li>
            <li class="dropdown"> 
                <a href="#" class="dropbtn">gebruikers</a>
                <div class="dropdown-content">
                    <a href="#">bekijken</a>
                    <a href="#">toevoegen</a>
                </div>
            </li>
            <li> <a href="#">inloggen</a></li>
            <li> <a href="#">registeren</a></li>
        </ul>
    </div>
</nav>




