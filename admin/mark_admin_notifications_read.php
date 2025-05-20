<?php
session_start();
include 'Wconnect.php'; // adjust based on your DB connection

$username = $_SESSION['username']; // or however you track logged-in users

// Mark admin notifications for this user as read
$stmt = $conn->prepare("UPDATE admin_notifications SET read_status = 1 WHERE username = ? AND read_status = 0");
$stmt->bind_param("s", $username);
$stmt->execute();

echo json_encode(["success" => true]);
?>
