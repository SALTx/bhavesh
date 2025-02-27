<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['username']) && $_SESSION['role'] == 'admin') {
    $id = bin2hex(random_bytes(4)); // Generate random 8-digit hex ID
    $name = $_POST['name'];
    $description = $_POST['description'];
    $date = $_POST['date'];
    $time = $_POST['time'];
    $location = $_POST['location'];
    $available_slots = $_POST['available_slots'];

    // Insert new event into the database
    $stmt = $conn->prepare("INSERT INTO events (id, name, description, date, time, location, available_slots) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssi", $id, $name, $description, $date, $time, $location, $available_slots);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: index.php");
exit();
?>
