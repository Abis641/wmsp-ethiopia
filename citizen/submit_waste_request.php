<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "wmsp";  

$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $wasteType = mysqli_real_escape_string($conn, $_POST['wasteType']);
    $pickupDate = mysqli_real_escape_string($conn, $_POST['pickupDate']);

    // Insert data into database
    $sql = "INSERT INTO waste_collection_requests (name, email, phone, address, waste_type, pickup_date) 
            VALUES ('$name', '$email', '$phone', '$address', '$wasteType', '$pickupDate')";

    if ($conn->query($sql) === TRUE) {
        echo  "<script>alert('Your request has been submitted successfully!'); window.location.href='user.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>
