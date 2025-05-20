<?php
session_start();
$username = $_SESSION['username'] ?? null;

$conn = new mysqli("localhost", "root", "", "wmsp");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}


// ✅ Get user's email first
$email_sql = "SELECT email FROM users WHERE username = ?";
$email_stmt = $conn->prepare($email_sql);
$email_stmt->bind_param("s", $username);
$email_stmt->execute();
$email_result = $email_stmt->get_result();
$email_row = $email_result->fetch_assoc();
$email = $email_row['email'] ?? null;
$email_stmt->close();

if (!$email) {
    echo json_encode(['error' => 'User email not found']);
    exit;
}




// Fetch user-specific notifications
// Fetch user-specific notifications with timezone adjustment
$user_sql = "SELECT notification_message AS message, 
                    CONVERT_TZ(notification_time, '+00:00', '+01:00') AS notification_time,
                    user_notified
             FROM waste_reports 
             WHERE username = ? AND notification_message IS NOT NULL";

$user_stmt = $conn->prepare($user_sql);
$user_stmt->bind_param("s", $username);
$user_stmt->execute();
$user_result = $user_stmt->get_result();

// Fetch admin-wide notifications and join with read status per user
$admin_sql = "SELECT an.id,an.title, an.message, an.notification_time, 
                     COALESCE(uan.is_read, 0) AS user_notified,read_status
              FROM admin_notifications an
              LEFT JOIN user_admin_notifications uan 
              ON an.id = uan.admin_notification_id AND uan.username = ?";
$admin_stmt = $conn->prepare($admin_sql);
$admin_stmt->bind_param("s", $username);
$admin_stmt->execute();
$admin_result = $admin_stmt->get_result();

$all_notifications = [];

// Fetch payment approval/rejection notifications
$payments_sql = "SELECT message, created_at AS notification_time, is_read 
                FROM notifications 
                WHERE email = ?";
$payments_stmt = $conn->prepare($payments_sql);
$payments_stmt->bind_param("s", $email); // assuming username is the user's email
$payments_stmt->execute();
$payments_result = $payments_stmt->get_result();

while ($row = $payments_result->fetch_assoc()) {
    $row['source'] = 'payments';
    $row['user_notified'] = $row['is_read'] == 0 ? 0 : 1; // to fit your existing format
    $all_notifications[] = $row;
}


// Add user notifications
while ($row = $user_result->fetch_assoc()) {
    $row['source'] = 'user';
    $all_notifications[] = $row;
}

// Add admin notifications
while ($row = $admin_result->fetch_assoc()) {
    $row['source'] = 'admin';
    $all_notifications[] = $row;
}



// Free results
$user_result->free();
$admin_result->free();

// Sort by time (newest first)
usort($all_notifications, function($a, $b) {
    return strtotime($b['notification_time']) - strtotime($a['notification_time']);
});

// Count unread user notifications
$user_count_query = $conn->prepare("SELECT COUNT(*) FROM waste_reports WHERE username = ? AND user_notified = 0");
$user_count_query->bind_param("s", $username);
$user_count_query->execute();
$user_count_query->bind_result($user_unread);
$user_count_query->fetch();
$user_count_query->close();

// Count unread admin notifications
$admin_count_query = $conn->prepare("SELECT COUNT(*) FROM user_admin_notifications WHERE username = ? AND is_read = 0");
$admin_count_query->bind_param("s", $username);
$admin_count_query->execute();
$admin_count_query->bind_result($admin_unread);
$admin_count_query->fetch();
$admin_count_query->close();

$payments_count_query = $conn->prepare("SELECT COUNT(*) FROM notifications WHERE email = ? AND is_read = 0");
$payments_count_query->bind_param("s", $email);
$payments_count_query->execute();
$payments_count_query->bind_result($payments_unread);
$payments_count_query->fetch();
$payments_count_query->close();
// Total unread notifications
$total_unread = $user_unread + $admin_unread + $payments_unread;




// Mark user-specific notifications as read
$update_user = $conn->prepare("UPDATE waste_reports SET user_notified = 1 WHERE username = ? AND user_notified = 0");
$update_user->bind_param("s", $username);
$update_user->execute();

// Mark admin notifications as read
$update_admin = $conn->prepare("UPDATE user_admin_notifications SET is_read = 1 WHERE username = ?");
$update_admin->bind_param("s", $username);
$update_admin->execute();

$update_payments = $conn->prepare("UPDATE notifications SET is_read = 1 WHERE email = ?");
$update_payments->bind_param("s", $email);
$update_payments->execute();




$conn->close();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Your Notifications</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f1f1f1;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 600px;
            margin: 40px auto;
            background: white;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            border-radius: 8px;
            padding: 20px;
        }
        .header {
            border-bottom: 1px solid #ddd;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
            font-size: 22px;
            color: #333;
        }
        .notification {
            display: flex;
            align-items: flex-start;
            margin-bottom: 10px;
            padding: 15px;
            border-radius: 6px;
            background: #f9f9f9;
        }
        .notification-icon {
            font-size: 24px;
            margin-right: 15px;
            color: #007BFF;
        }
        .notification-content {
            flex-grow: 1;
        }
        .notification-time {
            font-size: 12px;
            color: #888;
            margin-top: 5px;
        }
        .no-notifications {
            text-align: center;
            color: #888;
            font-size: 16px;
        }
        /* Bell Icon and Unread Count */
        .bell-icon {
            position: relative;
            font-size: 30px;
            cursor: pointer;
        }
        .unread-count {
            position: absolute;
            top: -5px;
            right: -10px;
            background-color: red;
            color: white;
            border-radius: 50%;
            padding: 5px 10px;
            font-size: 14px;
        }
    </style>
</head>
<body>
<div class="container">
    <div class="header">
        <h2>🔔 Notifications</h2>
    </div>

    <!-- Bell Icon with Unread Count -->
    <div class="bell-icon">
        <span class="bell"></span>
        <?php if ($total_unread > 0): ?>
            <span class="unread-count"><?= $total_unread ?></span>
        <?php endif; ?>
    </div>

    <?php if (count($all_notifications) > 0): ?>
        <?php foreach ($all_notifications as $note): ?>
            <?php
                $isUnread = $note['user_notified'] == 0;
                $style = $isUnread ? "background-color: #dff0d8;" : "background-color: #f9f9f9;";?>

              
            <div class="notification" style="<?= $style ?>">
                <div class="notification-icon">
                   <?= $note['source'] === 'admin' ? '📣' : ($note['source'] === 'payments' ? '💰' : '📢') ?>

                </div>
                <div class="notification-content">
                    <strong><?= htmlspecialchars($note['message']) ?></strong>
                    <div class="notification-time">
                        <?= date("F j, Y, g:i a", strtotime($note['notification_time'])) ?>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="no-notifications">You have no new notifications.</div>
    <?php endif; ?>
</div>
</body>
</html>
