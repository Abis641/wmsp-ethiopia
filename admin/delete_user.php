<?php
$conn = new mysqli("localhost", "root", "", "wmsp");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$id = $_POST['id'] ?? '';
$role = $_POST['role'] ?? '';
$table = $role === 'citizen' ? 'users' : ($role === 'collector' ? 'wastecollector' : '');

if (!$id || !$table) {
    die("Missing data for deletion.");
}

$stmt = $conn->prepare("DELETE FROM $table WHERE id = ?");
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    echo "User removed successfully.<br><a href='admin.php'>Back to Admin Page</a>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
