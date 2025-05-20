<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "wmsp"; 

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

session_start();
$username = $_POST['username'];

$phone = $_POST['phone'];
$issueType    = $_POST['issueType'];
$address      = $_POST['address'];
$reportDate   = $_POST['ReportDate'];
$reportDetail = $_POST['reportDetails'];

$photoPath = "";

if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $photoName = basename($_FILES['photo']['name']);
    $targetPath = $uploadDir . $photoName;

    if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
        $photoPath = $targetPath;
    } else {
        echo "Error: Failed to upload image.";
        exit;
    }
}

$conn = new mysqli("localhost", "root", "", "wmsp");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "INSERT INTO waste_reports (username, phone, issue_type, address, report_date, report_details, photo_path, status)
        VALUES (?, ?, ?, ?, ?, ?, ?, 'Pending')";

$stmt = $conn->prepare($sql);
$stmt->bind_param("sssssss", $username, $phone, $issueType, $address, $reportDate, $reportDetail, $photoPath);

if ($stmt->execute()) {
    echo "<script>alert('Your reports has been submitted successfully!'); window.location.href='user.php';</script>";
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();

?>
