<?php
include 'db_connection.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash the password
    $email = $_POST['email'];
    $status = $_POST['status'];

    // Insert into the account table
    $sql = "INSERT INTO account (username, password, email, status) VALUES ('$username', '$password', '$email', '$status')";

    if ($conn->query($sql) === TRUE) {
        echo "Signup successful! <a href='login.html'>Login here</a>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>