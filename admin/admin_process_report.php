<?php
$conn = new mysqli("localhost", "root", "", "wmsp"); 

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'] ?? '';
    $status = $_POST['status'] ?? '';

    if (!empty($username) && !empty($status)) {
        // Update report status
        $updateStmt = $conn->prepare("UPDATE collector_reports SET status = ? WHERE username = ? AND status = 'pending'");
        $updateStmt->bind_param("ss", $status, $username);
        if ($updateStmt->execute()) {
            // Insert notification for collector
            $title = "Report Status";
            $message = "Your bin issue report has been " . $status . ".";
            $stmt = $conn->prepare("INSERT INTO collector_notifications (title, message, username) VALUES (?, ?, ?)");
            $stmt->bind_param("sss", $title, $message, $username);
            $stmt->execute();
            echo "Report successfully $status and notification sent.";
        } else {
            echo "Error updating report status.";
        }
    } else {
        echo "Invalid request. Missing data.";
    }
} else {
    echo "Invalid request method.";
}
?>
