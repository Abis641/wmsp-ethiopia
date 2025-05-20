<?php
session_start();
if (!isset($_SESSION['username'])) {
    http_response_code(401);
    echo json_encode(['error' => 'Unauthorized']);
    exit;
}

$collector = $_SESSION['username'];
$conn = new mysqli("localhost", "root", "", "wmsp");
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed']);
    exit;
}

$sql = "SELECT id, title, message, notification_time, read_status FROM collector_notifications WHERE username = ? ORDER BY notification_time DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $collector);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($notifications);
