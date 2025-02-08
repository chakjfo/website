<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $loggedInUser = $_SESSION['username'];
    $friendUsername = json_decode(file_get_contents('php://input'), true)['username'];

    // Update friend request status to 'accepted'
    $sql = "UPDATE friends SET status = 'accepted' WHERE user1 = '$friendUsername' AND user2 = '$loggedInUser'";
    if ($conn->query($sql) === TRUE) {
        echo "Friend request accepted!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>