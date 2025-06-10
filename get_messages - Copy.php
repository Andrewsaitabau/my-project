<?php
// Database connection
$conn = new mysqli("localhost", "root", "", "chat_app");

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the two user IDs
$user1 = isset($_GET['user1']) ? intval($_GET['user1']) : 0;
$user2 = isset($_GET['user2']) ? intval($_GET['user2']) : 0;

if ($user1 == 0 || $user2 == 0) {
    echo json_encode([]);
    exit;
}

// Prepare and execute query to fetch messages between user1 and user2
$stmt = $conn->prepare("
    SELECT sender_id, receiver_id, message, timestamp 
    FROM messages 
    WHERE (sender_id = ? AND receiver_id = ?) 
       OR (sender_id = ? AND receiver_id = ?) 
    ORDER BY timestamp ASC
");

$stmt->bind_param("iiii", $user1, $user2, $user2, $user1);
$stmt->execute();
$result = $stmt->get_result();

$messages = [];

while ($row = $result->fetch_assoc()) {
    $messages[] = $row;
}

echo json_encode($messages);
?>
