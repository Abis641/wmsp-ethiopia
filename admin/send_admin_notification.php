<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "wmsp";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
   
    $message = $_POST["notificationMessage"];
    
    // Step 1: Insert the notification
    $sql = "INSERT INTO admin_notifications (title, message) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $title, $message);

    if ($stmt->execute()) {
        // Step 2: Get the newly inserted notification ID
        $admin_id = $conn->insert_id;

        // Step 3: Fetch all usernames
        $user_query = $conn->query("SELECT username FROM users"); // <-- update if your table name is different

        // Step 4: Insert a row for each user into user_admin_notifications
        while ($user = $user_query->fetch_assoc()) {
            $insert_stmt = $conn->prepare("INSERT INTO user_admin_notifications (admin_notification_id, username) VALUES (?, ?)");
            $insert_stmt->bind_param("is", $admin_id, $user['username']);
            $insert_stmt->execute();
            $insert_stmt->close();
        }

        echo "Notification sent to all users!";
    } else {
        echo "Failed to send notification.";
    }

    $stmt->close();
    $conn->close();
}
?>
