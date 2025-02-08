<?php
include 'db_connection.php';

$topic = $_GET['topic'];

$sql = "SELECT p.* FROM posts p
        JOIN topics t ON p.id = t.post_id
        WHERE t.topic = '$topic'
        ORDER BY p.post_date DESC";
$result = $conn->query($sql);

$posts = [];
while ($row = $result->fetch_assoc()) {
    $posts[] = $row;
}

echo json_encode($posts);

$conn->close();
?>