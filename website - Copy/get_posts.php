<?php
session_start();
include 'db_connection.php';

$loggedInUser = $_SESSION['username'];

$sql = "SELECT p.*, c.username AS comment_username, c.status AS comment_status, c.comment, c.comment_date,
               EXISTS(
                   SELECT 1 FROM friends
                   WHERE (user1 = '$loggedInUser' AND user2 = p.username AND status = 'accepted')
                      OR (user1 = p.username AND user2 = '$loggedInUser' AND status = 'accepted')
               ) AS is_friend
        FROM posts p
        LEFT JOIN comments c ON p.id = c.post_id
        ORDER BY p.post_date DESC";
$result = $conn->query($sql);

$posts = [];
while ($row = $result->fetch_assoc()) {
    $postId = $row['id'];
    if (!isset($posts[$postId])) {
        $posts[$postId] = [
            'id' => $row['id'],
            'username' => $row['username'],
            'status' => $row['status'],
            'content' => $row['content'],
            'file_path' => $row['file_path'],
            'post_date' => $row['post_date'],
            'is_friend' => $row['is_friend'], // Correctly set based on friend status
            'comments' => []
        ];
    }
    if ($row['comment']) {
        $posts[$postId]['comments'][] = [
            'username' => $row['comment_username'],
            'status' => $row['comment_status'],
            'comment' => $row['comment'],
            'comment_date' => $row['comment_date']
        ];
    }
}

echo json_encode(array_values($posts));

$conn->close();
?>