<?php
session_start();
include 'db_connection.php';

$loggedInUser = $_SESSION['username'];

$sql = "SELECT user1 AS username FROM friends WHERE user2 = '$loggedInUser' AND status = 'pending'";
$result = $conn->query($sql);

$requests = [];
while ($row = $result->fetch_assoc()) {
    $requests[] = $row;
}

echo json_encode($requests);

$conn->close();
?>