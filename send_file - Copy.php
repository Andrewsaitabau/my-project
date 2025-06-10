<?php
$conn = new mysqli("localhost", "root", "", "chat_app");

$sender = $_POST['sender_id'];
$receiver = $_POST['receiver_id'];
$file = $_FILES['file'];

$uploadDir = "uploads/";
if (!file_exists($uploadDir)) {
    mkdir($uploadDir, 0777, true);
}
$filename = basename($file['name']);
$filepath = $uploadDir . $filename;

if (move_uploaded_file($file['tmp_name'], $filepath)) {
    $ext = pathinfo($filename, PATHINFO_EXTENSION);
    $message = '';

    if (in_array($ext, ['jpg', 'jpeg', 'png', 'gif'])) {
        $message = '<img src="'.$filepath.'" style="max-width:200px;" />';
    } elseif (in_array($ext, ['mp4', 'webm'])) {
        $message = '<video src="'.$filepath.'" controls style="max-width:200px;"></video>';
    } elseif (in_array($ext, ['mp3', 'wav'])) {
        $message = '<audio controls><source src="'.$filepath.'" type="audio/'.$ext.'"></audio>';
    } else {
        $message = '<a href="'.$filepath.'" target="_blank">'.htmlspecialchars($filename).'</a>';
    }

    $stmt = $conn->prepare("INSERT INTO messages (sender_id, receiver_id, message) VALUES (?, ?, ?)");
    $stmt->bind_param("iis", $sender, $receiver, $message);
    $stmt->execute();
    echo "File sent";
} else {
    echo "Upload failed";
}
?>
