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
    $requestId   = (int) $_POST['request_id'];
    $action      = $_POST['action'];

    if ($action === "approve" && !empty($_POST['collector_id'])) {
        // 1) Grab collector_id from POST
        $collectorId = (int) $_POST['collector_id'];

        // 2) Look up that collector’s address
        $stmt = $conn->prepare("SELECT address FROM wastecollector WHERE id = ?");
        $stmt->bind_param("i", $collectorId);
        $stmt->execute();
        $result    = $stmt->get_result();
        $collector = $result->fetch_assoc();
        $collectorAddress = $collector['address'];
        $stmt->close();

        // 3) Approve the request, assign collector_id + collector_address
        $update = $conn->prepare("
    UPDATE waste_collection_requests
    SET status = 'approved',
        collector_id = ?,
        collector_address = ?
    WHERE id = ?
");
$update->bind_param("isi", $collectorId, $collectorAddress, $requestId);

        $update->execute();
        $update->close();

        echo "<script>
                alert('Request approved and assigned.');
                window.location.href='admin.php';
              </script>";
        exit();

    } elseif ($action === "reject") {
        // Reject without assignment
        $update = $conn->prepare("
            UPDATE waste_collection_requests
            SET status = 'rejected'
            WHERE id = ?
        ");
        $update->bind_param("i", $requestId);
        $update->execute();
        $update->close();

        echo "<script>
                alert('Request rejected.');
                window.location.href='admin.php';
              </script>";
        exit();

    } else {
        echo "<script>
                alert('Please select a collector before approving.');
                window.location.href='admin.php';
              </script>";
        exit();
    }
}
?>
