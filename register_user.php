<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check if the username is already taken
    $stmt = $conn->prepare("SELECT * FROM user WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        echo "Username is already taken.";
    } else {
        // For testing, we'll store passwords as plain text. In production, use password_hash() for security
        $stmt = $conn->prepare("INSERT INTO user (username, password, role) VALUES (?, ?, 'user')");
        $stmt->bind_param("ss", $username, $password);
        if ($stmt->execute()) {
            echo "Registration successful!";
            header("Location: login.php");
            exit();
        } else {
            echo "Error: " . $stmt->error;
        }
    }
    $stmt->close();
}

$conn->close();
?>
