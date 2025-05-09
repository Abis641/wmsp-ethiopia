<?php
// signup.php
session_start();

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "wmsp";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Function to check if username exists in any user table
function isUsernameTaken($conn, $username) {
    $tables = ['users', 'wastecollector', 'admins'];
    foreach ($tables as $table) {
        $sql = "SELECT id FROM $table WHERE username = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return true;
        }
    }
    return false;
}

// Handle Sign Up
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'], $_POST['password'])) {

    $firstname = $_POST['firstName'];
    $lastname = $_POST['lastName'];
    $username = trim($_POST['username']);
    $email = $_POST['email'];
    $address = $_POST['Address'];
    $password = $_POST['password'];
    
    if (strlen($password) < 8 || strlen($password) > 12) {
        echo "<script>alert('Password must be between 8 and 12 characters.'); window.location.href='login.html';</script>";
        exit();
    }
    
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    // Global username check
    if (isUsernameTaken($conn, $username)) {
        echo "<script>alert('Username already exists across the system. Please choose another one.'); window.location.href='login.html';</script>";
        exit();
    }

    // Proceed with signup
    $sql = "INSERT INTO users (first_name, last_name, username,email, address,  password) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssss", $firstname, $lastname, $username,  $email, $address, $hashedPassword);

    if ($stmt->execute()) {
        echo "<script>alert('Signup successful!'); window.location.href='login.html';</script>";
    } else {
        echo "<script>alert('Signup failed. Please try again.'); window.location.href='login.html';</script>";
    }
    exit();
}
?>
