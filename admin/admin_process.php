<?php
$conn = new mysqli("localhost", "root", "", "wmsp");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$role = $_POST['role'] ?? '';
if (empty($role)) {
    die("Role is required.");
}

$id = $_POST['id'] ?? '';
$firstName = trim($_POST['first_name'] ?? '');
$lastName = trim($_POST['last_name'] ?? '');
$username = trim($_POST['username'] ?? '');
$email = trim($_POST['email'] ?? '');
$address = trim($_POST['address'] ?? '');
$rawPassword = $_POST['password'] ?? '';

if (empty($id) || !$firstName || !$lastName || !$username || !$email || !$address) {
    die("All fields except password are required for update.");
}

$table = ($role === 'citizen') ? 'users' : 'wastecollector';

// Handle password: keep old password if empty, else hash new password
if (empty($rawPassword)) {
    $result = $conn->query("SELECT password FROM $table WHERE id = " . intval($id));
    if ($result && $row = $result->fetch_assoc()) {
        $password = $row['password'];
    } else {
        die("User not found.");
    }
} else {
    $password = password_hash($rawPassword, PASSWORD_DEFAULT);
}

if ($role === 'citizen') {
    $phone = trim($_POST['phone'] ?? '');
    if (empty($phone)) {
        die("Phone is required for citizens.");
    }
    $stmt = $conn->prepare("UPDATE users SET first_name=?, last_name=?, username=?, email=?, address=?, password=?, phone=? WHERE id=?");
    $stmt->bind_param("sssssssi", $firstName, $lastName, $username, $email, $address, $password, $phone, $id);
} else {
    $stmt = $conn->prepare("UPDATE wastecollector SET firstname=?, lastname=?, username=?, email=?, address=?, password=? WHERE id=?");
    $stmt->bind_param("ssssssi", $firstName, $lastName, $username, $email, $address, $password, $id);
}

if ($stmt->execute()) {
    echo "User updated successfully.<br><a href='admin.php'>Back to Admin Page</a>";
} else {
    echo "Error: " . $stmt->error;
}
$stmt->close();
$conn->close();
?>
