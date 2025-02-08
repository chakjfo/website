<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username'];
    $status = $_SESSION['status'];
    $postId = $_POST['post_id'];
    $comment = $_POST['comment'];

    $sql = "INSERT INTO comments (post_id, username, status, comment) VALUES ('$postId', '$username', '$status', '$comment')";

    if ($conn->query($sql) === TRUE) {
        echo "Comment added successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>