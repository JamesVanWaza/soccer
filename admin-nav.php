<?php include_once 'html5req.php';?>
    <nav class="top-bar" data-topbar role="navigation" data-options="is_hover: false">
        <ul class="title-area">
            <li class="name">
                <h1><a href="index.php">Soccer Statistics</a></h1>
            </li>
            <!-- Remove the class "menu-icon" to get rid of menu icon. Take out "Menu" to just have icon alone -->
            <li class="toggle-topbar menu-icon"><a href="#"><span>MENU</span></a>
        </li>
    </ul>
        <section class="top-bar-section">
            <!-- Right Nav Section -->
            <ul class="right">
                <li><a href="view-uefaclubs.php">UEFA Stats</a></li>
                <li><a href="view-club.php">View Clubs</a></li>
                <li><a href="view-mlsclub.php">View MLS Clubs</a></li>
            </ul>
        </section>
    </nav>
<?php include 'footer.php';?>
