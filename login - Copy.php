<?php
include 'db.php';

if (isset($_POST['username'], $_POST['password'])) {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];

    $result = $conn->query("SELECT * FROM users WHERE username='$username'");
    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        if (password_verify($password, $user['password'])) {
            echo $user['id']; // return user ID for frontend
            exit;
        }
    }
    echo "Invalid";
} else {
    echo "Missing username or password.";
}
?>
