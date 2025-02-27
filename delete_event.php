<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['username']) && $_SESSION['role'] == 'admin') {
    $event_id = $_POST['event_id'];

    // Delete the event from the database
    $stmt = $conn->prepare("DELETE FROM events WHERE id = ?");
    $stmt->bind_param("s", $event_id);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: index.php");
exit();
?>
