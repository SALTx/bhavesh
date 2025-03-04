<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['username'])) {
    $event_id = $_POST['event_id'];
    $username = $_SESSION['username'];

    // Remove the user from the event
    $stmt = $conn->prepare("DELETE FROM event_signups WHERE event_id = ? AND username = ?");
    $stmt->bind_param("ss", $event_id, $username);
    $stmt->execute();
    $stmt->close();
}

$conn->close();
header("Location: index.php");
exit();
?>
