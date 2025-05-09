<?php
// 1) Read address from URL
if (isset($_GET['address']) && trim($_GET['address']) !== '') {
    $address = urldecode($_GET['address']);
} else {
    echo "<script>
            alert('Address is required to view requests.');
            window.location.href='view_requests.php';
          </script>";
    exit();
}

// 2) Connect to the database
$conn = new mysqli("localhost", "root", "", "wmsp");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// 3) Fetch approved requests matching this address
$sql = "SELECT * FROM waste_collection_requests WHERE status = 'approved' AND collector_address = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $address);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Collector Requests for <?= htmlspecialchars($address) ?></title>
    <style>
        table { border-collapse: collapse; width: 100%; }
        th, td { padding: 8px; border: 1px solid #ccc; }
        button { padding: 4px 8px; }
    </style>
</head>
<body>
    <h2>Approved Requests for: <?= htmlspecialchars($address) ?></h2>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Address</th>
                <th>Waste Type</th>
                <th>Pickup Date</th>
                <th>Phone</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if ($result->num_rows === 0): ?>
                <tr><td colspan="5">No approved requests for this address.</td></tr>
            <?php else: ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?= htmlspecialchars($row['name']) ?></td>
                    <td><?= htmlspecialchars($row['address']) ?></td>
                    <td><?= htmlspecialchars($row['waste_type']) ?></td>
                    <td><?= htmlspecialchars($row['pickup_date']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td>
                    <form method="POST" action="update_status.php">
    <input type="hidden" name="id" value="<?= $row['id'] ?>">
    <input type="hidden" name="address" value="<?= htmlspecialchars($address) ?>">
    <button type="submit" name="action" value="complete">
        Mark as Completed
    </button>
</form>

                    </td>
                </tr>
                <?php endwhile; ?>
            <?php endif; ?>
        </tbody>
    </table>
</body>
</html>

<?php
$stmt->close();
$conn->close();
?>
