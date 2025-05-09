<?php
$host = "localhost";
$user = "root";
$pass = "";
$db = "wmsp";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) die("Connection failed: " . $conn->connect_error);

// Fetch pending requests
$requestResult = $conn->query("SELECT * FROM waste_collection_requests WHERE status = 'pending' ORDER BY created_at DESC");
$collectorResult = $conn->query("SELECT id, address FROM wastecollector");

$collectors = [];
while ($row = $collectorResult->fetch_assoc()) {
    $collectors[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin - Manage Requests</title>
</head>
<body>
    <h2>Pending Requests</h2>
    <table border="1">
        <tr>
            <th>Name</th><th>Address</th><th>Assign Collector</th><th>Action</th>
        </tr>
        <?php while($row = $requestResult->fetch_assoc()): ?>
        <tr>
            <form action="process_request.php" method="POST">
                <td><?= $row['name'] ?></td>
                <td><?= $row['address'] ?></td>
                <td>
                    <select name="collector_id" required>
                        <option value="">-- Select --</option>
                        <?php foreach ($collectors as $c): ?>
                            <option value="<?= $c['id'] ?>"><?= $c['address'] ?> (ID: <?= $c['id'] ?>)</option>
                        <?php endforeach; ?>
                        <option value="">  None </option>
                    </select>
                </td>
                <td>
                    <input type="hidden" name="request_id" value="<?= $row['id'] ?>">
                    <button name="action" value="approve">Approve</button>
                    <button name="action" value="reject">Reject</button>
                </td>
            </form>
        </tr>
        <?php endwhile; ?>
    </table>
</body>
</html>
