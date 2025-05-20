<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "wmsp";  

$conn = new mysqli($host, $user, $pass, $db);  // ✅ db included
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
// echo "Connected successfully"; // Optional
?>
