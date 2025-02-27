<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
echo '<nav>
    <ul>
        <li><a href="index.php">Home</a></li>';
if (isset($_SESSION['username'])) {
    echo '<li><a href="logout.php">Logout (' . htmlspecialchars($_SESSION['username']) . ')</a></li>';
} else {
    echo '<li><a href="login.php">Login</a></li>
          <li><a href="register.php">Register</a></li>';
}
echo '</ul>
</nav>';
?>
