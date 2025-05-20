<?php
// signin.php
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

// Handle Sign In
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['username']) && !isset($_POST['firstName'])) {
    $username = trim($_POST['username']);
    $passwordInput = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username = ?";
    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();
        if (password_verify($passwordInput, $user['password'])) {
            $_SESSION['user'] = $user['username'];
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['phone'] = $row['phone'];
            $_SESSION['username'] = $username; 

            header("Location: user.php");
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
