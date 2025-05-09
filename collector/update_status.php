<?php
$conn = new mysqli("localhost", "root", "", "wmsp");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if (isset($_POST['id'], $_POST['action']) && $_POST['action'] === 'complete') {
    $id = (int) $_POST['id'];

    $sql = "UPDATE waste_collection_requests SET status='completed' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    if ($stmt) {
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    }
}

$conn->close();
$encodedAddress = urlencode($_POST['address']);
header("Location: view_requests.php?address=$encodedAddress");
exit();
?>
