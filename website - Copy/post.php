<?php
session_start();
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username'];
    $status = $_SESSION['status'];
    $content = $_POST['content'];
    $topic = $_POST['topic'];
    $filePath = '';

    // Handle file upload
    if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $fileName = basename($_FILES['file']['name']);
        $filePath = $uploadDir . $fileName;
        move_uploaded_file($_FILES['file']['tmp_name'], $filePath);
    }

    // Insert post
    $sql = "INSERT INTO posts (username, status, content, file_path) VALUES ('$username', '$status', '$content', '$filePath')";
    if ($conn->query($sql) === TRUE) {
        $postId = $conn->insert_id;
        // Insert topic
        if (!empty($topic)) {
            $sql = "INSERT INTO topics (post_id, topic) VALUES ('$postId', '$topic')";
            $conn->query($sql);
        }
        echo "Post created successfully!";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>