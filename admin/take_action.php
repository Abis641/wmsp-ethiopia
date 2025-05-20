<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "wmsp";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['report_id'];
    $status = $_POST['status'];
    $collector_id = $_POST['collector_id'];
    $now = date('Y-m-d H:i:s');

    // Fetch the phone number of the user from the report
    $sql = "SELECT phone FROM waste_reports WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $phone = $row['phone'];

    // Set the notification message
    $message = ($status === 'Approved') 
        ? "We saw your report, we will fix it soon." 
        : "Sorry, your report is rejected.";

    // Update query based on whether the report is approved or rejected
    if ($collector_id == 0 || empty($collector_id)) {
        $sql = "UPDATE waste_reports 
                SET status = ?, collector_id = NULL, user_notified = 0, notification_message = ? ,notification_time = ? 
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $status, $message, $now,$id);
    } else {
        $sql = "UPDATE waste_reports 
                SET status = ?, collector_id = ?, user_notified = 0, notification_message = ? ,notification_time = ? 
                WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sissi", $status, $collector_id, $message, $now, $id);
    }
    

    if ($stmt->execute()) {
        
        // Redirect back to the reports page with a success message
        echo "<script>alert('Report has been $status successfully.'); window.location.href='view_reports.php';</script>";
    } else {
        echo "<script>alert('Error performing action.'); window.history.back();</script>";
    }
}
?>
