<?php
include 'db_connection.php';

$username = $_GET['username'];

$sql = "SELECT * FROM posts WHERE username = '$username' ORDER BY post_date DESC";
$result = $conn->query($sql);

$posts = [];
while ($row = $result->fetch_assoc()) {
    $posts[] = $row;
}

echo json_encode($posts);

$conn->close();
?>