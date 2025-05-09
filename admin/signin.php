<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);

// Database connection
$host = "localhost";
$user = "root";
$password = "";
$dbname = "wmsp";

$conn = new mysqli($host, $user, $password, $dbname);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handle Sign In
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username'], $_POST['password'])) {
    $username = trim($_POST['username']);
    $passwordInput = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE username = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("MySQL prepare error: " . $conn->error);
    }
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        $storedPassword = $user['password'];

        // Verify password
        if (password_verify($passwordInput, $storedPassword) || $passwordInput === $storedPassword) {
            $_SESSION['user'] = $user['username'];
            header("Location: admin.php");
            exit();
        } else {
            echo "<script>alert('Incorrect password. Please try again.'); window.location.href='login.html';</script>";
            exit();
        }
    } else {
        echo "<script>alert('Username not found. Please check your input.'); window.location.href='login.html';</script>";
        exit();
    }
}
?>
