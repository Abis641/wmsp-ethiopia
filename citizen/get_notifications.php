<?php
session_start();
$username = $_SESSION['username'] ?? null;

if (!$username) {
    echo 0;
    exit;
}

$conn = new mysqli("localhost", "root", "", "wmsp");
if ($conn->connect_error) {
    echo 0;
    exit;
}

// ✅ Get email based on username
$email_sql = "SELECT email FROM users WHERE username = ?";
$email_stmt = $conn->prepare($email_sql);
$email_stmt->bind_param("s", $username);
$email_stmt->execute();
$email_result = $email_stmt->get_result();
$email_row = $email_result->fetch_assoc();
$email = $email_row['email'] ?? null;
$email_stmt->close();

if (!$email) {
    echo 0;
    exit;
}
// Query to count unread user notifications
$user_sql = "SELECT COUNT(*) AS count 
             FROM waste_reports 
             WHERE username = ? AND user_notified = 0 AND notification_message IS NOT NULL";
$user_stmt = $conn->prepare($user_sql);
$user_stmt->bind_param("s", $username);
$user_stmt->execute();
$user_result = $user_stmt->get_result();
$user_row = $user_result->fetch_assoc();

// Query to count unread admin notifications
$admin_sql = "SELECT COUNT(*) AS count 
              FROM admin_notifications an
              LEFT JOIN user_admin_notifications uan 
              ON an.id = uan.admin_notification_id 
              WHERE uan.username = ? AND (uan.is_read = 0 OR uan.is_read IS NULL)";
$admin_stmt = $conn->prepare($admin_sql);
$admin_stmt->bind_param("s", $username);
$admin_stmt->execute();
$admin_result = $admin_stmt->get_result();
$admin_row = $admin_result->fetch_assoc();

// ✅ Count unread payment notifications (approval/rejection)
$payments_sql = "SELECT COUNT(*) AS count 
                FROM notifications 
                WHERE email = ? AND is_read = 0";
$payments_stmt = $conn->prepare($payments_sql);
$payments_stmt->bind_param("s", $email); 
$payments_stmt->execute();
$payments_result = $payments_stmt->get_result();
$payments_row = $payments_result->fetch_assoc();

// Total unread notifications
$total_unread = $user_row['count'] + $admin_row['count'] + $payments_row['count'];

echo $total_unread;
?>
