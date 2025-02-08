<?php
include 'db_connection.php';

$sql = "SELECT DISTINCT topic FROM topics";
$result = $conn->query($sql);

$topics = [];
while ($row = $result->fetch_assoc()) {
    $topics[] = $row;
}

echo json_encode($topics);

$conn->close();
?>