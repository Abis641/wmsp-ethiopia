<?php
$host = "localhost";
$user = "root";
$pass = "";
$db   = "wmsp";

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM waste_reports ORDER BY report_date DESC";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html>
<head>
  <title>Admin - View Reports</title>
  <style>
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 10px;
      border: 1px solid #ccc;
      text-align: left;
    }
    th {
      background-color: #f2f2f2;
    }
    .action-btn {
      margin-right: 5px;
    }
  </style>
</head>
<body>

  <h2>Submitted Waste Reports</h2>

  <table>
    <thead>
      <tr>
        <th>ID</th>
        <th>Name</th>
        <th>Phone</th>
        <th>Issue Type</th>
        <th>Address</th>
        <th>Date</th>
        <th>Details</th>
        <th>Photo</th>
        <th>Status</th>
        <th>User Notified</th> <!-- Added this column -->
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php if ($result->num_rows > 0): ?>
        <?php while ($row = $result->fetch_assoc()): ?>
          <tr>
            <td><?= $row['id'] ?></td>
            <td><?= htmlspecialchars($row['username']) ?></td>
            <td><?= htmlspecialchars($row['phone']) ?></td>
            <td><?= htmlspecialchars($row['issue_type']) ?></td>
            <td><?= htmlspecialchars($row['address']) ?></td>
            <td><?= htmlspecialchars($row['report_date']) ?></td>
            <td><?= htmlspecialchars($row['report_details']) ?></td>
            <td>
              <?php if ($row['photo_path']): ?>
                <a href="\WMSP\citizen\<?= $row['photo_path'] ?>" target="_blank">View</a>
              <?php else: ?>
                No photo
              <?php endif; ?>
            </td>
            <td><?= htmlspecialchars($row['status']) ?></td>
            <td><?= $row['user_notified'] == 1 ? 'Yes' : 'No' ?></td> <!-- User notified status -->
            <td>
              <?php if ($row['status'] == 'Pending'): ?>
                <form action="take_action.php" method="POST" style="display:inline-block;">
                  <input type="hidden" name="report_id" value="<?= $row['id'] ?>">
                  <input type="hidden" name="status" value="Approved">
                  <input type="hidden" name="collector_id" value="1"> <!-- Replace with actual collector ID dynamically -->
                  <button type="submit" class="action-btn">Approve</button>
                </form>

                <form action="take_action.php" method="POST" style="display:inline-block;">
                  <input type="hidden" name="report_id" value="<?= $row['id'] ?>">
                  <input type="hidden" name="status" value="Rejected">
                  <input type="hidden" name="collector_id" value="0"> <!-- No collector for rejection -->
                  <button type="submit" class="action-btn">Reject</button>
                </form>
              <?php else: ?>
                <em><?= $row['status'] ?></em>
              <?php endif; ?>
            </td>
          </tr>
        <?php endwhile; ?>
      <?php else: ?>
        <tr><td colspan="11">No reports found.</td></tr>
      <?php endif; ?>
    </tbody>
  </table>

</body>
</html>

<?php $conn->close(); ?>
