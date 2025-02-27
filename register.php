<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

include 'templates/navbar.php';
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register</title>
</head>
<body>
    <h1>Register</h1>
    <form action="register_user.php" method="post">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required><br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required><br>
        <input type="submit" value="Register">
    </form>
</body>
</html>
