<?php
include 'db.php';

if (isset($_POST['sender_id'], $_POST['receiver_id'], $_POST['message'])) {
    $sender = intval($_POST['sender_id']);
    $receiver = intval($_POST['receiver_id']);
    $message = $conn->real_escape_string($_POST['message']);

    // Validate users exist
    $validSender = $conn->query("SELECT id FROM users WHERE id=$sender")->num_rows > 0;
    $validReceiver = $conn->query("SELECT id FROM users WHERE id=$receiver")->num_rows > 0;

    if (!$validSender || !$validReceiver) {
        echo "Invalid sender or receiver";
        exit;
    }

    $sql = "INSERT INTO messages (sender_id, receiver_id, message) VALUES ($sender, $receiver, '$message')";
    if ($conn->query($sql)) {
        echo "Message sent";
    } else {
        echo "DB Error: " . $conn->error;
    }
} else {
    echo "Missing required data.";
}
?>
