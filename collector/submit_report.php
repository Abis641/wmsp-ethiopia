<?php
$conn = new mysqli("localhost", "root", "", "wmsp");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$username = $_POST['username'] ?? '';
$binLocation = $_POST['binLocation'] ?? '';
$issueDescription = $_POST['issueDescription'] ?? '';

if (!$username || !$binLocation || !$issueDescription) {
    die("All fields are required.");
}

$stmt = $conn->prepare("INSERT INTO collector_reports (collector_username, bin_location, issue_description) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $username, $binLocation, $issueDescription);

if ($stmt->execute()) {
    echo "Report submitted successfully.";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
