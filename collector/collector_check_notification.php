<?php
session_start();
if (!isset($_SESSION['username'])) {
    die("Unauthorized");
}

$collector = $_SESSION['username'];
$conn = new mysqli("localhost", "root", "", "wmsp");

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Mark all collector admin notifications as read
$stmt = $conn->prepare("UPDATE collector_notifications SET is_read = 1 WHERE username = ?");
$stmt->bind_param("s", $wastecollector);
$stmt->execute();

$stmt->close();
$conn->close();

echo json_encode(['status' => 'success']);
