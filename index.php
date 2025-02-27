<?php
include 'templates/navbar.php'; // Include the navigation bar

// Include the database connection
include 'database.php';

// Check if the user is logged in
$is_logged_in = isset($_SESSION['username']);
$is_admin = $is_logged_in && $_SESSION['role'] == 'admin';

// Fetch events and their participants
$sql = "SELECT e.id, e.name, e.description, e.date, e.time, e.location, e.available_slots AS total_slots,
        COUNT(es.event_id) AS signed_up,
        GROUP_CONCAT(u.username SEPARATOR ', ') AS participants
        FROM events e
        LEFT JOIN event_signups es ON e.id = es.event_id
        LEFT JOIN user u ON es.username = u.username
        GROUP BY e.id";

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    echo "<table border='1'>
            <tr>
                <th>Event Name</th>
                <th>Description</th>
                <th>Date</th>
                <th>Time</th>
                <th>Location</th>
                <th>Available Slots</th>
                <th>Participants</th>
                <th>Action</th>
            </tr>";
    while($row = $result->fetch_assoc()) {
        $available_slots = $row['total_slots'] - $row['signed_up'];
        echo "<tr>
                <td>{$row['name']}</td>
                <td>{$row['description']}</td>
                <td>{$row['date']}</td>
                <td>{$row['time']}</td>
                <td>{$row['location']}</td>
                <td>{$available_slots}</td>
                <td>{$row['participants']}</td>
                <td>";
        if ($is_logged_in && $available_slots > 0) {
            echo "<form action='signup.php' method='post'>
                    <input type='hidden' name='event_id' value='{$row['id']}'>
                    <input type='submit' value='Sign Up'>
                  </form>";
        } else if (!$is_logged_in) {
            echo "Please log in to sign up";
        } else {
            echo "No available slots";
        }
        // Display delete button for admins
        if ($is_admin) {
            echo "<form action='delete_event.php' method='post' style='display:inline;'>
                    <input type='hidden' name='event_id' value='{$row['id']}'>
                    <input type='submit' value='Delete'>
                  </form>";
        }
        echo "</td></tr>";
    }
    // Display add event form for admins
    if ($is_admin) {
        echo "<tr>
                <form action='add_event.php' method='post'>
                <td><input type='text' name='name' required></td>
                <td><input type='text' name='description'></td>
                <td><input type='date' name='date' required></td>
                <td><input type='time' name='time' required></td>
                <td><input type='text' name='location' required></td>
                <td><input type='number' name='available_slots' required min='1'></td>
                <td colspan='2'><input type='submit' value='Add Event'></td>
                </form>
              </tr>";
    }
    echo "</table>";
} else {
    echo "No events found.";
}

$conn->close();
?>
