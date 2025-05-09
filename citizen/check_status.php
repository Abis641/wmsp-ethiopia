<?php
session_start();

// Check if user is logged in
if (!isset($_SESSION['email'])) {
    echo "<script>alert('Please login first.'); window.location.href='login.html';</script>";
    exit();
}

$email = $_SESSION['email'];

// Connect to database
$conn = new mysqli("localhost", "root", "", "wmsp");
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Fetch most recent request by email
$sql = "SELECT status FROM waste_collection_requests WHERE email = ? ORDER BY created_at DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $email);
$stmt->execute();
$result = $stmt->get_result();

$status = "no_request";
if ($row = $result->fetch_assoc()) {
    $status = $row['status'];
}

$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html>
<head><title>Request Status</title></head>
<body>
    <h2>Request Status</h2>
    <?php if ($status === 'approved'): ?>
        <p style="color: green;">✅ Your request has been approved and is being processed.</p>
    <?php elseif ($status === 'rejected'): ?>
        <p style="color: red;">❌ Sorry, your request was rejected.</p>
    <?php elseif ($status === 'completed'): ?>
        <p style="color: blue;">🎉 Your request was successfully completed.</p>
    <?php else: ?>
        <p>waiting for approval </p>
    <?php endif; ?>
    <a href="user.php">Back to home</a>
</body>
</html>
