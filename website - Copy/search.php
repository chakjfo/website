<?php
session_start();
include 'db_connection.php';

$query = $_GET['query'];
$loggedInUser = $_SESSION['username'];

// Search for users
$sql = "SELECT username, status,
               EXISTS(
                   SELECT 1 FROM friends
                   WHERE (user1 = '$loggedInUser' AND user2 = username AND status = 'accepted')
                      OR (user1 = username AND user2 = '$loggedInUser' AND status = 'accepted')
               ) AS is_friend
        FROM account
        WHERE username LIKE '%$query%'";
$result = $conn->query($sql);

$results = [];
while ($row = $result->fetch_assoc()) {
    $results[] = ['type' => 'user', ...$row];
}

// Search for topics
$sql = "SELECT p.*, t.topic
        FROM posts p
        JOIN topics t ON p.id = t.post_id
        WHERE t.topic LIKE '%$query%'
        ORDER BY p.post_date DESC";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    $results[] = ['type' => 'post', ...$row];
}

echo json_encode($results);

$conn->close();
?>