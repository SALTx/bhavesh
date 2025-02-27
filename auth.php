<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the user exists in the database
    $stmt = $conn->prepare("SELECT username, password, role FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        $stmt->bind_result($db_username, $db_password, $db_role);
        $stmt->fetch();
        // For testing, we'll use plain text password comparison. In production, use password_verify() with hashed passwords
        if ($password == $db_password) {
            $_SESSION['username'] = $db_username;
            $_SESSION['role'] = $db_role;
            header("Location: index.php");
            exit();
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "Invalid username.";
    }
    $stmt->close();
}
$conn->close();
?>
