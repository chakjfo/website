<?php
session_start();
include 'db_connection.php';

$loggedInUser = $_SESSION['username'];

$sql = "SELECT user1 AS username FROM friends WHERE user2 = '$loggedInUser' AND status = 'accepted'
        UNION
        SELECT user2 AS username FROM friends WHERE user1 = '$loggedInUser' AND status = 'accepted'";
$result = $conn->query($sql);

$friends = [];
while ($row = $result->fetch_assoc()) {
    $friends[] = $row;
}

echo json_encode($friends);

$conn->close();
?>