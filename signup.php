<?php
session_start();
include 'database.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_SESSION['username'])) {
    $event_id = $_POST['event_id'];
    $username = $_SESSION['username'];

    // Check if the user has already signed up for the event
    $stmt = $conn->prepare("SELECT * FROM event_signups WHERE event_id = ? AND username = ?");
    $stmt->bind_param("ss", $event_id, $username);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows == 0) {
        // Insert sign-up record
        $stmt = $conn->prepare("INSERT INTO event_signups (event_id, username) VALUES (?, ?)");
        $stmt->bind_param("ss", $event_id, $username);
        if ($stmt->execute()) {
            echo "Sign-up successful!";
        } else {
            echo "Error: " . $stmt->error;
        }
    } else {
        echo "You have already signed up for this event.";
    }
    $stmt->close();
} else {
    echo "You must be logged in to sign up for an event.";
}

$conn->close();
header("Location: index.php");
exit();
?>
