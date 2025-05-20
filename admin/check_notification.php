<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "wmsp"; 

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name = $_POST['username']; // Get the user's name

// Query to get unread user notifications
$user_sql = "SELECT id, notification_message AS message, notification_time, user_notified 
             FROM waste_reports 
             WHERE username = ? AND user_notified = 0";
$user_stmt = $conn->prepare($user_sql);
$user_stmt->bind_param("s", $name);
$user_stmt->execute();
$user_result = $user_stmt->get_result();

// Query to get unread admin notifications
$admin_sql = "SELECT an.id, an.message, an.notification_time, COALESCE(uan.is_read, 0) AS is_read
              FROM admin_notifications an
              LEFT JOIN user_admin_notifications uan 
              ON an.id = uan.admin_notification_id AND uan.username = ? 
              WHERE uan.is_read = 0 OR uan.is_read IS NULL";
$admin_stmt = $conn->prepare($admin_sql);
$admin_stmt->bind_param("s", $name);
$admin_stmt->execute();
$admin_result = $admin_stmt->get_result();

// Collect all notifications (user + admin)
$notifications = [];
while ($row = $user_result->fetch_assoc()) {
    $notifications[] = $row;
}

while ($row = $admin_result->fetch_assoc()) {
    $notifications[] = $row;
}

// If there are notifications, mark them as notified (user-specific)
if (!empty($notifications)) {
    $user_update_sql = "UPDATE waste_reports SET user_notified = 1 WHERE username = ? AND user_notified = 0";
    $stmt = $conn->prepare($user_update_sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();

    // Mark admin notifications as read
    $admin_update_sql = "UPDATE user_admin_notifications SET is_read = 1 WHERE username = ?";
    $stmt = $conn->prepare($admin_update_sql);
    $stmt->bind_param("s", $name);
    $stmt->execute();
}

// Return notifications as JSON
echo json_encode($notifications);
echo json_encode(['unread_count' => $unreadCount]);

?>
