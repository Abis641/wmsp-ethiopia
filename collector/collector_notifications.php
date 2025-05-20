<?php
session_start();
if (!isset($_SESSION['username'])) {
    die("Unauthorized");
}

$wastecollector = $_SESSION['username'];
$conn = new mysqli("localhost", "root", "", "wmsp");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "
    SELECT cn.id, cn.title, cn.message, cn.notification_time, cn.read_status
    FROM collector_notifications cn
    WHERE cn.username = ?
    ORDER BY cn.notification_time DESC
";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $wastecollector);
$stmt->execute();
$result = $stmt->get_result();

$notifications = [];
while ($row = $result->fetch_assoc()) {
    $notifications[] = $row;
}

$stmt->close();
$updateStmt = $conn->prepare("UPDATE collector_notifications SET read_status = 1 WHERE username = ?");
$updateStmt->bind_param("s", $wastecollector);
$updateStmt->execute();
$updateStmt->close();

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Collector Notifications</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #f5f7fa;
      padding: 20px;
    }

    .notification-container {
      max-width: 600px;
      margin: auto;
    }

    .notification {
      display: flex;
      flex-direction: column;
      background: #fff;
      border-radius: 12px;
      padding: 15px 20px;
      margin-bottom: 15px;
      box-shadow: 0 2px 8px rgba(0,0,0,0.05);
      transition: background 0.3s;
      border-left: 6px solid transparent;
    }

    .notification.unread {
      background: #e6f7ff;
      border-left-color: #007bff;
    }

    .notification h4 {
      margin: 0 0 5px;
      font-size: 18px;
      color: #333;
    }

    .notification p {
      margin: 0 0 10px;
      color: #555;
    }

    .notification .time {
      font-size: 12px;
      color: #888;
      text-align: right;
    }
  </style>
</head>
<body>
  <div class="notification-container">
    <h2>Your Notifications</h2>

    <?php if (empty($notifications)): ?>
      <p>No notifications yet.</p>
    <?php else: ?>
      <?php foreach ($notifications as $note): ?>
        <div class="notification <?php echo $note['read_status'] == 0 ? 'unread' : ''; ?>">
          <h4><?php echo htmlspecialchars($note['title']); ?></h4>
          <p><?php echo htmlspecialchars($note['message']); ?></p>
          <div class="time"><?php echo date("M d, Y h:i A", strtotime($note['notification_time'])); ?></div>
        </div>
      <?php endforeach; ?>
    <?php endif; ?>
  </div>
</body>
</html>
