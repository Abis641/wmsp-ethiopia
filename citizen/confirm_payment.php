<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "wmsp";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name    = $_POST['name'];
    $email   = $_POST['email'];
    $phone   = $_POST['phone'];
    $payment_method  = $_POST['payment_method'];
    $amount  = $_POST['money'];
   $photo_path = "";

if (isset($_FILES['photo']) && $_FILES['photo']['error'] == 0) {
    $uploadDir = "uploads/";
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0777, true);
    }

    $photoName = basename($_FILES['photo']['name']);
    $targetPath = $uploadDir . $photoName;

    if (move_uploaded_file($_FILES['photo']['tmp_name'], $targetPath)) {
        $photo_path = $targetPath;
    } else {
        echo "Error: Failed to upload image.";
        exit;
    }
}


    $sql = "INSERT INTO payments (full_name, email, phone, payment_method, amount,photo_path)
            VALUES (?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssds", $name, $email, $phone, $payment_method, $amount, $photo_path);

    if ($stmt->execute()) {
        $message = "<p style='color:green;'>✅ sent successfully we will send a notification that u are confirmed</p>";
       
    } else {
        $message = "<p style='color:red;'>❌ Please try again.</p>";
    }
     echo $message;

    $stmt->close();
    $conn->close();
}

?>
