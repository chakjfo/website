<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loggedInUser = $_SESSION['username'];
    $friendUsername = json_decode(file_get_contents('php://input'), true)['username'];

    // Check if the friend request already exists
    $sql = "SELECT * FROM friends WHERE (user1 = '$loggedInUser' AND user2 = '$friendUsername') OR (user1 = '$friendUsername' AND user2 = '$loggedInUser')";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        echo "Friend request already sent or already friends.";
    } else {
        // Insert friend request
        $sql = "INSERT INTO friends (user1, user2, status) VALUES ('$loggedInUser', '$friendUsername', 'pending')";
        if ($conn->query($sql) === TRUE) {
            echo "Friend request sent to $friendUsername!";
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();
}
?>