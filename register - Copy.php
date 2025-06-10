<?php
include 'db.php';

if (isset($_POST['username'], $_POST['password'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    // Check if user exists
    $result = $conn->query("SELECT id FROM users WHERE username='$username'");
    if ($result->num_rows > 0) {
        echo "Username already taken";
        exit;
    }

    $sql = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
    if ($conn->query($sql)) {
        echo "Registered";
    } else {
        echo "Error: " . $conn->error;
    }
} else {
    echo "Missing username or password.";
}
?>
