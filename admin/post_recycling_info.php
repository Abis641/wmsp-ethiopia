<?php
$conn = new mysqli("localhost", "root", "", "wmsp");
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}

$title = $_POST['campaignTitle'];
$content = $_POST['campaignContent'];
$audience = $_POST['targetAudience'];

// Step 1: Insert into recycling_info
$sql = "INSERT INTO recycling_info (title, content, target_audience) VALUES (?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sss", $title, $content, $audience);

if ($stmt->execute()) {
  // Step 2: Create admin notification
  $notifTitle = "Recycling Info Posted";
  $notifMessage = "A new recycling information has been posted. Check it out.";
  date_default_timezone_set("Africa/Addis_Ababa");
  $notifTime = date("Y-m-d H:i:s");
  $readStatus = 0;

  $notifSql = "INSERT INTO admin_notifications (title, message, notification_time, read_status) VALUES (?, ?, ?, ?)";
  $notifStmt = $conn->prepare($notifSql);
  $notifStmt->bind_param("sssi", $notifTitle, $notifMessage, $notifTime, $readStatus);
  $notifStmt->execute();
  $notifStmt->close();

  // Step 3: If target audience includes Collectors, add to collector_notifications
  if ($audience === "Collectors" || $audience === "All") {
    // Fetch all collector usernames
    $collectorsResult = $conn->query("SELECT username FROM wastecollector");
    $insertStmt = $conn->prepare("
      INSERT INTO collector_notifications (title, message, notification_time, read_status, username)
      VALUES (?, ?, ?, ?, ?)
    ");
    
    while ($row = $collectorsResult->fetch_assoc()) {
      $collectorUsername = $row['username'];
      $insertStmt->bind_param("sssis", $notifTitle, $notifMessage, $notifTime, $readStatus, $username);
      $insertStmt->execute();
    }
    
    $insertStmt->close();
  }

  echo "Recycling information and notifications posted successfully.";
} else {
  echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
